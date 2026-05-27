<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Events\CallInitiated;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // SHOW CHAT PAGE
    public function index($user_id)
    {
        Message::where('sender_id', $user_id)
            ->where('receiver_id', Auth::id())
            ->update(['is_read' => 1]);

        $messages = Message::where(function ($q) use ($user_id) {
                $q->where('sender_id', Auth::id())
                  ->where('receiver_id', $user_id);
            })
            ->orWhere(function ($q) use ($user_id) {
                $q->where('sender_id', $user_id)
                  ->where('receiver_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $otherUser = User::findOrFail($user_id);

        return view('chat.index', compact('messages', 'otherUser'));
    }

    // SEND MESSAGE
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message'     => 'nullable|string|max:1000',
            'file'        => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,doc,docx,mp3,wav,webm,ogg',
        ]);

        if (!$request->message && !$request->hasFile('file')) {
            return response()->json(['error' => 'Please send a message or attach a file.'], 422);
        }

        $path = null;

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('medical_reports', 'public');
        }

        $message = Message::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message'     => $request->message,
            'file'        => $path,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['success' => true, 'message' => $message]);
    }

    // INITIATE CALL
    public function initiateCall(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'call_type'   => 'required|in:video,audio,answered',
        ]);

        broadcast(new CallInitiated(
            auth()->id(),
            $request->receiver_id,
            $request->call_type
        ));

        return response()->json(['status' => 'ringing']);
    }

    // WEBRTC SIGNAL — relay offer / answer / ICE candidates
    public function signal(Request $request)
    {
        $request->validate([
            'to_id'   => 'required|exists:users,id',
            'type'    => 'required|in:offer,answer,ice',
            'payload' => 'required|array',
        ]);

        broadcast(new \App\Events\WebRTCSignal(
            auth()->id(),
            $request->to_id,
            $request->type,
            $request->payload
        ));

        return response()->json(['status' => 'ok']);
    }

    // DOCTOR INBOX
    public function doctorInbox()
    {
        $userId = Auth::id();

        $userIds = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->get()
            ->map(fn($m) => $m->sender_id == $userId ? $m->receiver_id : $m->sender_id)
            ->unique()
            ->values();

        $users = User::whereIn('id', $userIds)->get();

        return view('doctor.messages', compact('users'));
    }
}
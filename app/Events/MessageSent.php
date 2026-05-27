<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Models\Message;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Message $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('chat.' . $this->message->receiver_id),
            new Channel('chat.' . $this->message->sender_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    public function broadcastWith(): array
    {
        return [
            'message' => [
                'id'          => $this->message->id,
                'message'     => $this->message->message,
                'file'        => $this->message->file,
                'sender_id'   => $this->message->sender_id,
                'receiver_id' => $this->message->receiver_id,
                'created_at'  => $this->message->created_at->format('H:i'),
            ],
        ];
    }
}
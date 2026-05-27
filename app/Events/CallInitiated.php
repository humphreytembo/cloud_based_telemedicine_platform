<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;

class CallInitiated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $callerId;
    public int $receiverId;
    public string $callType;

    public function __construct(int $callerId, int $receiverId, string $callType)
    {
        $this->callerId   = $callerId;
        $this->receiverId = $receiverId;
        $this->callType   = $callType;
    }

    public function broadcastOn(): array
    {
        return [
            // Receiver gets the incoming call notification
            new Channel('chat.' . $this->receiverId),
            // Caller gets notified when call is answered
            new Channel('chat.' . $this->callerId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'call.incoming';
    }

    public function broadcastWith(): array
    {
        return [
            'caller_id'   => $this->callerId,
            'receiver_id' => $this->receiverId,
            'call_type'   => $this->callType,
        ];
    }
}
<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;

class WebRTCSignal implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int    $fromId;
    public int    $toId;
    public string $type;   // 'offer' | 'answer' | 'ice'
    public array  $payload;

    public function __construct(int $fromId, int $toId, string $type, array $payload)
    {
        $this->fromId  = $fromId;
        $this->toId    = $toId;
        $this->type    = $type;
        $this->payload = $payload;
    }

    public function broadcastOn(): array
    {
        // Only broadcast to the recipient
        return [new Channel('chat.' . $this->toId)];
    }

    public function broadcastAs(): string
    {
        return 'webrtc.signal';
    }

    public function broadcastWith(): array
    {
        return [
            'from_id' => $this->fromId,
            'to_id'   => $this->toId,
            'type'    => $this->type,
            'payload' => $this->payload,
        ];
    }
}
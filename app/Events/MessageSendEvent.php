<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSendEvent implements ShouldBroadcastNow {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function broadcastOn(): array {
        return [
            new PrivateChannel("chat-room.{$this->data->room_id}"),
            new PrivateChannel("chat-receiver.{$this->data->receiver_id}"),
            new PrivateChannel("chat-sender.{$this->data->sender_id}")
        ];
    }
}


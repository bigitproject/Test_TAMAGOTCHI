<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PublicChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    protected $status;
    protected $message;
    protected $user_id;

    public function __construct($stat, $mes, $user_id)
    {
        $this->status = $stat;
        $this->message = $mes;
        $this->user_id = $user_id;
    }

    public function broadcastWith()
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'user_id' => $this->user_id,
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('App.User.'.$this->user_id);
        //return new Channel('App.User.1');
    }
}

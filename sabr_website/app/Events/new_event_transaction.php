<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class new_event_transaction implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $message , $user_id , $notification_id;
    public function __construct($message , $user_id , $notification_id)
    {
        $this->message=$message;
        $this->user_id=$user_id;
        $this->notification_id=$notification_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        /*  Broadcast::channel('App.User.*', function ($user) {
            return $user;
        }); */
        return new PrivateChannel('App.User.'.$this->user_id);
    }
    public function broadcastAs()
    {
        return 'transaction';
    }
}

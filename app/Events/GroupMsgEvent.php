<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GroupMsgEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    
    public $message;
    public $groupId;
    public $userId;
    public $chatId;
    public $chatTime;
    public $from;
    public function __construct($message, $groupId,$userId, $chatId, $chatTime, $from)
    {
        
        $this->message = $message;
        $this->groupId = $groupId;
        $this->userId = $userId;
        $this->chatId = $chatId;
        $this->chatTime = $chatTime;
        $this->from = $from;
        

       
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('group.'.$this->groupId);
    }
}

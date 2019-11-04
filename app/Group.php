<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    protected $guarded = [];
    public function groupChats()
    {
        return $this->hasManyThrough(GroupChat::class, GroupMessage::class);
        // dùng hasManyThrough vì group có nhiều message
        // và message có nhiều chat, nên group có nhiều chat qa message
    }

    public function groupMessages()//viết số nhìu vì trả về nhìu message
    {
        return $this->hasMany(GroupMessage::class);
    }

    public function members()
    {
        return $this->belongsToMany('App\User');
        //mỗi user có nhiều group và mỗi group có nhiều user nên dùng belongsToMany-
    }

    public function recieveChats()
    {
        $chats = $this->groupChats->where('read_at',null)
                                    ->where('type', 1)
                                    ->where('user_id', auth()->id());
        return $chats;
    }

    public function sendChats() 
    {
        $arrays = $this->recieveChats();
        $results = $arrays->map( function ($array) {
            $chat = GroupChat::where('group_message_id', $array->group_message_id)
                                ->where('type', 0)
                                ->where('read_at',null);
            return $chat;
        });
        return $results;
    }

    

}

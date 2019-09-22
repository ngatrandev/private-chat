<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    //
    public function chats()
    {
        return $this->hasManyThrough(Chat::class, Message::class);
        // dùng hasManuThrough vì session có nhiều message
        // và message có nhiều chat, nên session có nhiều chat qa message
    }

    public function messages()//viết số nhìu vì trả về nhìu message
    {
        return $this->hasMany(Message::class);
    }
}

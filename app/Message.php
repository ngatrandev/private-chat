<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $guarded = [];

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}

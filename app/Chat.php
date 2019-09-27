<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    //
    protected $guarded = [];
    public function message()//không viết số nhìu vì chỉ trả về 1 message
    {
        return $this->belongsTo(Message::class);
    }
}

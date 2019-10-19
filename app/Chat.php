<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    //
    protected $guarded = [];

    protected $casts = [
        'read_at'=> 'datetime'
    //do reat_at là thuộc tính về time được add thêm
    // không được mặc định như created_at...
    ];


    public function message()//không viết số nhìu vì chỉ trả về 1 message
    {
        return $this->belongsTo(Message::class);
    }

    
}

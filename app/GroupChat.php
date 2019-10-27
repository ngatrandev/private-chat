<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupChat extends Model
{
    //
    protected $guarded = [];

    protected $casts = [
        'read_at'=> 'datetime'
    //do reat_at là thuộc tính về time được add thêm
    // không được mặc định như created_at...
    ];


    public function groupMessage()//không viết số nhìu vì chỉ trả về 1 message
    {
        return $this->belongsTo(GroupMessage::class);
    }
}

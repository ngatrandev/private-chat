<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{
    //
    protected $guarded = [];

    public function groupChats()
    {
        return $this->hasMany(GroupChat::class);
    }
}

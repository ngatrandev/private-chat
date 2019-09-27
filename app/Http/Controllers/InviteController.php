<?php

namespace App\Http\Controllers;

use App\Invite;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InviteController extends Controller
{
    //
    public function store(User $user)
    {
        //'/invitations/{user}' user trên route sẽ trùng với $user qua id.
        $friend = User::whereEmail(request('email'))->first();
        Invite::create([
            'user_name'=>$user->name,
            'user_id'=>$user->id,
            'friend_id'=>$friend->id
        ]);

        //return về view home khi send req từ Vue
        if(request()->wantsJson()) {
            return ['message' => '/home/'];
        }
       

        return view('/home');
    }

    public function update(Invite $invite)
    {
        $invite->update(['accept'=>'1']);

        //return về view home khi send req từ Vue
        // if(request()->wantsJson()) {
        //     return ['message' => '/home/'];
        // }
       

        // return view('/home');
    }
}

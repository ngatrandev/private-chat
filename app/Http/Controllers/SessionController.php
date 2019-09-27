<?php

namespace App\Http\Controllers;

use App\Session;
use App\User;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    //
    public function store(User $user)
    {
        //'/user/{user}/s' user trên route sẽ trùng với $user qua id.
        $friend = User::whereEmail(request('email'))->first();
        Session::create([
            'user1_name'=>$user->name,
            'user1_id'=>$user->id,
            'user2_id'=>$friend->id
        ]);

        //return về view home khi send req từ Vue
        // if(request()->wantsJson()) {
        //     return ['message' => '/home/'];
        // }
       

        // không viết return để tránh refresh page
    }

    public function update(Session $session)    
    {
        $session->update(['accept'=>1]);
       
    }
    
   

}

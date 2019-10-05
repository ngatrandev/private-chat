<?php

namespace App\Http\Controllers;

use App\Events\AcceptEvent;
use App\Events\InviteEvent;
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

        $friendId = $friend->id;
        event(new InviteEvent($friendId))->toOthers();
        
        

        //return về view home khi send req từ Vue
        // if(request()->wantsJson()) {
        //     return ['message' => '/home/'];
        // }
       

        // không viết return để tránh refresh page
    }

    public function update(Session $session)    
    {
        $session->update(['accept'=>1]);

        event(new AcceptEvent($session->user1_id));
        event(new AcceptEvent($session->user2_id));
        //phát cùng lúc 2 event với id khác nhau
        //vì đây là 2 user cần cập nhật lại friendlist
       
    }
    
   

}

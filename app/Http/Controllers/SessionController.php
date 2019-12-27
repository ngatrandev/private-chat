<?php

namespace App\Http\Controllers;

use App\Events\AcceptEvent;
use App\Events\InviteEvent;
use App\Events\NotificationEvent;
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

        

        $session = Session::create([
            'user1_name'=>$user->name,
            'user1_id'=>$user->id,
            'user2_id'=>$friend->id
        ]);

        $user->notifications()->create([
            'content' => "You sent an invitation to '$friend->name'."]);
        event(new NotificationEvent($user->id));

        $friendId = $friend->id;
        event(new InviteEvent($friendId));
        
        
        

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

    public function decline(Session $session)    
    {
        $user=User::whereId($session->user1_id)->first();
        $friend=User::whereId($session->user2_id)->first();

        $user->notifications()->create([
            'content' => "'$friend->name' declined your invitation."]);
        event(new NotificationEvent($user->id));
        $session->delete();

        
       
    }
    
   

}

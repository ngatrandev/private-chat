<?php

namespace App\Http\Controllers;

use App\Events\ChatCreate;
use App\Http\Resources\GroupResource;
use App\Http\Resources\SessionResource;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

   
    public function index()
    {
        $user=Auth()->user();
       
        return view('home', compact('user'));
        
    }

    public function getInvites()
    {
        $user=Auth()->user();
      
        $invites = $user->invites();
        return  SessionResource::collection($invites) ;
    }

    public function getFriends()
    {
        $user=Auth()->user();
      
        $friends = $user->getFriends();
        return  UserResource::collection($friends);

    }

     /*
     Resource là 1 lớp ở giữa để tùy chỉnh lại data 
     giữa database và data show đến người dùng, 
     bản chất Resource không làm thay đổi data gốc
     Muốn dùng Resource phải qua API như trên
     */

    public function getGroups()
    {
        $user=Auth()->user();
      
        $groups = $user->groups();
        return  GroupResource::collection($groups);

    }

    public function getEmails()
    {
        $user=Auth()->user();
        $allEmails = User::all()->pluck('email');
        $friendEmails = $user->getFriends()->pluck('email');

        $diff1=$allEmails->diff($friendEmails);//loại những email đã kết bạn
        $diff2 = $diff1->diff($user->email);//loại email chính mình
       

        $inviteEmails = $user->getInviteUsers()->pluck('email');
        $result = $diff2->diff($inviteEmails);//loại những email đã gửi hoặc đã nhận lời mời kết bạn.

        return  $result;

    }
}

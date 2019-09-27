<?php

namespace App\Http\Controllers;

use App\Http\Resources\SessionResource;
use App\Http\Resources\UserResource;
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
}

<?php

namespace App\Http\Controllers;

use App\Events\GroupCreateEvent;
use App\Events\NotificationEvent;
use App\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    //
    public function create()
    {
        $group = Group::create(['name' => request('name'),
                                'admin_id'=>auth()->id()]);

        $users = collect(request('users'));//lưu ý cách dùng collect
        $users->push(auth()->id());

        $group->members()->attach($users);//dùng add database trong bảng group_user

       
        $groupName = $group->name;
        $admin=Auth::user()->name;
        $members = $group->members;
        foreach ($members as $member) {
            if ($member->id !== auth()->id()) {
                $member->notifications()->create([
                    'content' => "You were added in '$groupName'."
                ]);
                event(new NotificationEvent($member->id));
            } else {
                $member->notifications()->create([
                    'content' => "You've just created a group: '$groupName'."
                ]);
               
            }
        };
        foreach ($members as $member) {
        event(new GroupCreateEvent($member->id));
        };


        //Tạo tin chung (type=2) gửi vào group khác send, recieve
        $message = $group->groupMessages()->create([
                    'content'=>"$admin's just created a group: '$groupName'."]);
        
        foreach ($members as $member) {
            
                $message->groupChats()->create([
                    'group_id'=>$group->id,
                    'type'=>2,
                    'user_id'=>$member->id,
                    
                ]);
            
        }

        return $group;
    }
}

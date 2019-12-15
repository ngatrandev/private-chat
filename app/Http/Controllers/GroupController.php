<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Group;
use Illuminate\Http\Request;

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

        if(request()->wantsJson()) {
            return ['message' => '/home'];
        }


        return $group;
    }
}

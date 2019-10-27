<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    //
    public function create()
    {
        $group = Group::create(['name' => request('name'),
                                'admin_id'=>auth()->id()]);

        $users = collect(request('users'));
        $users->push(auth()->id());

        $group->members()->attach($users);


        return $group;
    }
}

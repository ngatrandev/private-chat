<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
    public function read(User $user)
    {
        return NotificationResource::collection($user->notifications()->latest()->get());
    }

    public function count(User $user)
    {
        return $user->notifications()->where('read', false)->count();
    }

    public function update(User $user)
    {
        $notifications = $user->notifications()->where('read', false)->get();

        foreach ($notifications as $notification) {
            $notification->update(['read'=>true]);
        }
    }
}

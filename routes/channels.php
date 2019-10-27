<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

use App\Group;
use App\Session;

Broadcast::channel('online', function ($user) {
       
            return['id'=>$user->id, 'name'=>$user->name];
//trong mỗi object chỉ trả về id và name để tinh gọn
      
});

Broadcast::channel('invite.{friendId}', function ($user, $friendId) {
       
    return $user->id == $friendId;
});

Broadcast::channel('accept.{userId}', function ($user, $userId) {
       
    return $user->id == $userId;
});

Broadcast::channel('message.{session}', function ($user, Session $session){
    if($user->id == $session->user1_id||$user->id == $session->user2_id) {
        return true;
    }
    return false;

    //do có add class Session nên {session} chính là id của $session
    // khác với cách viết {userId} ở channel trên
});

Broadcast::channel('group.{group}', function ($user, Group $group){
   $members = $group->members;
    foreach ($members as $member) {
        if ($member->id == $user->id) {
            return true;
        }
     }
    return false;


});



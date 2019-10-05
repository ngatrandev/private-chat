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


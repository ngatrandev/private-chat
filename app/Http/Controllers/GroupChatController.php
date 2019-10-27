<?php

namespace App\Http\Controllers;

use App\Events\GroupMsgEvent;
use App\Group;
use App\Http\Resources\GroupChatResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupChatController extends Controller
{
    //
    public function storeMessage(Group $group, Request $request)
    {
        

        if(request()->has('file')) {
            $filename = request('file')->store('image');
            $request->file('file')->move('image', $filename);
            //do không load được image từ Vue
            //nên phải thêm dòng $request->file('file')->move('image', $filename);
            //file ảnh được lưu ở 2 vị trí (tìm hiểu thêm để fix code)

            $message = $group->groupMessages()->create(['image'=>$filename]);
        } else {
            $message = $group->groupMessages()->create(['content'=>$request->content]);
        //qua relation message sẽ tự lấy group_id
        };
        $chat = $message->groupChats()->create([
            'group_id'=>$group->id,
            'type'=>0,
            'user_id'=>auth()->id()
        ]);
        $user = Auth::user();
        event(new GroupMsgEvent($message, $group->id, auth()->id(), $chat->id, $chat->created_at->format('d/m/y h:i'), $user->name)) ;
        $members = $group->members;
        foreach ($members as $member) {
            if ($member->id !== auth()->id()) {
                $message->groupChats()->create([
                    'group_id'=>$group->id,
                    'type'=>1,
                    'user_id'=>$member->id
                ]);
            }
        }
        
        return $message;
    }

    public function chats(Group $group)
    {
        return GroupChatResource::collection($group->groupChats->where('user_id', auth()->id()));
    }
}

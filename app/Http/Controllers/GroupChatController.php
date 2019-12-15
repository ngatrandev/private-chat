<?php

namespace App\Http\Controllers;
use App\Events\GroupMsgEvent;
use App\Events\GroupMsgReadEvent;
use App\Events\NotificationEvent;
use App\Group;
use App\GroupChat;
use App\Http\Resources\GroupChatResource;
use App\User;
use Carbon\Carbon;
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
        event(new GroupMsgEvent($message, $group->id, auth()->id(), $chat->id, $chat->created_at->format('d/m/y h:i'), $user->email)) ;
        $members = $group->members;
        foreach ($members as $member) {
            if ($member->id !== auth()->id()) {
                $message->groupChats()->create([
                    'group_id'=>$group->id,
                    'type'=>1,
                    'user_id'=>$member->id,
                    'from_id'=>auth()->id()
                ]);
            }
        }
        
        return $message;
    }

    public function chats(Group $group)
    {
        return GroupChatResource::collection($group->groupChats->where('user_id', auth()->id()));
    }

    public function read(Group $group)
    {
        $chats2 = $group->sendChats();
        $chats1 = $group->recieveChats();
        //$chat1 là bộ mes được nhận của user hiện tại, khi update sẽ chuyển unreadMess count về 0
               
        foreach ($chats1 as $chat) {
            $chat->update(['read_at' => Carbon::now()]); 
             
        };
        
        foreach ($chats2 as $chat) {
            if($chat) {
                $chat->update(['read_at' => Carbon::now()]); 
            }
        //không phát được event tại đây-tìm hiểu thêm      
        };
        
    }

    public function readBy($id)
    {
        //$id này logic với {id} bên route
        $chat = GroupChat::find($id);
        $message = $chat->groupMessage;

        $results = $message->groupChats->where('type', 1)
                                         ->where('read_at', '!=', null);

        if(count($results)>0) {
            $users1 = $results->map(function ($result) {
                $user = User::find($result->user_id);
                return $user->name;
            });
        } else {
            $users1 = collect([]);
            // nếu các chat đều bị xóa sẽ chạy vào đây
            // viết [] lỗi bên dưới, phải viết collect
        }
                                       
        

        $group = Group::find($chat->group_id);

        $members = $group->members;

        $array1 = $members->map(function ($member) {
            return $member->id;
        });

        $allChats = $message->groupChats;
        $array2 = $allChats->map(function ($chat) {
            return $chat->user_id;
        });

        $diff = $array1->diff($array2);// tìm sự khác nhau

        $users2 = $diff->map(function ($val) {
            $user = User::find($val);
            return $user->name;
        });

        $merged = $users1->merge($users2);
        // users1 là những user đã xem và chat vẫn còn được lưu trong database
        // users2 là những user đã xem và đã clear chat
        return $merged;




    }

    public function clear(Group $group) 
    {
        $group->groupChats()->where('user_id', auth()->id())->delete();
        
        $group->groupChats->count() == 0 ? $group->groupMessages()->delete() : '';
        //nếu chats các bên đều bị xóa thì messages cũng bị xóa
    }

    public function delete(Group $group) 
    {
        $name = Auth::user()->name;
        $groupName = $group->name;
        $members = $group->members;
        foreach ($members as $member) {
            if ($member->id !== auth()->id()) {
                $member->notifications()->create([
                    'content' => "$name was deleted '$groupName'."
                ]);

                event(new NotificationEvent($member->id));
            } else {
                $member->notifications()->create([
                    'content' => "You deleted '$groupName'."
                ]);
            }
        };
        $group->groupChats()->delete();
        $group->groupMessages()->delete();
        $group->members()->detach($members);//dùng để xóa database trong bảng group_user
        $group->delete();

        if(request()->wantsJson()) {
            return ['message' => '/home'];
        }
       
    }
}

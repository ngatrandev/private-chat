<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Events\MessageEvent;
use App\Events\MsgReadEvent;
use App\Http\Resources\ChatResource;
use App\Session;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function storeMessage(Session $session, Request $request)
    {
        $message = $session->messages()->create(['content'=>$request->content]);
        //qua relation message sẽ tự lấy session_id

        $chat=$message->chats()->create([
            'session_id'=>$session->id,
            'type'=>0,
            'user_id'=>auth()->id()
        ]);

        $message->chats()->create([
            'session_id'=>$session->id,
            'type'=>1,
            'user_id'=>$request->to_user
        ]);
        //mỗi mess tạo 2 bản chat cho người gửi và người nhận
        //để khi 1 người xóa mess không ảnh hưởng người còn lại

        event(new MessageEvent($message->content, $message->session_id, auth()->id(), $chat->id, $chat->created_at->format('d/m/y h:i')));
        return $message;
    }

    public function chats(Session $session) 
    {
        return ChatResource::collection($session->chats->where('user_id', auth()->id()));
        //trả về các chat đúng với session và user_id với data được biến đổi qua lớp Resource
    }

    public function read(Session $session)
    {
        $chats1 = $session->chats->where('read_at',null)
                                    ->where('type', 1)
                                    ->where('user_id', auth()->id());
        //$chat1 là bộ mes được nhận của user hiện tại, khi update sẽ chuyển unreadMess count về 0

        $chats2 = $session->chats->where('read_at',null)
                                    ->where('type', 0)
                                    ->where('user_id','!=', auth()->id());
        //$chat2 là bộ mes đã gửi của friend (trong cặp chat1-chat2), khi update sẽ chuyển mes từ đã gửi thành đã xem
        //thông qua MsgReadEvent
                            
        foreach ($chats1 as $chat) {
            $chat->update(['read_at' => Carbon::now()]); 
           
        };


        foreach ($chats2 as $chat) {
            $chat->update(['read_at' => Carbon::now()]); //
         
            broadcast(new MsgReadEvent(new ChatResource($chat), $session->id));
        }
        // dùng 2 bộ chat và 2 vòng forEach để tránh lỗi vì có liên quan đến broadcast event


     
        
        
    }

    public function clear(Session $session) 
    {
        $session->chats()->where('user_id', auth()->id())->delete();
        
        $session->chats->count() == 0 ? $session->messages()->delete() : '';
        //nếu chats cả hai bên đều bị xóa thì messages của session cũng bị xóa
    }
}

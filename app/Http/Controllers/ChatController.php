<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Events\MessageEvent;
use App\Http\Resources\ChatResource;
use App\Session;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function storeMessage(Session $session, Request $request)
    {
        $message = $session->messages()->create(['content'=>$request->content]);
        //qua relation message sẽ tự lấy session_id

        $message->chats()->create([
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

        event(new MessageEvent($message->content, $message->session_id, auth()->id()));
        return $message;
    }

    public function chats(Session $session) 
    {
        return ChatResource::collection($session->chats->where('user_id', auth()->id()));
        //trả về các chat đúng với session và user_id với data được biến đổi qua lớp Resource
    }
}

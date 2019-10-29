<?php

namespace App\Http\Resources;

use App\GroupMessage;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'content' => $this->groupMessage['content'],
            'image'=> $this->groupMessage['image'],
            'id'=> $this->id,
            'type'=>$this->type,
            'readAt'=>$this->read_at? $this->read_at->diffForHumans():null,
            'send_at'=>$this->created_at->format('d/m/y h:i'),
            'from'=>($this->type == 1)?  $this->getUser($this->group_message_id):''
            // chat vẫn trả về được message[content] vì đã có relation 
            // cách format về thời gian trong created_at
        ];
    }

    private function getUser($id) {
        $message = GroupMessage::where('id', $id)->first();
        $chat = $message->groupChats->where('type', 0)->first();
        $user = User::where('id',$chat->user_id)->first();//xác định msg được nhận từ user nào trong group
        return $user->email;
    }
}

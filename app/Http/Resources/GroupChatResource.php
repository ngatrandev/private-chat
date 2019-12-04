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
            'from'=>($this->type == 1)?  $this->getUser($this->from_id):'',
    
            // chat vẫn trả về được message[content] vì đã có relation 
            // cách format về thời gian trong created_at
        ];
    }

    private function getUser($id) {
        $user = User::where('id',$id)->first();
        return $user->email;
    }
}

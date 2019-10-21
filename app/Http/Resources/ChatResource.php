<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
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
            'content' => $this->message['content'],
            'image'=> $this->message['image'],
            'id'=> $this->id,
            'type'=>$this->type,
            'readAt'=>$this->read_at? $this->read_at->diffForHumans():null,
            'send_at'=>$this->created_at->format('d/m/y h:i')
            // chat vẫn trả về được message[content] vì đã có relation 
            // cách format về thời gian trong created_at
        ];
        
    }

}

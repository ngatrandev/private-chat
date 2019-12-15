<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            
            'content'=>$this->content,
            'time'=>$this->created_at->diffForHumans(), 
            'read'=>$this->read, 
            
        ];
    }
}

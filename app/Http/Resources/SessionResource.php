<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends JsonResource
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
            'id' => $this->id,
            'user1_name'=>$this->user1_name,
            'user1_id'=>$this->user1_id,
            'user2_id'=>$this->user2_id,
        ];
    }
}

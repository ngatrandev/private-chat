<?php

namespace App\Http\Resources;

use App\Session;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name'=>$this->name,
            'email'=>$this->email, 
            'online'=>false, 
            'sessionId'=>$this->sessionDetails($this->id)
        ];
    }

    private function sessionDetails($id) {
    $session =  Session::whereIn('user1_id', [auth()->id(), $id])
                ->whereIn('user2_id', [auth()->id(), $id])
                ->first();
    return $session->id;
    //Lưu ý cách lấy sessionId và dùng whereIn
    }
}

<?php

namespace App\Http\Resources;

use App\Group;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            'members'=>GroupUserResource::collection($this->members),
            // do trả về các user cụ thể nên không viết $this->members()
            // có thể dùng Resource khác trong file Resource
            'memberCount'=>$this->members->count(),
            'unreadCount'=>$this->unreadCount($this->id),
            'msgTyping'=>false
        ];
    }

    private function unreadCount($id) {
        $group = Group::where('id', $id)->first();
        $unreadmsg = $group->groupChats
                            ->where('read_at', null)
                            ->where('type',1)
                            ->where('user_id', auth()->id())
                            ->count();
        return $unreadmsg;
        }

    
}

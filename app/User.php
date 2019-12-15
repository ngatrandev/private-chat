<?php

namespace App;

use App\Http\Resources\SessionResource;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function invites()
    {   
     return  DB::table('sessions')
            ->where([
                ['user2_id', '=', $this->id],
                ['accept', '=', 0]
                ])->get();
               
    //dùng array để viết các điều kiện (AND)
    //nếu cần viết điều kiện OR có thể dùng orWhere
    }

    public function friendSession()
    {   
        return 
                DB::table('sessions')
                ->where([
                ['user2_id', '=', $this->id],
                ['accept', '=', 1]
                ])
                ->orWhere([
                ['user1_id', '=', $this->id],
                ['accept', '=', 1]
                ])
                ->get();
    // trả về các session của 1 user sau khi đã accept invite.
    }

    public function getFriends()
    {
        $arrays = $this->friendSession();
        $results = $arrays->map( function ($array) {
            if($array->user1_id == $this->id) {
                return User::find($array->user2_id);
            } 
                return User::find($array->user1_id);
            
        });

        return $results;

    //trả về các user đã kết bạn, lưu ý cách dùng map() methods và if
    //để chuyển từ collection session qua collection user (friend list)
    }

    
    public function groups()
    {
        return Group::WhereHas('members', function ($query) {
            $query->where('user_id', $this->id);
        })
        ->get();
       
        //trả về tất cả group cuả user 
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    
}

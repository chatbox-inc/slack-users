<?php


namespace Chatbox\Slackin\Models;


use Carbon\Carbon;
use Chatbox\Slackin\Services\Values\SlackTeam;
use Chatbox\Slackin\Services\Values\SlackUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserToken extends Model
{
    protected $table = "t_user_token";

    public function user(){
        return $this->belongsTo(User::class,"user_id");
    }

    public function fillWithToken($token=""){
        if(!$token){
            $token = Str::random();
        }
        $this->token = $token;
        $this->expired_at = Carbon::now()->addMonth();
        return $this;
    }
}

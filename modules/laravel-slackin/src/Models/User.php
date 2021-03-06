<?php


namespace Chatbox\Slackin\Models;


use Chatbox\Slackin\Services\Values\SlackTeam;
use Chatbox\Slackin\Services\Values\SlackUser;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = "t_user";

    public function team(){
        return $this->belongsTo(Team::class,"team_id");
    }

    public function getRawAttribute($value):SlackUser
    {
        return unserialize(json_decode($value,true));
    }

    public function setRawAttribute(SlackUser $value)
    {
        $this->attributes["raw"] = json_encode(serialize($value));
    }

    public function fillByUser(SlackUser $user){
        $this->name = $user->name;
        $this->user_key = $user->user_id;
        $this->raw = $user;
        $this->is_inactive = $user->is_deleted;
        return $this;
    }
}

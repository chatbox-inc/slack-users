<?php


namespace Chatbox\Slackin\Models;


use Chatbox\Slackin\Services\Values\SlackTeam;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = "t_team";

    public function users(){
        return $this->hasMany(User::class,"team_id");
    }

    public function getRawAttribute($value):SlackTeam
    {
        return unserialize(json_decode($value,true));
    }

    public function setRawAttribute(SlackTeam $value)
    {
        $this->attributes["raw"] = json_encode(serialize($value));
    }

    public function fillByTeam(SlackTeam $team){
        $this->team_domain_key = $team->domain;
        $this->team_id = $team->team_id;
        $this->name = $team->name;
        $this->raw = $team;
        return $this;
    }

    public function setToken($token){
        $this->slack_token = $token;
        return $this;
    }
}

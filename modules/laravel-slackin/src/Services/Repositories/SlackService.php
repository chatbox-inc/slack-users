<?php
namespace Chatbox\Slackin\Services\Repositories;

use Chatbox\Slackin\Services\Values\SlackTeam;
use Chatbox\Slackin\Services\Values\SlackUser;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;

class SlackService
{
    protected $token;

    /**
     * SlackService constructor.
     * @param $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    protected function client(){
        return new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://slack.com/api/',
            'headers' => [
                "Authorization" => "Bearer {$this->token}"
            ]
        ]);
    }

    /**
     * @see https://api.slack.com/methods/team.info
     */
    public function team(): ?SlackTeam{
        $result = $this->client()->request("GET","team.info",[
            'headers' => [
                "Authorization" => "Bearer {$this->token}"
            ]
        ]);
        $body = $result->getBody()->getContents();
        $body = json_decode($body,true);

        if($body && (Arr::get($body,"ok") === true)){
            return $this->parseResponse2Team(Arr::get($body,"team"));
        }
        return null;
    }

    protected function parseResponse2Team(array $body):SlackTeam {
        $team = new SlackTeam();
        $team->team_id = Arr::get($body,"id");
        $team->domain = Arr::get($body,"domain");
        $team->email_domain = Arr::get($body,"email_domain");
        $team->icon_image = Arr::get($body,"icon.image_132");
        $team->name = Arr::get($body,"name");
//        dd($team,$body);
        return $team;
    }


    /**
     * @see https://api.slack.com/methods/users.list
     */
    public function users(){
        $result = $this->client()->get("users.list");
        $body = $result->getBody()->getContents();
        $body = json_decode($body,true);

        if($body && (Arr::get($body,"ok") === true)){
            return $this->parseResponse2Users(Arr::get($body,"members"));
        }
        return null;


    }

    protected function parseResponse2Users(array $body):array {
        $users = [];
        foreach ($body as $userBody) {
            if(
                Arr::get($userBody,"is_bot") ||
                Arr::get($userBody,"deleted") ||
                Arr::get($userBody,"is_app_user")
            ){
                continue;
            }
            $user = new SlackUser();
            $user->user_id = Arr::get($userBody,"id");
            $user->name = Arr::get($userBody,"name");
            $user->icon_image = Arr::get($userBody,"profile.image_512");
            $user->display_name = Arr::get($userBody,"profile.display_name");
            $user->display_name_normalized = Arr::get($userBody,"profile.display_name_normalized");
            $user->email = Arr::get($userBody,"profile.email");
            $user->is_admin = Arr::get($userBody,"is_admin");
            $user->is_deleted = Arr::get($userBody,"deleted");
            $user->is_owner = Arr::get($userBody,"is_owner");
            $user->is_primary_owner = Arr::get($userBody,"is_primary_owner");
            $user->real_name = Arr::get($userBody,"profile.real_name");
            $user->real_name_normalized = Arr::get($userBody,"profile.real_name_normalized");
            $users[] = $user;
        }
        return $users;
    }


}
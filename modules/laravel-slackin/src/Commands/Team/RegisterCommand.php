<?php
namespace Chatbox\Slackin\Commands;

use Chatbox\Slackin\Models\Team;
use Chatbox\Slackin\Models\User;
use Chatbox\Slackin\Models\UserToken;
use Chatbox\Slackin\Services\Repositories\SlackService;
use Chatbox\Slackin\Services\Values\SlackUser;
use Illuminate\Console\Command;

class RegisterCommand extends Command
{
    protected $signature = "team:register {token}";

    public function handle(){

        $token = $this->argument("token");
        $service = new SlackService($token);

        $slackTeam = $service->team();

        $teamModel = new Team();
        $teamModel->fillByTeam($slackTeam)->setToken($token)->save();

        $this->line("team registered!");

        $users = $service->users();
        foreach ($users as $user) {
            assert($user instanceof SlackUser);
            if($user->is_deleted){
                continue;
            }
            $userModel = new User();
            $userModel->fillByUser($user);
            $userModel->team()->associate($teamModel);
            $userModel->save();

            $userTokenModel = new UserToken();
            $userTokenModel->fillWithToken();
            $userTokenModel->user()->associate($userModel);
            $userTokenModel->save();
        }

    }

}
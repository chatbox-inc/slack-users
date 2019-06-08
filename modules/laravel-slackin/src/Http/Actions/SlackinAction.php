<?php
namespace Chatbox\Slackin\Http\Actions;

use Carbon\Carbon;
use Chatbox\LaravelWebhook\Events\EmitRequest;
use Chatbox\LaravelWebhook\Services\WebhookService;
use Chatbox\LaravelWebhook\Values\WebhookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProfileAction
{
    /*
     * トークンを受け取ってユーザ情報を返す
     */
    public function handle(Request $request){

        return [
            "request" => ""
        ];
    }

}
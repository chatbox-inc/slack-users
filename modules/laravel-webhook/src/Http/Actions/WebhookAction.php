<?php
namespace Chatbox\LaravelWebhook\Http\Actions;

use Carbon\Carbon;
use Chatbox\LaravelWebhook\Events\EmitRequest;
use Chatbox\LaravelWebhook\Services\WebhookService;
use Chatbox\LaravelWebhook\Values\WebhookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WebhookAction
{

    public function handle(Request $request){
        $req = new WebhookRequest();

        $req->method = $request->method();
        $req->payload = $request->all();
        $req->headers = $request->headers->all();
        $req->created_at = Carbon::now();
        $req->ip = $request->ip();

        $req = (new WebhookService())->dispatch($req);

        return [
            "request" => $req
        ];
    }

}
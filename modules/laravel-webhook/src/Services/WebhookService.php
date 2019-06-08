<?php
namespace Chatbox\LaravelWebhook\Services;

use Carbon\Carbon;
use Chatbox\LaravelWebhook\Events\EmitRequest;
use Chatbox\LaravelWebhook\Values\WebhookRequest;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WebhookService
{
    public function dispatch(WebhookRequest $_request){
        $request = clone $_request;
        $request->hash = sha1(Str::random());
        event(new EmitRequest($request));
        return $request;
    }

    protected function table():Builder{
        return DB::table("webhook");
    }

    public function store(WebhookRequest $request){
        $this->table()->insert([
            "hash" => $request->hash,
            "ip" => $request->ip,
            "method" => $request->method,
            "payload" => json_encode($request->payload),
            "headers" => json_encode($request->headers),
            "created_at" => $request->created_at,
        ]);
    }

    public function load(string $hash) {
        $row = $this->table()->where("hash",$hash)->first();

        if($row){
            $request = new WebhookRequest();
            $request->hash = $hash;
            $request->created_at = Carbon::createFromTimeString($row->created_at);
            $request->ip = $row->ip;
            $request->method = $row->method;
            $request->payload = json_decode($row->payload, true);
            $request->headers = json_decode($row->headers, true);
            return $request;
        }
    }

}
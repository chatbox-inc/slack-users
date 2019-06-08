<?php
namespace Chatbox\LaravelWebhook\Values;

class WebhookRequest implements \JsonSerializable
{

    public $payload;

    public $headers;

    public $method;

    public $created_at;

    public $hash;

    public $ip;

    public function jsonSerialize()
    {
        return [
            "payload" => $this->payload,
            "headers" => $this->headers,
            "method" => $this->method,
            "created_at" => $this->created_at->format(DATE_ATOM),
            "hash" => $this->hash,
            "ip" => $this->ip,
        ];
    }
}
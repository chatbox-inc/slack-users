<?php

namespace Chatbox\LaravelWebhook\Listeners;

use Chatbox\LaravelWebhook\Events\EmitRequest;
use Chatbox\LaravelWebhook\Services\WebhookService;
use Chatbox\LaravelWebhook\Values\WebhookRequest;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreRequest implements ShouldQueue
{
    protected $service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(WebhookService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(EmitRequest $event)
    {
        $this->service->store($event->request);
    }
}

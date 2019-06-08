<?php
namespace Chatbox\LaravelWebhook\Providers;

use Illuminate\Support\ServiceProvider;
use Chatbox\LaravelWebhook\Events\EmitRequest;
use Chatbox\LaravelWebhook\Listeners\StoreRequest;
use Illuminate\Support\Facades\Event;

class WebhookLoggerServiceProvider extends ServiceProvider
{
    public function boot(){
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        Event::listen(EmitRequest::class, StoreRequest::class);
    }
}
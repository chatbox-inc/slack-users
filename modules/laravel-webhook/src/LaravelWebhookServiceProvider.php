<?php
namespace Chatbox\LaravelWebhook;

use Chatbox\LaravelWebhook\Events\EmitRequest;
use Chatbox\LaravelWebhook\Http\Actions\WebhookAction;
use Chatbox\LaravelWebhook\Listeners\StoreRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class LaravelWebhookServiceProvider extends ServiceProvider
{

    public function boot(){

        Route::any("/webhook",WebhookAction::class."@handle");
    }

    public function register()
    {
        parent::register();
    }
}
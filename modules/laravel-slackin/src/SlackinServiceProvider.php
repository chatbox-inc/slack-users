<?php
namespace Chatbox\Slackin;

use Chatbox\Slackin\Commands\RegisterCommand;
use Chatbox\Slackin\Http\Actions\ProfileAction;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class SlackinServiceProvider extends ServiceProvider
{

    public function boot(){
        Route::get("/api/profile",ProfileAction::class."@handle");
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    public function register()
    {
        parent::register();
        $this->commands(RegisterCommand::class);
    }
}
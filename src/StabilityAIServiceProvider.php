<?php

namespace Talendor\StabilityAI;

use Illuminate\Support\ServiceProvider;

class StabilityAIServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/stabilityai.php' => config_path('stabilityai.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton(StabilityAIClient::class, function ($app) {
            return new StabilityAIClient(config('stabilityai.api_key'), config('stabilityai.endpoint'));
        });
    }
}

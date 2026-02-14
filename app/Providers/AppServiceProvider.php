<?php

namespace App\Providers;
use App\Services\PhonePeService;
use Illuminate\Support\ServiceProvider;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
{
    $this->app->singleton(PhonePeService::class, function ($app) {
        return new PhonePeService();
    });
}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

<?php

namespace App\Providers;

use App\Services\NiceReply\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(Client::class, fn () => new Client(
            config('services.nicereply.domain'),
            config('services.nicereply.user'),
            config('services.nicereply.private'),
        ));
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}

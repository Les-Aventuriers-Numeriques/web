<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Discord\Provider;
use SocialiteProviders\Manager\SocialiteWasCalled;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);

            $this->app->register(\Fruitcake\TelescopeToolbar\ToolbarServiceProvider::class);
        }
    }

    public function boot(): void
    {
        Event::listen(function (SocialiteWasCalled $event) {
            $event->extendSocialite('discord', Provider::class);
        });
    }
}

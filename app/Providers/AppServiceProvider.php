<?php

namespace App\Providers;

use App\View\Composers\LayoutViewComposer;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Discord\Provider;
use SocialiteProviders\Manager\SocialiteWasCalled;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerLocalOnlyPackages();
    }

    public function boot(): void
    {
        $this->extendSocialite();
        $this->registerMacros();
        $this->registerViewComposers();
    }

    private function registerLocalOnlyPackages(): void
    {
        if (! $this->app->environment('local')) {
            return;
        }

        $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
        $this->app->register(TelescopeServiceProvider::class);

        $this->app->register(\Fruitcake\TelescopeToolbar\ToolbarServiceProvider::class);
    }

    private function extendSocialite(): void
    {
        Event::listen(function (SocialiteWasCalled $event) {
            $event->extendSocialite('discord', Provider::class);
        });
    }

    private function registerMacros(): void
    {
        RedirectResponse::macro('withAlert', function (string $message, string $type): RedirectResponse {
            return $this->with([
                'alert-type' => $type,
                'alert-message' => $message,
            ]);
        });

        SEOTools::macro('organizationJsonLd', function (): array {
            $teamName = Config::string('team-lan.team_name');
            $teamShortName = Config::string('team-lan.team_short_name');
            $motto = Config::string('team-lan.motto');
            $logo = Config::string('team-lan.logo');

            /** @var Carbon $founded */
            $founded = Config::get('team-lan.founded');

            return [
                '@type' => 'Organization',
                'name' => $teamName,
                'alternateName' => $teamShortName,
                'description' => $motto,
                'slogan' => $motto,
                'url' => site_route('home'),
                'image' => asset($logo),
                'logo' => asset($logo),
                'foundingDate' => $founded->toDateString(),
            ];
        });
    }

    private function registerViewComposers(): void
    {
        View::composer('layout', LayoutViewComposer::class);
    }
}

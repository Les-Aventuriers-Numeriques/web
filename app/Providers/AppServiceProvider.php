<?php

namespace App\Providers;

use App\Models\GameProposal;
use App\Models\User;
use App\Services\PubgApiClient;
use App\Services\SteamApiClient;
use App\View\Composers\Layout;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Discord\Provider;
use SocialiteProviders\Manager\SocialiteWasCalled;
use Spatie\Flash\Flash;

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
        $this->registerServices();
        $this->registerMorphMap();
        $this->registerGates();
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
        Carbon::macro('appTz', function (): Carbon {
            /** @var Carbon $this */
            return $this->tz(Config::string('app.display_timezone'));
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

        Flash::levels([
            'success' => 'alert alert-success',
            'danger' => 'alert alert-danger',
            'warning' => 'alert alert-warning',
            'info' => 'alert alert-info',
        ]);
    }

    private function registerViewComposers(): void
    {
        View::composer('layout', Layout::class);
    }

    private function registerServices(): void
    {
        $this->app->singleton(PubgApiClient::class, function (Application $app) {
            return new PubgApiClient(Config::string('services.pubg.token'));
        });

        $this->app->singleton(SteamApiClient::class, function (Application $app) {
            return new SteamApiClient(Config::string('services.steam.key'));
        });
    }

    private function registerMorphMap(): void
    {
        Relation::enforceMorphMap([
            'game_proposal' => GameProposal::class,
        ]);
    }

    private function registerGates(): void
    {
        Gate::before(function (User $user, string $ability): ?bool {
            return $user->is_admin ? true : null;
        });

        Gate::define('administrate', function (User $user): Response {
            return $user->is_admin
                ? Response::allow()
                : Response::deny('Hop hop hop non.');
        });

        Gate::define('access-lan-games', function (User $user): Response {
            return $user->is_lan_participant
                ? Response::allow()
                : Response::deny('Désolé, tu ne fais pas partie des participants à la LAN.');
        });
    }
}

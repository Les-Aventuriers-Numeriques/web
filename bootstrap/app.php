<?php

use App\Console\Commands\PubgSummary;
use App\Http\Middleware\LogoutUserIfMustRelogin;
use App\Http\Middleware\SetAppContext;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Sentry\Laravel\Integration;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php'
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectUsersTo(fn (Request $request): string => hub_route('home'));
        $middleware->redirectGuestsTo(function (Request $request): string {
            flash()->warning('Merci de te connecter afin d\'accéder à cette page, on se revoit ensuite.');

            return hub_route('auth.login');
        });

        $middleware->alias([
            'logout_if_must_relogin' => LogoutUserIfMustRelogin::class,
            'set_app_context' => SetAppContext::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->dontTruncateRequestExceptions();

        Integration::handles($exceptions);
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command(PubgSummary::class)
            ->everyTwoMinutes()
            ->between('09:00', '23:59')
            ->between('00:00', '01:00')
            ->withoutOverlapping()
            ->runInBackground()
            ->sentryMonitor();
    })
    ->create();

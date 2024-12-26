<?php

use App\Http\Middleware\LogoutUserIfMustRelogin;
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
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->dontTruncateRequestExceptions();

        Integration::handles($exceptions);
    })->create();

<?php

namespace App\Http\Middleware\Hub;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Context;
use Symfony\Component\HttpFoundation\Response;

class SetAppContext
{
    /**
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $route = $request->route();

        if ($route instanceof Route) {
            $domain = Config::string('app.domain');

            $app = match ($route->domain()) {
                $domain => 'site',
                "hub.$domain" => 'hub',
                default => null
            };

            if ($app == 'hub') {
                config([
                    'app.name' => 'Hub '.config('app.name'),
                ]);
            }

            Context::add('app', $app);
        }

        return $next($request);
    }
}

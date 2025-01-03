<?php

namespace App\Http\Middleware;

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

            Context::add(
                'app',
                match ($route->domain()) {
                    $domain => 'site',
                    "hub.$domain" => 'hub',
                    default => null
                }
            );
        }

        return $next($request);
    }
}

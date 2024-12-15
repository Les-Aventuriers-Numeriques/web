<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogoutIfUserMustRelogin
{
    /**
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->must_relogin) {
            $user->logout();

            return to_route('web.hub.auth.login')
                ->with('success', 'Merci de te reconnecter.');
        }

        return $next($request);
    }
}

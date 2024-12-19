<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogoutUserIfMustRelogin
{
    /**
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->must_relogin) {
            Auth::logout();

            return to_route('web.hub.auth.login')
                ->withAlert('Merci de te reconnecter.', 'warning');
        }

        return $next($request);
    }
}

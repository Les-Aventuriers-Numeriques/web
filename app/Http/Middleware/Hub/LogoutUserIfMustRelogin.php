<?php

namespace App\Http\Middleware\Hub;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogoutUserIfMustRelogin
{
    /**
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user instanceof User && $user->must_relogin) {
            Auth::logout();

            flash()->warning('Merci de te reconnecter.');

            return to_hub_route('auth.login');
        }

        return $next($request);
    }
}

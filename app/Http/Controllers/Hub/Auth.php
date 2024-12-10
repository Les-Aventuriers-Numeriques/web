<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class Auth extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('discord')->redirect();
    }

    public function callback(): RedirectResponse
    {
        $user = Socialite::driver('discord')->user();
    }
}

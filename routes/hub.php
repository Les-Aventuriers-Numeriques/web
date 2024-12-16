<?php

use App\Http\Controllers\Hub\Auth;
use App\Http\Controllers\Hub\Home;

Route::middleware(['auth', 'logout_if_must_relogin'])
    ->group(function () {
        Route::get('', Home::class)->name('home');
    });

Route::name('auth.')
    ->group(function () {
        Route::get('deconnexion', [Auth::class, 'logout'])
            ->middleware('auth')
            ->name('logout');

        Route::prefix('connexion')
            ->middleware('guest')
            ->group(function () {
                Route::get('', [Auth::class, 'login'])->name('login');
                Route::get('redirect', [Auth::class, 'redirect'])->name('redirect');
                Route::get('callback', [Auth::class, 'callback'])->name('callback');
            });
    });

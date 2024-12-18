<?php

use App\Http\Controllers\Hub\Auth;
use App\Http\Controllers\Hub\Home;
use App\Http\Controllers\Hub\RobotsTxt;

Route::withoutMiddleware('web')
    ->get('robots.txt', RobotsTxt::class)->name('robots-txt');

Route::middleware(['auth', 'logout_if_must_relogin'])
    ->group(function () {
        Route::get('', Home::class)->name('home');
    });

Route::name('auth.')
    ->group(function () {
        Route::controller(Auth::class)
            ->group(function () {
                Route::get('deconnexion', 'logout')
                    ->middleware('auth')
                    ->name('logout');

                Route::prefix('connexion')
                    ->middleware('guest')
                    ->group(function () {
                        Route::get('', 'login')->name('login');
                        Route::get('redirect', 'redirect')->name('redirect');
                        Route::get('callback', 'callback')->name('callback');
                    });
            });
    });

<?php

use App\Http\Controllers\Hub\Auth;
use App\Http\Controllers\Hub\Home as HubHome;
use App\Http\Controllers\Site\Home as SiteHome;
use App\Http\Controllers\Site\Lan;
use Illuminate\Support\Facades\Route;

$domainName = config('team-lan.domain_name');

Route::name('web.')
    ->group(function () use ($domainName) {
        Route::name('site.')
            ->domain($domainName)
            ->withoutMiddleware('web')
            ->group(function () {
                Route::get('', SiteHome::class)->name('home');
                Route::get('lan', Lan::class)->name('lan');
            });

        Route::name('hub.')
            ->domain("hub.$domainName")
            ->group(function () {
                Route::get('', HubHome::class)
                    ->middleware('auth')
                    ->name('home');

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
            });
    });

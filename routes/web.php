<?php

use App\Http\Controllers\Hub\Auth;
use App\Http\Controllers\Hub\Home as HubHome;
use App\Http\Controllers\Site\Home as SiteHome;
use App\Http\Controllers\Site\Lan;
use Illuminate\Support\Facades\Route;

$domainName = config('team-lan.domain_name');

Route::name('web.')
    ->group(function () use ($domainName) {
        Route::domain($domainName)
            ->name('site.')
            ->withoutMiddleware('web')
            ->group(function () {
                Route::get('', SiteHome::class)->name('home');
                Route::get('lan', Lan::class)->name('lan');
            });

        Route::domain("hub.$domainName")
            ->name('hub.')
            ->group(function () {
                Route::get('', HubHome::class)->name('home');

                Route::name('auth.')
                    ->prefix('connexion')
                    ->group(function () {
                        Route::get('', [Auth::class, 'login'])->name('login');
                        Route::get('redirect', [Auth::class, 'redirect'])->name('redirect');
                        Route::get('callback', [Auth::class, 'callback'])->name('callback');
                    });
            });
    });

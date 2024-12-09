<?php

use Illuminate\Support\Facades\Route;

Route::name('web.')
    ->group(function () {
        Route::domain('team-lan.test')
            ->name('site.')
            ->group(function () {
                Route::view('/', 'site.home')->name('home');
                Route::view('/lan', 'site.lan')->name('lan');
            });

        Route::domain('hub.team-lan.test')
            ->name('hub.')
            ->group(function () {
                Route::view('/', 'hub.home')->name('home');
            });
    });

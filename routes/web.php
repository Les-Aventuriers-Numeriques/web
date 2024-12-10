<?php

use Illuminate\Support\Facades\Route;

$domainName = config('team-lan.domain_name');
$hubSubdomainName = config('team-lan.hub_subdomain_name');

Route::name('web.')
    ->group(function () use ($hubSubdomainName, $domainName) {
        Route::domain($domainName)
            ->name('site.')
            ->group(function () {
                Route::view('/', 'site.home')->name('home');
                Route::view('/lan', 'site.lan')->name('lan');
            });

        Route::domain("$hubSubdomainName.$domainName")
            ->name('hub.')
            ->group(function () {
                Route::view('/', 'hub.home')->name('home');
            });
    });

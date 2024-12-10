<?php

use App\Http\Controllers\Hub\Home as HubHome;
use App\Http\Controllers\Site\Home as SiteHome;
use App\Http\Controllers\Site\Lan;
use Illuminate\Support\Facades\Route;

$domainName = config('team-lan.domain_name');
$hubSubdomainName = config('team-lan.hub_subdomain_name');

Route::name('web.')
    ->group(function () use ($hubSubdomainName, $domainName) {
        Route::domain($domainName)
            ->name('site.')
            ->group(function () {
                Route::get('/', SiteHome::class)->name('home');
                Route::get('/lan', Lan::class)->name('lan');
            });

        Route::domain("$hubSubdomainName.$domainName")
            ->name('hub.')
            ->group(function () {
                Route::get('/', HubHome::class)->name('home');
            });
    });

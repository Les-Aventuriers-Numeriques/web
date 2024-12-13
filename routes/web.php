<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;

$domainName = Config::string('team-lan.domain_name');

Route::name('web.')
    ->group(function () use ($domainName) {
        Route::name('site.')
            ->domain($domainName)
            ->withoutMiddleware('web')
            ->group(base_path('routes/site.php'));

        Route::name('hub.')
            ->domain("hub.$domainName")
            ->group(base_path('routes/hub.php'));
    });

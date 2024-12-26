<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

$domain = Config::string('team-lan.domain');

Route::name('web.')
    ->group(function () use ($domain) {
        Route::name('site.')
            ->domain($domain)
            ->withoutMiddleware('web')
            ->middleware('set_app_context')
            ->group(base_path('routes/site.php'));

        Route::name('hub.')
            ->domain("hub.$domain")
            ->middleware('set_app_context')
            ->group(base_path('routes/hub.php'));
    });

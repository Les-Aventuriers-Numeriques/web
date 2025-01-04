<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

$domain = Config::string('app.domain');

Route::name('web.')
    ->middleware('set_app_context')
    ->group(function () use ($domain) {
        Route::name('site.')
            ->domain($domain)
            ->withoutMiddleware('web')
            ->group(base_path('routes/site.php'));

        Route::name('hub.')
            ->domain("hub.$domain")
            ->group(base_path('routes/hub.php'));
    });

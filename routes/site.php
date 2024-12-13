<?php

use App\Http\Controllers\Site\Home;
use App\Http\Controllers\Site\Lan;

Route::get('', Home::class)->name('home');
Route::get('lan', Lan::class)->name('lan');

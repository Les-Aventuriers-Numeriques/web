<?php

use App\Http\Controllers\Site\Home;
use App\Http\Controllers\Site\Lan;
use App\Http\Controllers\Site\RobotsTxt;
use App\Http\Controllers\Site\SitemapXml;

Route::get('', Home::class)->name('home');
Route::get('lan', Lan::class)->name('lan');
Route::get('robots.txt', RobotsTxt::class)->name('robots-txt');
Route::get('sitemap.xml', SitemapXml::class)->name('sitemap-xml');

<?php

namespace App\Http\Controllers\Site;

use Illuminate\Contracts\View\View;

class Home extends Controller
{
    public function __invoke(): View
    {
        return site_view('home');
    }
}

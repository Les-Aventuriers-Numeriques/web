<?php

namespace App\Http\Controllers\Site;

use Illuminate\Contracts\View\View;

class Lan extends Controller
{
    public function __invoke(): View
    {
        return site_view('lan');
    }
}

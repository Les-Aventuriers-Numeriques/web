<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class Lan extends Controller
{
    public function __invoke(): View
    {
        return view('site.lan');
    }
}

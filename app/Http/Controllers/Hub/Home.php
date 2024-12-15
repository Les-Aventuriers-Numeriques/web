<?php

namespace App\Http\Controllers\Hub;

use Illuminate\Contracts\View\View;

class Home extends Controller
{
    public function __invoke(): View
    {
        return hub_view('home');
    }
}

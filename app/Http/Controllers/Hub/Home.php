<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class Home extends Controller
{
    public function __invoke(): View
    {
        return view('hub.home');
    }
}

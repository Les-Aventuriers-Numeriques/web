<?php

namespace App\Http\Controllers\Hub;

use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Contracts\View\View;

class Home extends Controller
{
    public function __invoke(): View
    {
        SEOMeta::setTitle('Accueil');

        return hub_view('home');
    }
}

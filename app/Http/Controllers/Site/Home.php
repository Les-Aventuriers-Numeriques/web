<?php

namespace App\Http\Controllers\Site;

use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Contracts\View\View;

class Home extends Controller
{
    public function __invoke(): View
    {
        // Global
        SEOTools::setTitle('En quelques mots');
        SEOTools::setDescription('La team multigaming Les Aventuriers Numériques présentée en quelques mots.');

        // JSON-LD
        // TODO

        return site_view('home');
    }
}

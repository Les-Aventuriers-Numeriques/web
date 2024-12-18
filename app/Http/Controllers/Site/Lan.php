<?php

namespace App\Http\Controllers\Site;

use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Contracts\View\View;

class Lan extends Controller
{
    public function __invoke(): View
    {
        // Global
        SEOTools::setTitle('3ème LAN annuelle');
        SEOTools::setDescription('Infos à propos de la LAN annuelle organisée par la team Les Aventuriers Numériques.');

        // JSON-LD
        // TODO

        return site_view('lan');
    }
}

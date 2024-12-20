<?php

namespace App\Http\Controllers\Site;

use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Config;

class Lan extends Controller
{
    public function __invoke(): View
    {
        $teamName = Config::string('team-lan.team_name');

        // Global
        SEOTools::setTitle('3ème LAN annuelle');
        SEOTools::setDescription("Infos à propos de la LAN annuelle organisée par la team $teamName.");

        // JSON-LD
        SEOTools::jsonLdMulti()
            ->addValue('about', [
                '@type' => 'SocialEvent',
            ]);

        return site_view('lan');
    }
}

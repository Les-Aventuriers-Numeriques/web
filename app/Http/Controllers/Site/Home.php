<?php

namespace App\Http\Controllers\Site;

use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class Home extends Controller
{
    public function __invoke(): View
    {
        $teamName = Config::string('team-lan.team_name');

        /** @var Carbon $founded */
        $founded = Config::get('team-lan.founded');

        // Global
        SEOTools::setTitle('En quelques mots');
        SEOTools::setDescription("La team multigaming $teamName présentée en quelques mots.");

        // JSON-LD
        SEOTools::jsonLdMulti()
            ->setType('AboutPage')
            ->addValue('about', SEOTools::organizationJsonLd());

        return site_view('home', compact('teamName', 'founded'));
    }
}

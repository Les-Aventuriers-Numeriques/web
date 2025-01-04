<?php

namespace App\Http\Controllers\Site;

use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

abstract class Controller
{
    public function __construct()
    {
        $teamName = Config::string('team-lan.team_name');
        $motto = Config::string('team-lan.motto');
        $logo = Config::string('team-lan.logo');

        // Global
        SEOTools::setDescription($motto);
        SEOTools::setCanonical(URL::current());
        SEOTools::addImages(asset($logo));

        // Tags meta
        SEOTools::metatags()
            ->setTitleDefault($teamName);

        // Open Graph
        SEOTools::opengraph()
            ->setType('website')
            ->setSiteName($teamName)
            ->setUrl(URL::current())
            ->addProperty('locale', app()->getLocale());

        // Twitter Card
        SEOTools::twitter()
            ->setType('summary');

        // JSON-LD
        SEOTools::jsonLdMulti()
            ->setType('WebPage')
            ->setUrl(URL::current())
            ->addValue('mainEntity', SEOTools::organizationJsonLd());
    }
}

<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller as BaseController;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\URL;

abstract class Controller extends BaseController
{
    public function __construct()
    {
        // Global
        SEOTools::setDescription('Une team multigaming francophone et conviviale');
        SEOTools::setCanonical(URL::current());
        SEOTools::addImages(asset('images/logo_256.png'));

        // Open Graph
        SEOTools::opengraph()
            ->setType('website')
            ->setSiteName('Les Aventuriers Numériques')
            ->setUrl(URL::current())
            ->addProperty('locale', app()->getLocale());

        // Twitter Card
        SEOTools::twitter()
            ->setType('summary');

        // JSON-LD
        SEOTools::jsonLd()
            ->setType('WebPage')
            ->setUrl(URL::current());

        // TODO JSON-LD de base
    }
}

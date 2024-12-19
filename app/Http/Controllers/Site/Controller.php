<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller as BaseController;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\URL;

abstract class Controller extends BaseController
{
    public function __construct()
    {
        // Global
        SEOTools::setDescription('Une team multigaming francophone et conviviale');
        SEOTools::setCanonical(URL::current());
        SEOTools::addImages(asset('images/logo_256.png'));

        // Tags meta
        SEOTools::metatags()
            ->setTitleDefault('Les Aventuriers Numériques');

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
        SEOTools::jsonLdMulti()
            ->setType('WebPage')
            ->setUrl(URL::current())
            ->addValue('mainEntity', $this->jsonLdOrg());
    }

    protected function jsonLdOrg(): array
    {
        return [
            '@type' => 'Organization',
            'name' => 'Les Aventuriers Numériques',
            'alternateName' => 'LAN',
            'description' => 'Une team multigaming francophone et conviviale',
            'slogan' => 'Une team multigaming francophone et conviviale',
            'url' => site_route('home'),
            'image' => asset('images/logo_256.png'),
            'logo' => asset('images/logo_256.png'),
            'foundingDate' => Date::createFromDate(2024, 3, 8)->toDateString(),
        ];
    }
}

<?php

namespace App\Http\Controllers\Site;

use Dom\XMLDocument;
use Illuminate\Http\Response;

class SitemapXml extends Controller
{
    private const NS = 'http://www.sitemaps.org/schemas/sitemap/0.9';

    public function __invoke(): Response
    {
        $sitemap = XMLDocument::createEmpty();
        $sitemap->formatOutput = app()->hasDebugModeEnabled();

        $root = $sitemap->appendChild(
            $sitemap->createElementNS(self::NS, 'urlset')
        );

        foreach (['home', 'lan'] as $route) {
            $loc = $sitemap->createElementNS(self::NS, 'loc');
            $loc->textContent = site_route($route);

            $url = $sitemap->createElementNS(self::NS, 'url');

            $url->appendChild($loc);
            $root->appendChild($url);
        }

        return response(
            $sitemap->saveXml()
        )->header('Content-Type', 'application/xml');
    }
}

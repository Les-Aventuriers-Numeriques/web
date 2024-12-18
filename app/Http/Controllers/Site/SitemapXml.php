<?php

namespace App\Http\Controllers\Site;

use Dom\XMLDocument;
use Illuminate\Http\Response;

class SitemapXml extends Controller
{
    public function __invoke(): Response
    {
        $sitemap = XMLDocument::createEmpty();
        $sitemap->formatOutput = app()->hasDebugModeEnabled();
        $urlsetns = 'http://www.sitemaps.org/schemas/sitemap/0.9';

        $root = $sitemap->appendChild(
            $sitemap->createElementNS($urlsetns, 'urlset')
        );

        foreach (['home', 'lan'] as $route) {
            $loc = $sitemap->createElementNS($urlsetns, 'loc');
            $loc->textContent = site_route($route);

            $url = $sitemap->createElementNS($urlsetns, 'url');

            $url->appendChild($loc);
            $root->appendChild($url);
        }

        return response(
            $sitemap->saveXml()
        )->header('Content-Type', 'application/xml');
    }
}

<?php

namespace App\Http\Controllers\Site;

use Dom\XMLDocument;
use Illuminate\Http\Response;

class SitemapXml extends Controller
{
    public function __invoke(): Response
    {
        $sitemap = XMLDocument::createEmpty();

        $root = $sitemap->appendChild(
            $sitemap->createElementNS('http://www.sitemaps.org/schemas/sitemap/0.9', 'urlset')
        );

        foreach (['home', 'lan'] as $route) {
            $loc = $sitemap->createElement('loc');
            $loc->textContent = site_route($route);

            $url = $sitemap->createElement('url');

            $url->appendChild($loc);
            $root->appendChild($url);
        }

        return response(
            $sitemap->saveXml()
        )->header('Content-Type', 'application/xml');
    }
}

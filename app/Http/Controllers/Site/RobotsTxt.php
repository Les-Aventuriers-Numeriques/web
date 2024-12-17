<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Response;

class RobotsTxt extends Controller
{
    public function __invoke(): Response
    {
        return response(
            str('User-agent: *')->newLine()
                ->append('Allow: /')->newLine()
                ->append('Sitemap: ')->append(site_route('sitemap-xml'))
                ->toString()
        )->header('Content-Type', 'text/plain');
    }
}

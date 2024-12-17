<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Response;

class RobotsTxt extends Controller
{
    public function __invoke(): Response
    {
        return response(
            str('User-agent: *')->newLine()
                ->append('Disallow: /')
                ->toString()
        )->header('Content-Type', 'text/plain');
    }
}

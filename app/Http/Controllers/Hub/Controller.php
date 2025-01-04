<?php

namespace App\Http\Controllers\Hub;

use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Config;

abstract class Controller
{
    public function __construct()
    {
        $teamName = Config::string('team-lan.team_name');

        // Tags meta
        SEOMeta::setTitleDefault("Hub $teamName");
        SEOMeta::setRobots('noindex, nofollow');
    }
}

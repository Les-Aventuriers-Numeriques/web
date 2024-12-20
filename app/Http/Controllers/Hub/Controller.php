<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller as BaseController;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Config;

abstract class Controller extends BaseController
{
    public function __construct()
    {
        $teamName = Config::string('team-lan.team_name');

        SEOMeta::setTitleDefault("Hub $teamName");
        SEOMeta::setRobots('noindex, nofollow');
    }
}

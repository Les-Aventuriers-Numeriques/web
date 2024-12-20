<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller as BaseController;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;

abstract class Controller extends BaseController
{
    public function __construct()
    {
        $teamName = Config::string('team-lan.team_name');

        // Tags meta
        SEOMeta::setTitleDefault("Hub $teamName");
        SEOMeta::setRobots('noindex, nofollow');

        // Données globales pour la vue
        View::share([
            'pageTitle' => 'Hub',
            'pageTitleUrl' => hub_route('home'),
            'pageSubTitle' => $teamName,
        ]);
    }
}

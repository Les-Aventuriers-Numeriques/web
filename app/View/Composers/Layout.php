<?php

namespace App\View\Composers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\Date;
use Illuminate\View\View;

class Layout
{
    public function compose(View $view): void
    {
        $view->with([
            'today' => Date::now(),
            'socialLinks' => Config::array('team-lan.social_links'),
            'logo' => asset(Config::string('team-lan.logo')),
            'teamName' => Config::string('team-lan.team_name'),
        ]);

        $teamName = Config::string('team-lan.team_name');
        $motto = Config::string('team-lan.motto');
        $app = Context::get('app');

        if ($app == 'site') {
            $view->with([
                'pageTitle' => $teamName,
                'pageTitleUrl' => site_route('home'),
                'pageSubTitle' => $motto,
            ]);
        } elseif ($app == 'hub') {
            $view->with([
                'pageTitle' => 'Hub',
                'pageTitleUrl' => hub_route('home'),
                'pageSubTitle' => $teamName,
            ]);
        }
    }
}

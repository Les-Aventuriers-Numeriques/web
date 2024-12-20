<?php

namespace App\View\Composers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Date;
use Illuminate\View\View;

class LayoutViewComposer
{
    public function compose(View $view)
    {
        $view->with([
            'today' => Date::now(),
            'socialLinks' => Config::array('team-lan.social_links'),
            'logo' => asset(Config::string('team-lan.logo')),
            'teamName' => Config::string('team-lan.team_name'),
        ]);
    }
}

<?php

use Illuminate\Support\Facades\Date;

return [
    'domain' => env('APP_DOMAIN'),

    'team_name' => 'Les Aventuriers Numériques',
    'team_short_name' => 'LAN',
    'motto' => 'Une team multigaming francophone et conviviale',
    'founded' => Date::createFromDate(2024, 3, 8),
    'logo' => 'images/logo_256.png',

    'social_links' => [
        'discord' => 'https://discord.gg/vQYv4MfQf8',
        'steam' => 'https://steamcommunity.com/groups/Les-Aventuriers-Numeriques',
        'github' => 'https://github.com/Les-Aventuriers-Numeriques',
    ],

    'next_lan' => [
        'announced' => true,
        'dates' => [
            'start' => Date::createFromDate(2024, 11, 7),
            'end' => Date::createFromDate(2024, 11, 11),
        ],
        'attendees' => [
            'max' => 10,
            'current' => 8,
        ],
        'location' => [
            'name' => 'Rully',
            'url' => 'https://maps.app.goo.gl/5Azz9MJbAin44MUt6',
        ],
    ],
];

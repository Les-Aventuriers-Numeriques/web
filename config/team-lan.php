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
];

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'discord' => [
        'client_id' => env('DISCORD_APPLICATION_ID'),
        'client_secret' => env('DISCORD_CLIENT_SECRET'),
        'redirect' => env('DISCORD_REDIRECT_URI'),

        'allow_gif_avatars' => (bool) env('DISCORD_AVATAR_GIF', true),
        'avatar_default_extension' => env('DISCORD_EXTENSION_DEFAULT', 'png'),

        'scopes' => ['guilds.members.read'],

        'guild_id' => (int) env('DISCORD_GUILD_ID'),

        'roles_id' => [
            'member' => (int) env('DISCORD_ROLES_ID_MEMBER'),
            'lan_participant' => (int) env('DISCORD_ROLES_ID_LAN_PARTICIPANT'),
            'is_lan_organizer' => (int) env('DISCORD_ROLES_ID_LAN_ORGANIZER'),
            'admin' => (int) env('DISCORD_ROLES_ID_ADMIN'),
        ],

        'channels_id' => [
            'lan' => (int) env('DISCORD_CHANNELS_ID_LAN'),
            'pubg' => (int) env('DISCORD_CHANNELS_ID_PUBG'),
        ],
    ],

    'pubg' => [
        'token' => env('PUBG_API_TOKEN'),
        'players_name' => [
            'internal' => env('PUBG_PLAYERS_NAME_INTERNAL'),
            'external' => env('PUBG_PLAYERS_NAME_EXTERNAL'),
        ],
    ],

    'steam' => [
        'key' => env('STEAM_API_KEY'),
    ],
];

<?php

use Illuminate\Http\RedirectResponse;
use \Illuminate\Contracts\View\View;

if (! function_exists('to_hub_route')) {
    function to_hub_route(string $route, ...$args): RedirectResponse
    {
        return to_route("web.hub.$route", ...$args);
    }
}

if (! function_exists('hub_view')) {
    function hub_view(string $view, ...$args): View
    {
        return view("hub.$view", ...$args);
    }
}

if (! function_exists('hub_route')) {
    function hub_route(string $name, ...$args): string
    {
        return route("web.hub.$name", ...$args);
    }
}

if (! function_exists('site_view')) {
    function site_view(string $view, ...$args): View
    {
        return view("site.$view", ...$args);
    }
}

if (! function_exists('site_route')) {
    function site_route(string $name, ...$args): string
    {
        return route("web.site.$name", ...$args);
    }
}

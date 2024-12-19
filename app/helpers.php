<?php

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

if (! function_exists('to_hub_route')) {
    /**
     * @param  array<array-key, mixed>  $parameters
     * @param  array<array-key, string>  $headers
     */
    function to_hub_route(string $route, array $parameters = [], int $status = 302, array $headers = []): RedirectResponse
    {
        return to_route("web.hub.$route", $parameters, $status, $headers);
    }
}

if (! function_exists('hub_view')) {
    /**
     * @param  array<array-key, mixed>  $data
     * @param  array<array-key, mixed>  $mergeData
     */
    function hub_view(string $view, array $data = [], array $mergeData = []): View
    {
        return view("hub.$view", $data, $mergeData);
    }
}

if (! function_exists('hub_route')) {
    /**
     * @param  array<array-key, mixed>  $parameters
     */
    function hub_route(string $name, array $parameters = [], bool $absolute = true): string
    {
        return route("web.hub.$name", $parameters, $absolute);
    }
}

if (! function_exists('site_view')) {
    /**
     * @param  array<array-key, mixed>  $data
     * @param  array<array-key, mixed>  $mergeData
     */
    function site_view(string $view, array $data = [], array $mergeData = []): View
    {
        return view("site.$view", $data, $mergeData);
    }
}

if (! function_exists('site_route')) {
    /**
     * @param  array<array-key, mixed>  $parameters
     */
    function site_route(string $name, array $parameters = [], bool $absolute = true): string
    {
        return route("web.site.$name", $parameters, $absolute);
    }
}

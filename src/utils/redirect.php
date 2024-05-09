<?php

use App\Helpers\Redirect;

if (!function_exists('redirect')) {
    function redirect(string $location)
    {
        return app()->get(Redirect::class)->to($location);
    }
}

if (!function_exists('redirectRoute')) {
    function redirectRoute(string $path , array $params = [])
    {
        return app()->get(Redirect::class)->route($path, $params);
    }
}

if (!function_exists('back')) {
    function back()
    {
        return app()->get(Redirect::class)->back();
    }
}

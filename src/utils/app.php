<?php

use App\Helpers\Cookie;
use App\Helpers\Session;
use App\Http\Core\Config;
use Illuminate\Support\Str;
use App\Http\Core\Container;
use App\Http\Request\Request;
use App\Http\Request\Response;

if (!function_exists('config')) {
    function config(string $path)
    {
        return Config::get($path);
    }
}

if (!function_exists('app')) {
    function app(?string $key = null, array $params = [])
    {
        if(is_null($key))
        {
            return Container::getInstance();
        }

        return Container::getInstance()->make($key, $params);
    }
}

if (!function_exists('route')) {
    function route(string $path, array $params = [])
    {
        $url = app()->get('app')->url($path, $params);

        return $url ?: DS;
    }
}

if (!function_exists('response')) {
    function response()
    {
        return app()->get(Response::class);
    }
}

if (!function_exists('request')) {
    function Request()
    {
        return app()->get(Request::class);
    }
}

if (!function_exists('view')) {
    function view(Response $response, string $view, array $data = [])
    {
        extract($data);

        $viewFile = Str::contains($view, '.twig') ? $view : str_replace('.', DS, $view).'.twig';

        $view = app()->get('view')->render($viewFile, $data);

        $response->setContent($view);

        return $response->send();
    }
}

if (!function_exists('session')) {
    function session(?string $name = null, $value = null)
    {
        if (!is_null($name) && !is_null($value)) {
            app()->get(Session::class)->put($name, $value);
            return;
        }

        if (!is_null($name)) {
            return app()->get(Session::class)->get($name);
        }

        return app()->get(Session::class);
    }
}

if (!function_exists('cookie')) {
    function cookie(?string $name = null, $value = null, int $expires = 0)
    {
        if (!is_null($name) && !is_null($value) && $expires != 0) {
            app()->get(Cookie::class)->put($name, $value, $expires);
            return;
        }

        if (!is_null($name)) {
            return app()->get(Cookie::class)->get($name);
        }

        return app()->get(Cookie::class);
    }
}

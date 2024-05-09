<?php

if (!function_exists('basePath')) {
    function basePath(string $path = '')
    {
        return BASE_PATH.ltrim($path);
    }
}

if(!function_exists('configPath'))
{
    function configPath(string $path = '')
    {
        return basePath('config'.DS.ltrim($path));
    }
}

if (!function_exists('routePath')) {
    function routePath(string $path = '')
    {
        return basePath('routes' . DS . ltrim($path));
    }
}

if (!function_exists('databasePath')) {
    function databasePath(string $path = '')
    {
        return basePath('database'.DS.ltrim($path));
    }
}
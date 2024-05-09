<?php
namespace App\Support;

use App\App;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Route
{
    private static App $app;

    public static function handle(App &$app)
    {
        self::$app = $app;

        return $app;
    }


    public static function __callStatic($verb, array $parameters)
    {
        $app = self::$app;

        
        if(count($parameters) == 3)
        {
            [$method, $path, $callback] = $parameters;
        }else{
            [$path, $callback] = $parameters;
        }


        $uri = trim($path, DS);

        self::validation($uri, $callback, $verb);

        if(count($parameters) == 3)
            return (is_callable($callback))
                ? $app->{$verb}($method, $uri, $callback)
                : $app->{$verb}($method, $uri, self::viaController($callback));
        else 
            return (is_callable($callback))
                ? $app->{$verb}($uri, $callback)
                : $app->{$verb}($uri, self::viaController($callback));
    }

    private static function viaController($callback)
    {
        switch(true)
        {
            case is_array($callback):

                $controller = Arr::first($callback);

                $method = Arr::last($callback);

            break;
            case is_string($callback):
                
                $controller = Str::before($callback, '@');

                $method = Str::after($callback, '@');
            break;
        }

        return [$controller, $method];
    }

    private static function validation(string $path, $callback, $verb)
    {

        $arrController = (is_array($callback) && count($callback) === 2);

        $strController = (is_string($callback) && count(explode('@', $callback)) == 2 && Str::is('*@*', $callback));

        $message = 'Unresolvable Route Callback or Controller action';

        $context = json_encode(compact('path', 'callback', 'verb'));

        $fails = !(is_callable($callback) or $arrController or $strController);

        throw_if($fails, $message, $context);
    }


}
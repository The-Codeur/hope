<?php
namespace App\Http\Core;

use App\Http\Request\Request;
use App\Http\Request\Response;

class Middleware
{
    public static function execute(array $middlewares, Request &$request, Response &$response)
    {
        foreach($middlewares as $middleware)
        {
            $response = static::call($middleware, $request, $response, function($request, $response){
                
                return $response;

            });
        }
    }


    private static function call(&$middleware, Request &$request, Response &$response, callable $next)
    {
        return call_user_func_array([new $middleware, '__invoke'], [$request, $response, $next]);
    }
}
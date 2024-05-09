<?php
namespace App\Http\Middlewares;

use App\Http\Core\AbstractMiddleware;
use App\Http\Request\Request;
use App\Http\Request\Response;

class SetTurboHeaderMiddleware extends AbstractMiddleware
{
    public function __invoke(Request $request, Response $response, callable $next)
    {
        if(isTurbo()) header('Content-Type: text/vnd.turbo-stream.html; charset=utf-8');
        
        return $next($request, $response);
    }
}
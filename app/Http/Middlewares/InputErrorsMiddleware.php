<?php
namespace App\Http\Middlewares;

use Illuminate\Support\Str;
use App\Http\Request\Request;
use App\Http\Request\Response;
use App\Http\Core\AbstractMiddleware;

class InputErrorsMiddleware extends AbstractMiddleware
{
    public function __invoke(Request $request, Response $response, callable $next)
    {

        $csrf = $this->resolve('csrf');
   
        if(($request->getMethod() === 'POST' && !Str::contains(substr($request->getUri(), 0,4), 'api') && !$csrf->check($request->getParam(config('guard.name')))))
        {
            return back();
        }

        return $next($request, $response);
    }
}

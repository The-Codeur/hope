<?php

namespace Meerkat\Router;

use App\Http\Core\Middleware;
use App\Http\Request\Request;
use App\Http\Request\Response;
use DI\Container;
use Meerkat\Router\RouteException;

class Dispatcher
{
    private array $matches = [];

    private array $params = [];

    private array $routename = [];

    protected array $middlewares = [];

    public function __construct(
        protected string $path,
        protected $callback,
        protected ?Container $container = null,
    ) {
    }

    public function match($uri)
    {

        $path = preg_replace_callback('#:([\w]+)#i', [$this, 'paramMatch'], $this->path);

        if (!preg_match("#^{$path}$#", $uri, $results)) {
            return false;
        }

        $this->matches = $results;

        return true;
    }

    public function with(string $param, string $regex)
    {
        $this->params[$param] = str_replace('(', '(?:', $regex);

        return $this;
    }

    public function add($middleware)
    {
       is_array($middleware) ? $this->middlewares = $middleware
                             : array_push($this->middlewares, $middleware);

        return $this;
    }

    public function name(string $name = '')
    {
        $this->routename[$name][] = $this->path;

        return $this->routename;
    }

    public function launch()
    {
        $container = $this->container;

        $globalMiddleware = $container->get('middleware')['global'];

        $request = $container->get(Request::class);

        $response = $container->get(Response::class);

        array_shift($this->matches);

        Middleware::execute($globalMiddleware, $request, $response);

        $arrController = (is_array($this->callback) and count($this->callback) === 2);

        $strController = (is_string($this->callback) and count(explode('@', $this->callback)) === 2);

        if (!(is_callable($this->callback) or $arrController or $strController)) {
            throw new RouteException('Unresolve Route Callback Or Controller Action');
        }

        $this->executeMiddleware($container, $request, $response);

        if ($this->container) {
         
            echo is_callable($this->callback) ? $container->call($this->callback, $this->matches)
                : $container->call($this->viaController($this->callback, $container), $this->matches);
        } else {

            echo is_callable($this->callback) ? call_user_func_array($this->callback, $this->matches)
                : call_user_func_array($this->viaController($this->callback, $container), $this->matches);
        }

        return;
    }

    private function paramMatch(array $match)
    {
        if (isset($this->params[$match[1]])) {
            return '(' . $this->params[$match[1]] . ')';
        }

        return '([^/]+)';
    }

    private function viaController($callback, $container)
    {
        switch (true) {
            case is_array($callback):

                [$controller, $method] = $callback;

                break;
            case is_string($callback):

                $actions = explode('@', $callback);

                [$controller, $method] = $actions;

                break;
        }

        $controllerNsp = str_contains($controller, '\\') ? $controller : config('controller.namespace') . $controller;
        
        $controller = ($container) ? new $controllerNsp($container) : new $controllerNsp;

        return [$controller, $method];
    }

    private function executeMiddleware(Container $container, Request $request, Response $response)
    {
        $middlewareList = $container->get('middleware')['name'];

        foreach($middlewareList as $abstract => $middleware)
        {
            if(in_array($abstract, $this->middlewares))
            {
                Middleware::execute((array)$middleware, $request, $response);
            }
        }
    }
}

<?php
namespace Meerkat\Router;

use App\Http\Request\Request;
use DI\Container;

trait Router
{
    private array $routes = [];

    private string $prefix = '';

    public function __construct(
        private ?Container $container = null
    )
    {
       
    }


    public function get(string $path, $callback)
    {
        return $this->map('GET', $path, $callback);
    }

    public function post(string $path, $callback)
    {
        return $this->map('POST', $path, $callback);
    }

    public function put(string $path, $callback)
    {
        return $this->map('PUT', $path, $callback);
    }

    public function patch(string $path, $callback)
    {
        return $this->map('PATCH', $path, $callback);
    }

    public function delete(string $path, $callback)
    {
        return $this->map('DELETE', $path, $callback);
    }
    public function any(string $path, $callback)
    {
        return $this->map('GET|POST|PUT|PATCH|DELETE', $path, $callback);
    }

    public function map(string $methods, string $path, $callback)
    {
        $uri = trim($this->prefix.DS.trim($path, DS), DS);

        foreach(explode('|', trim($methods)) as $method)
        {
            $route = new Dispatcher(
                $uri, 
                $callback,
                $this->container
            );

            $this->routes[$method][] = $route;
        }

        return $route;
    }

    public function group(string $prefix, $callback)
    {
        $parent = $this->prefix;

        $this->prefix .= DS.trim($prefix, DS);

        if(is_callable($callback))
        {
            return call_user_func($callback, $this);
        }

        throw new RouteException('Please provide a valid callback'); 

        $this->prefix = $parent;        
    }    

    public function run()
    {
        $request = $this->container->get(Request::class);

        $method = $request->getMethod();

        $uri = $request->getPathInfo();

        if(!isset($this->routes[$method]) && !($method === 'POST' && $request->hasParam('_method')))
        {
            throw new RouteException('Method not allowed');
        }

        if(isset($this->routes[$method]))
        {
            foreach($this->routes[$method] as $route)
            {
               
                if($route->match(trim($uri, DS)))
                {
                    return $route->launch();
                }
            }
        }

        if($method === 'POST' && $request->hasParam('_method'))
        {
            $method = strtoupper($request->getParam('_method'));

            if(isset($this->routes[$method]))
            {
                foreach ($this->routes[$method] as $route) {

                    if ($route->match(trim($uri, DS))) {
                        return $route->launch();
                    }
                }
            }
        }

        RouteException::e404();
    }

    public function url(string $name, array $params = [])
    {
        foreach($this->routes as $key => $values)
        {
            foreach($this->routes[$key] as $routes)
            {
                if(array_key_exists($name, $routes->name()))
                {
                    $route = $routes->name();

                    $path = implode($route[$name]);

                    if(!empty($params))
                    {
                        foreach($params as $key => $param)
                        {
                            $path = str_replace(":{$key}", $param, $path);
                        }
                    }

                    return DS.$path;
                }
            }
        }
    }

}

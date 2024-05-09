<?php
namespace App\Http\Core;

use DI\Container;
use App\Http\Core\Container as AppContainer;

abstract class AbstractMiddleware 
{
    protected Container $container;

    public function __construct()
    {
        $this->container = AppContainer::getInstance();
    }

    protected function bind(string $key, $abstract)
    {
        $this->container->set($key, $abstract);
    }

    protected function resolve(string $abstract)
    {
        return $this->container->get($abstract);
    }
}
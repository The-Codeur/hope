<?php
namespace Boot\Manager;
use App\App;
use DI\Container;

abstract class Bootstrapper
{
    protected  Container $container;
    
    public function __construct(protected App &$app)
    {
        $this->container = $app->getContainer();
    }

    protected function bind(string $key, $abstract)
    {
        $this->container->set($key, $abstract);
    }

    protected function resolve(string $key)
    {
        return $this->container->get($key);
    }

    public static function handle(App &$app, array $loaders)
    {
        $loaders = array_map(fn($loader) => new $loader($app), $loaders);

        array_walk($loaders, fn(Bootstrapper $bootstrap) => $bootstrap->before());

        array_walk($loaders, fn(Bootstrapper $bootstrap) => $bootstrap->boot());

        array_walk($loaders, fn(Bootstrapper $bootstrap) => $bootstrap->after());
    }

    protected function before()
    {

    }

    protected function boot()
    {
    }

    protected function after()
    {
    }
}
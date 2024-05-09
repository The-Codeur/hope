<?php
namespace App\Providers;

use App\App;
use DI\Container;

abstract class AbstractServiceProvider
{
    protected Container $container;

    final public function __construct(protected App &$app)
    {
        $this->container = $app->getContainer();
    }

    abstract public function register();

    abstract public function boot();

    protected function bind(string $key, $abstract)
    {
        $this->container->set($key, $abstract);
    }

    protected function resolve(string $key)
    {
        return $this->container->get($key);
    }

    final public static function handle(App &$app, array $providers)
    {
 
        $providers = array_map(fn($provider) => new $provider($app), $providers);

        array_walk($providers, fn(AbstractServiceProvider $provider) => $provider->register());
        array_walk($providers, fn (AbstractServiceProvider $provider) => $provider->boot());
    }
}
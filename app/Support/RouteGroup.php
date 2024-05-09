<?php
namespace App\Support;

use App\App;
use Meerkat\Router\CollectionRoute;

class RouteGroup
{
    private string $route;
    
    private string $prefix;

    public function __construct(private App $app)
    {

    }

    public function route(string $route)
    {
        $this->route = $route;

        return $this;
    }

    public function prefix(string $prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function register()
    {
        $this->app->group($this->prefix, function(CollectionRoute $app){

            Route::handle($app);

            require_once $this->route;
            return;
        });

        Route::handle($this->app);
        return;
    }
    
}
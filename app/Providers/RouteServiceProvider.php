<?php 
namespace App\Providers;

use App\Support\RouteGroup;

class RouteServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->bind('app', fn() => $this->app);

        $this->bind(RouteGroup::class, fn()=> new RouteGroup($this->app));
    }

    public function boot()
    {
        $this->webRouteGroup()->register();
        $this->apiRouteGroup()->register();
    }

    private function apiRouteGroup()
    {
        $path = routePath('api.php');
        $api = $this->resolve(RouteGroup::class);

        return $api->route($path)->prefix('/api');
    }

    private function webRouteGroup()
    {
        
        $path = routePath('web.php');
        $web = $this->resolve(RouteGroup::class);

        return $web->route($path)->prefix('');
    }
}
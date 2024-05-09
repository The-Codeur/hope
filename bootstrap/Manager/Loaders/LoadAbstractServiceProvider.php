<?php
namespace Boot\Manager\Loaders;

use App\Providers\AbstractServiceProvider;
use Boot\Manager\Bootstrapper;

class LoadAbstractServiceProvider extends Bootstrapper
{
    public function boot()
    {
        AbstractServiceProvider::handle($this->app, config('providers'));
    }
}
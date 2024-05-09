<?php
namespace Boot\Manager\Loaders;

use Whoops\Run;
use Boot\Manager\Bootstrapper;
use Whoops\Handler\PrettyPageHandler;

class LoadDebugPage extends Bootstrapper
{
    public function boot()
    {
        if(config('app_debug') === true)
        {
            $whoops = new Run;
            $whoops->pushHandler(new PrettyPageHandler);
            $whoops->register();
        }
    }
}
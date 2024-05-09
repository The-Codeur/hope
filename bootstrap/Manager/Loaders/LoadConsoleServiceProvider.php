<?php
namespace Boot\Manager\Loaders;

use Boot\Manager\Bootstrapper;
use Command\ConsoleServiceProvider;

class LoadConsoleServiceProvider extends Bootstrapper
{
    public function boot()
    {
        global $argv;
       
        if(isset($argv) and $argv[0] === 'debery')
            ConsoleServiceProvider::handle($this->app, config('console.providers'));

    }
}
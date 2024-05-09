<?php
namespace Boot\Manager\Loaders;

use Dotenv\Dotenv;
use Boot\Manager\Bootstrapper;

class LoadEnvironmentVariable extends Bootstrapper
{
    public function boot()
    {
        $dotenv = Dotenv::createImmutable(BASE_PATH);

        $dotenv->load();
    }
}
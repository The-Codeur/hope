<?php
namespace App\Http\Core;

use DI\ContainerBuilder;

class Container
{
    private static $_instance;

    public static function getInstance()
    {
        if(!isset(self::$_instance))
        {
            $containerBuilder = new ContainerBuilder();
            
            $containerBuilder->useAutowiring(config('container.autowiring'));

            $containerBuilder->useAttributes(config('container.annotations'));

            self::$_instance = $containerBuilder->build();
        }

        return self::$_instance;
    }

}
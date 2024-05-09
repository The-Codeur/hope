<?php
namespace Boot\Manager;

class HttpKernel extends Kernel
{
    public array $middlewares = [

    ];

    public array $middlewareName = [
        
    ];

    public array $bootstrap = [
        Loaders\LoadEnvironmentVariable::class,
        Loaders\LoadDebugPage::class,
        Loaders\LoadMiddleware::class,
        Loaders\LoadAbstractServiceProvider::class,
        //Loaders\LoadConsoleServiceProvider::class,   
    ];
}
<?php
namespace App\Http\Core;

use Boot\Manager\HttpKernel as Kernel;

class HttpKernel extends Kernel
{
    public array $middlewares = [
        \App\Http\Middlewares\SetTurboHeaderMiddleware::class,
        \App\Http\Middlewares\InputErrorsMiddleware::class,
    ];

    public array $middlewareName = [
        
    ];
}
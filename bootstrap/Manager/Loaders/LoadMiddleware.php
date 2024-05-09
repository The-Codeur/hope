<?php
namespace Boot\Manager\Loaders;

use Boot\Manager\Bootstrapper;
use Boot\Manager\Kernel;

class LoadMiddleware extends Bootstrapper
{
    public function boot()
    {
        $kernel = $this->resolve(Kernel::class);

        $this->bind('middleware', fn() => [

            'name'    => $kernel->middlewareName,

            'global' => $kernel->middlewares
        ]);
    }
}
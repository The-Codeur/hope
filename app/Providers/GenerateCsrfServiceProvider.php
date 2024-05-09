<?php
namespace App\Providers;

class GenerateCsrfServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        
        $csrf = $this->resolve('csrf');

        if(!$csrf->has())
        {
            $csrf->generate();
        }

    }

    public function boot()
    {
        
    }
}
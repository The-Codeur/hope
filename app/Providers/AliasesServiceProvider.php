<?php 
namespace App\Providers;

class AliasesServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $aliases = config('aliases');

        array_walk($aliases, function($class, $alias){

            class_alias($class, $alias);
          
            $class = $this->resolve($class);

            $this->bind($alias, fn() => $class);
        });
    }

    public function boot()
    {
    }
}
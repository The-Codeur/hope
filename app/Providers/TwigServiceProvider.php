<?php
namespace App\Providers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->bind('view', function(){

            $loader = new FilesystemLoader(config('view.path'));

            $twig = new Environment($loader, config('view.options'));

            return $twig;
        });
    }

    public function boot()
    {
    }
}
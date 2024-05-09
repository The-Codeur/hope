<?php

namespace App\Providers;

use App\Views\Extensions\TwigFilterExtension;
use App\Views\Extensions\TwigFunctionExtension;
use App\Views\Extensions\TwigGlobalExtension;
use Twig\Extension\DebugExtension;

class TwigExtensionServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $twig = $this->resolve('view');

        $twig->addExtension(new DebugExtension);

        $twig->addExtension(new TwigGlobalExtension);

        $twig->addExtension(new TwigFunctionExtension);

        $twig->addExtension(new TwigFilterExtension);
    }

    public function boot()
    {
    }
}

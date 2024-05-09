<?php

return [

    'providers' => [
        App\Providers\HttpServiceProvider::class,
        App\Providers\SecureServiceProvider::class,
        App\Providers\SessionStartServiceProvider::class,
        App\Providers\GenerateCsrfServiceProvider::class,
        App\Providers\DatabaseServiceProvider::class,
        App\Providers\TwigServiceProvider::class,
        App\Providers\TwigExtensionServiceProvider::class,
        App\Providers\AliasesServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
    ]
];

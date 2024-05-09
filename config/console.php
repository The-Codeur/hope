<?php

return [
    'console' => [
        'providers' => [
            Command\Providers\MigrationServiceProvider::class,
            Command\Providers\SeederServiceProvider::class,
            Command\Providers\HelperServiceProvider::class,
            Command\Providers\ExtendsServiceProvider::class,
        ]
    ]
];
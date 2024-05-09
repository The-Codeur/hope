<?php

return [

    'view' => [

        'path' => env('TEMPLATE_PATH', basePath('src/views' . DS)),

        'options' => [
            'cache' => env('TEMPLATE_CACHE', false),
            'debug' => env('APP_DEBUG', false)
        ],
    ]
];
<?php
return [
    'name' => 'لوحة التحكم',
    'manifest' => [
        'name' => 'لوحة التحكم',
        'short_name' => 'لوحة التحكم',
        'start_url' => '/statistics',
        'background_color' => '#ffffff',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'orientation' => 'any',
        'status_bar' => 'black',
        'icons' => [
            '72x72' => [
                'path' => '/logo.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '/logo.png',
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => '/logo.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '/logo.png',
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => '/logo.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/logo.png',
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => '/logo.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/logo.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => '/logo.png',
            '750x1334' => '/logo.png',
            '828x1792' => '/logo.png',
            '1125x2436' => '/logo.png',
            '1242x2208' => '/logo.png',
            '1242x2688' => '/logo.png',
            '1536x2048' => '/logo.png',
            '1668x2224' => '/logo.png',
            '1668x2388' => '/logo.png',
            '2048x2732' => '/logo.png',
        ],
        'shortcuts' => [
            [
                'name' => 'لوحة التحكم',
                'description' => 'لوحة التحكم ',
                'url' => '/statistics',
                'icons' => [
                    "src" => "/logo.png",
                    "purpose" => "any"
                ]
            ],
            [
                'name' => 'لوحة التحكم',
                'description' => 'لوحة التحكم ',
                'url' => '/statistics'
            ]
        ],
        'custom' => []
    ]
];

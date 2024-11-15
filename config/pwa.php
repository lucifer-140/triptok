<?php

return [
    'name' => 'My App',
    'short_name' => 'App',
    'description' => 'A cool app built with Laravel',
    'theme_color' => '#4A90E2',
    'background_color' => '#ffffff',
    'icons' => [
        '72x72' => '/icon-72x72.png',
        '96x96' => '/icon-96x96.png',
        '128x128' => '/icon-128x128.png',
        '144x144' => '/icon-144x144.png',
        '192x192' => '/icon-192x192.png',
    ],
    'service_worker' => [
        'enabled' => true,
        'filename' => 'service-worker.js',
    ],
];

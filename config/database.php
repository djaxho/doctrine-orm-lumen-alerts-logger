<?php

return [
    'connections' => [
        'mysql' => [
            'host'      => getenv('DB_HOST'),
            'driver'    => getenv('DB_DRIVER') ?: 'mysql',
            'database'  => getenv('DB_DATABASE'),
            'username'  => getenv('DB_USERNAME'),
            'password'  => getenv('DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],
    ],
    'redis' => [
        'cluster' => env('REDIS_CLUSTER', false),
        'default' => [
            'host'     => env('REDIS_HOST', '127.0.0.1'),
            'port'     => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DATABASE', 0),
            'password' => env('REDIS_PASSWORD', null),
        ],
    ],
];

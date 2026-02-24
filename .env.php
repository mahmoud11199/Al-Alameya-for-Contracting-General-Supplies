<?php
return [
    'app' => [
        'name' => 'Al Alameya for Contracting & General Supplies',
        'url' => 'https://your-domain.aeonfree.com',
        'env' => 'production',
        'debug' => false,
        'timezone' => 'Africa/Cairo',
        'cache_path' => __DIR__ . '/cache',
        'uploads_url' => '/uploads/',
        'uploads_path' => __DIR__ . '/public_html/uploads/',
    ],
    'db' => [
        'host' => 'sqlXXX.byetcluster.com',
        'dbname' => 'epiz_xxxxx_alameya',
        'user' => 'epiz_xxxxx',
        'pass' => 'CHANGE_ME',
        'charset' => 'utf8mb4',
    ],
    'security' => [
        'session_name' => 'ALAMEYASESSID',
        'csrf_key' => 'CHANGE_WITH_LONG_RANDOM_STRING',
    ],
];

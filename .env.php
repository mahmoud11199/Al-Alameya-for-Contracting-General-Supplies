<?php
return [
    'app' => [
        'name' => 'Al Alameya for Contracting & General Supplies',
        'url' => 'https://your-domain.aeonfree.com',
        'env' => 'production',
        'debug' => false,
        'timezone' => 'Africa/Cairo',
    ],
    'db' => [
        'host' => 'sqlXXX.byetcluster.com',
        'dbname' => 'epiz_xxxxx_alameya',
        'user' => 'epiz_xxxxx',
        'pass' => 'CHANGE_ME',
        'charset' => 'utf8mb4',
        'connect_timeout' => 5,
    ],
    'security' => [
        'session_name' => 'ALAMEYASESSID',
        'csrf_key' => 'CHANGE_WITH_LONG_RANDOM_STRING',
        'contact_rate_limit_seconds' => 30,
        'login_rate_limit_seconds' => 2,
    ],
    'performance' => [
        'cache_enabled' => true,
        'cache_path' => __DIR__ . '/cache',
        'cache_ttl_home' => 180,
        'cache_ttl_settings' => 300,
        'max_upload_size_bytes' => 1048576,
    ],
];

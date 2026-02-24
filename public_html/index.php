<?php
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    if (strpos($class, $prefix) !== 0) {
        return;
    }
    $relative = str_replace('\\', '/', substr($class, strlen($prefix)));
    $parts = explode('/', $relative);
    if (!empty($parts[0])) {
        $parts[0] = strtolower($parts[0]);
    }
    $path = dirname(__DIR__) . '/app/' . implode('/', $parts) . '.php';
    if (file_exists($path)) {
        require $path;
    }
});

$config = require dirname(__DIR__) . '/.env.php';
date_default_timezone_set($config['app']['timezone']);
session_name($config['security']['session_name']);
session_start();

use App\Core\Router;
use App\Controllers\PageController;

$router = new Router();
$router->get('/', [PageController::class, 'home']);
$router->get('/about', [PageController::class, 'about']);
$router->get('/services', [PageController::class, 'services']);
$router->get('/projects', [PageController::class, 'projects']);
$router->get('/blog', [PageController::class, 'blog']);
$router->get('/careers', [PageController::class, 'careers']);
$router->get('/contact', [PageController::class, 'contact']);
$router->post('/contact-submit', [PageController::class, 'submitContact']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

<?php
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    if (strpos($class, $prefix) !== 0) {
        return;
    }
    $relative = str_replace('\\', '/', substr($class, strlen($prefix)));
    $parts = explode('/', $relative);
    $parts[0] = strtolower($parts[0]);
    $path = dirname(__DIR__) . '/app/' . implode('/', $parts) . '.php';
    if (file_exists($path)) {
        require $path;
    }
});

$config = require dirname(__DIR__) . '/.env.php';
date_default_timezone_set($config['app']['timezone']);
session_name($config['security']['session_name']);
session_start();

function e(string $value): string { return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); }

function adminLayoutStart(string $title): void {
    echo '<!doctype html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>' . e($title) . '</title><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"></head><body class="bg-light"><div class="container py-4">';
}
function adminLayoutEnd(): void {
    echo '</div><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script></body></html>';
}

function validateUpload(array $file): ?string {
    $config = require dirname(__DIR__) . '/.env.php';
    $maxSize = (int) ($config['performance']['max_upload_size_bytes'] ?? 1048576);

    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return null;
    }
    if (($file['size'] ?? 0) > $maxSize) {
        return null;
    }

    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return null;
    }
    if (($file['size'] ?? 0) > 2 * 1024 * 1024) {
        return null;
    }
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    if (!isset($allowed[$mime])) {
        return null;
    }

    $name = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
    $target = dirname(__DIR__) . '/public_html/uploads/' . $name;
    if (!move_uploaded_file($file['tmp_name'], $target)) {
        return null;
    }
    return '/uploads/' . $name;
}

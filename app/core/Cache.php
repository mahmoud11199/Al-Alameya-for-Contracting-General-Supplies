<?php
namespace App\Core;

class Cache
{
    public static function remember(string $key, int $ttl, callable $callback)
    {
        $config = require dirname(__DIR__, 2) . '/.env.php';
        $path = rtrim($config['app']['cache_path'], '/') . '/' . md5($key) . '.cache';

        if (file_exists($path) && (time() - filemtime($path) < $ttl)) {
            return unserialize((string) file_get_contents($path));
        }

        $data = $callback();
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }
        file_put_contents($path, serialize($data));
        return $data;
    }

    public static function clear(): void
    {
        $config = require dirname(__DIR__, 2) . '/.env.php';
        foreach (glob(rtrim($config['app']['cache_path'], '/') . '/*.cache') ?: [] as $file) {
            @unlink($file);
        }
    }
}

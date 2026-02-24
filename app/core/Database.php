<?php
namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    public static function connection(): PDO
    {
        if (self::$connection !== null) {
            return self::$connection;
        }

        $config = require dirname(__DIR__, 2) . '/.env.php';
        $db = $config['db'];
        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $db['host'], $db['dbname'], $db['charset']);

        try {
            self::$connection = new PDO($dsn, $db['user'], $db['pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_TIMEOUT => (int) ($db['connect_timeout'] ?? 5),
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            exit('Database connection failed.');
        }

        return self::$connection;
    }
}

<?php
namespace App\Models;

use App\Core\Cache;

class Setting extends BaseModel
{
    public function allKeyed(): array
    {
        $config = require dirname(__DIR__, 2) . '/.env.php';
        return Cache::remember('settings_all_keyed', (int) ($config['performance']['cache_ttl_settings'] ?? 300), function (): array {
            $stmt = $this->db->query('SELECT setting_key, setting_value FROM settings');
            $rows = $stmt->fetchAll();
            $data = [];
            foreach ($rows as $row) {
                $data[$row['setting_key']] = $row['setting_value'];
            }
            return $data;
        });
    }
}

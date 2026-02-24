<?php
namespace App\Models;

class Setting extends BaseModel
{
    public function allKeyed(): array
    {
        $stmt = $this->db->query('SELECT setting_key, setting_value FROM settings');
        $rows = $stmt->fetchAll();
        $data = [];
        foreach ($rows as $row) {
            $data[$row['setting_key']] = $row['setting_value'];
        }
        return $data;
    }
}

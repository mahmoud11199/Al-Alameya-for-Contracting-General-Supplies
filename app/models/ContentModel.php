<?php
namespace App\Models;

class ContentModel extends BaseModel
{
    public function getAll(string $table, int $limit = 100): array
    {
        $allowed = ['projects', 'services', 'blog_posts'];
        if (!in_array($table, $allowed, true)) {
            return [];
        }

        $sql = "SELECT * FROM {$table} ORDER BY id DESC LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPublishedBlog(): array
    {
        $stmt = $this->db->query('SELECT * FROM blog_posts WHERE status = "published" ORDER BY published_at DESC');
        return $stmt->fetchAll();
    }

    public function create(string $table, array $data): bool
    {
        $allowed = ['projects', 'services', 'blog_posts'];
        if (!in_array($table, $allowed, true)) {
            return false;
        }

        $columns = array_keys($data);
        $fields = implode(',', $columns);
        $holders = ':' . implode(',:', $columns);
        $stmt = $this->db->prepare("INSERT INTO {$table} ({$fields}) VALUES ({$holders})");
        return $stmt->execute($data);
    }

    public function delete(string $table, int $id): bool
    {
        $allowed = ['projects', 'services', 'blog_posts'];
        if (!in_array($table, $allowed, true)) {
            return false;
        }
        $stmt = $this->db->prepare("DELETE FROM {$table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function stats(): array
    {
        $tables = ['projects', 'services', 'blog_posts', 'messages'];
        $stats = [];
        foreach ($tables as $table) {
            $stats[$table] = (int) $this->db->query("SELECT COUNT(*) c FROM {$table}")->fetch()['c'];
        }
        return $stats;
    }

    public function saveMessage(array $data): bool
    {
        $stmt = $this->db->prepare('INSERT INTO messages (name, email, phone, subject, message) VALUES (:name, :email, :phone, :subject, :message)');
        return $stmt->execute($data);
    }
}

<?php
namespace App\Models;

class User extends BaseModel
{
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT u.*, r.name as role_name FROM users u JOIN roles r ON r.id = u.role_id WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch() ?: null;
    }

    public function all(): array
    {
        return $this->db->query('SELECT u.id, u.name, u.email, r.name role_name, u.created_at FROM users u JOIN roles r ON r.id = u.role_id ORDER BY u.id DESC')->fetchAll();
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare('INSERT INTO users (name, email, password, role_id) VALUES (:name, :email, :password, :role_id)');
        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM users WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function roles(): array
    {
        return $this->db->query('SELECT * FROM roles ORDER BY id')->fetchAll();
    }
}

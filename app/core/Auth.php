<?php
namespace App\Core;

class Auth
{
    protected $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function user()
    {
        if (empty($_SESSION['user_id'])) return null;
        $stmt = $this->db->pdo()->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $_SESSION['user_id']]);
        return $stmt->fetch();
    }

    public function check()
    {
        return !empty($_SESSION['user_id']);
    }

    public function isAdmin()
    {
        $u = $this->user();
        return $u && $u['role'] === 'admin';
    }

    public function requireAdmin()
    {
        if (!$this->isAdmin()) {
            $_SESSION['flash'] = 'Admin access required';
            header('Location: /admin/login');
            exit;
        }
    }
}

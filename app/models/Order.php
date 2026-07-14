<?php
namespace App\Models;

class Order
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function find($id)
    {
        $stmt = $this->db->pdo()->prepare('SELECT o.*, u.email as user_email FROM orders o LEFT JOIN users u ON o.user_id = u.id WHERE o.id = :id');
        $stmt->execute([':id'=>$id]);
        return $stmt->fetch();
    }

    public function getByUser($userId)
    {
        $stmt = $this->db->pdo()->prepare('SELECT * FROM orders WHERE user_id = :u ORDER BY created_at DESC');
        $stmt->execute([':u'=>$userId]);
        return $stmt->fetchAll();
    }
}

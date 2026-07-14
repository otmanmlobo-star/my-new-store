<?php
namespace App\Models;

class Review
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getByProduct($productId)
    {
        $stmt = $this->db->pdo()->prepare('SELECT r.*, u.name FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.product_id = :p ORDER BY r.created_at DESC');
        $stmt->execute([':p'=>$productId]);
        return $stmt->fetchAll();
    }

    public function create($productId, $userId, $rating, $comment)
    {
        $stmt = $this->db->pdo()->prepare('INSERT INTO reviews (product_id,user_id,rating,comment) VALUES (:p,:u,:r,:c)');
        return $stmt->execute([':p'=>$productId,':u'=>$userId,':r'=>$rating,':c'=>$comment]);
    }
}

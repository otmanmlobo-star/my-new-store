<?php
namespace App\Models;

class Product
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getFeatured($limit = 6)
    {
        $stmt = $this->db->pdo()->prepare('SELECT * FROM products ORDER BY downloads DESC LIMIT :l');
        $stmt->bindValue(':l', (int)$limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getLatest($limit = 8)
    {
        $stmt = $this->db->pdo()->prepare('SELECT * FROM products ORDER BY created_at DESC LIMIT :l');
        $stmt->bindValue(':l', (int)$limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->db->pdo()->prepare('SELECT p.*, u.name as seller_name FROM products p JOIN users u ON p.seller_id = u.id WHERE p.id = :id');
        $stmt->execute([':id'=>$id]);
        return $stmt->fetch();
    }

    public function create($seller_id,$category_id,$title,$description,$price,$file_path,$thumbnail)
    {
        $slug = strtolower(preg_replace('/[^a-z0-9]+/','-', $title));
        $stmt = $this->db->pdo()->prepare('INSERT INTO products (seller_id,category_id,title,slug,description,price,file_path,thumbnail) VALUES (:s,:c,:t,:sl,:d,:p,:f,:th)');
        return $stmt->execute([':s'=>$seller_id,':c'=>$category_id,':t'=>$title,':sl'=>$slug,':d'=>$description,':p'=>$price,':f'=>$file_path,':th'=>$thumbnail]);
    }
}

<?php
namespace App\Models;

class Coupon
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findByCode($code)
    {
        $stmt = $this->db->pdo()->prepare('SELECT * FROM coupons WHERE code = :c AND active = 1 AND (expires_at IS NULL OR expires_at > NOW()) LIMIT 1');
        $stmt->execute([':c'=>$code]);
        return $stmt->fetch();
    }

    public function create($code, $type, $value, $expires = null)
    {
        $stmt = $this->db->pdo()->prepare('INSERT INTO coupons (code,type,value,active,expires_at) VALUES (:c,:t,:v,1,:e)');
        return $stmt->execute([':c'=>$code,':t'=>$type,':v'=>$value,':e'=>$expires]);
    }
}

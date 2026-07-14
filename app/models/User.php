<?php
namespace App\Models;

class User
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getByEmail($email)
    {
        $stmt = $this->db->pdo()->prepare('SELECT * FROM users WHERE email = :e LIMIT 1');
        $stmt->execute([':e' => $email]);
        return $stmt->fetch();
    }

    public function create($name, $email, $password)
    {
        $stmt = $this->db->pdo()->prepare('INSERT INTO users (name,email,password,role,email_verified) VALUES (:n,:e,:p,\'seller\',1)');
        return $stmt->execute([':n'=>$name,':e'=>$email,':p'=>$password]);
    }
}

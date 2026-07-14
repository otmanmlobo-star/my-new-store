<?php
namespace App\Core;

use PDO;

class Database
{
    private $pdo;
    public function __construct(array $config)
    {
        $dsn = "mysql:host={$config['host']};dbname={$config['db']};charset={$config['charset']}";
        $this->pdo = new PDO($dsn, $config['user'], $config['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    public function pdo()
    {
        return $this->pdo;
    }
}

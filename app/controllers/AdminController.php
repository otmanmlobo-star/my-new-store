<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth as AuthCore;

class AdminController extends Controller
{
    public function index()
    {
        $auth = new AuthCore($this->db);
        $auth->requireAdmin();

        $pdo = $this->db->pdo();
        $userCount = $pdo->query('SELECT COUNT(*) as c FROM users')->fetch()['c'];
        $productCount = $pdo->query('SELECT COUNT(*) as c FROM products')->fetch()['c'];
        $orderCount = $pdo->query('SELECT COUNT(*) as c FROM orders')->fetch()['c'];

        // sales per last 7 days
        $stmt = $pdo->query("SELECT DATE(created_at) as day, COUNT(*) as orders FROM orders WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) GROUP BY DATE(created_at)");
        $sales = $stmt->fetchAll();

        echo $this->view('admin/dashboard', ['users' => $userCount, 'products' => $productCount, 'orders' => $orderCount, 'sales' => $sales]);
    }
}

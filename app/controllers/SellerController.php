<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth as AuthCore;
use App\Models\Product;
use App\Models\Coupon;

class SellerController extends Controller
{
    public function dashboard()
    {
        $auth = new AuthCore($this->db);
        if (!$auth->check()) { header('Location: /login'); exit; }
        $user = $auth->user();
        if ($user['role'] !== 'seller') { $_SESSION['flash']='Access denied'; header('Location:/'); exit; }

        $pdo = $this->db->pdo();
        $stmt = $pdo->prepare('SELECT * FROM products WHERE seller_id = :s');
        $stmt->execute([':s'=>$user['id']]);
        $products = $stmt->fetchAll();

        echo $this->view('seller/dashboard', ['products'=>$products, 'user'=>$user]);
    }

    public function coupons()
    {
        $auth = new AuthCore($this->db);
        if (!$auth->check()) { header('Location: /login'); exit; }
        $user = $auth->user();
        if ($user['role'] !== 'seller') { $_SESSION['flash']='Access denied'; header('Location:/'); exit; }

        $couponModel = new Coupon($this->db);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = strtoupper(trim($_POST['code']));
            $type = $_POST['type'];
            $value = floatval($_POST['value']);
            $couponModel->create($code,$type,$value,null);
            $_SESSION['flash'] = 'Coupon created';
            header('Location: /seller/coupons'); exit;
        }
        echo $this->view('seller/coupons');
    }
}

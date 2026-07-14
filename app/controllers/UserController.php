<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth as AuthCore;
use App\Models\Order;

class UserController extends Controller
{
    public function profile()
    {
        $auth = new AuthCore($this->db);
        if (!$auth->check()) { header('Location: /login'); exit; }
        $user = $auth->user();
        $orderModel = new Order($this->db);
        $orders = $orderModel->getByUser($user['id']);
        echo $this->view('user/profile', ['user'=>$user, 'orders'=>$orders]);
    }
}

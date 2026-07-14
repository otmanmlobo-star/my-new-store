<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth as AuthCore;

class AdminAuthController extends Controller
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $auth = new AuthCore($this->db);
            $user = $this->db->pdo()->prepare('SELECT * FROM users WHERE email = :e LIMIT 1');
            $user->execute([':e' => $email]);
            $u = $user->fetch();
            if ($u && password_verify($password, $u['password']) && $u['role'] === 'admin') {
                $_SESSION['user_id'] = $u['id'];
                header('Location: /admin'); exit;
            }
            $_SESSION['flash'] = 'Invalid admin credentials';
        }
        echo $this->view('admin/login');
    }

    public function logout()
    {
        session_destroy();
        header('Location: /'); exit;
    }
}

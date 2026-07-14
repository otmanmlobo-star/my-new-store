<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $userModel = new User($this->db);
            $user = $userModel->getByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                // Set session
                $_SESSION['user_id'] = $user['id'];
                header('Location: /');
                exit;
            }
            $_SESSION['flash'] = 'Invalid credentials';
        }
        echo $this->view('auth/login');
    }

    public function logout()
    {
        session_destroy();
        header('Location: /');
        exit;
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            if ($name && $email && $password) {
                $userModel = new User($this->db);
                if ($userModel->getByEmail($email)) {
                    $_SESSION['flash'] = 'Email already registered';
                } else {
                    $userModel->create($name, $email, password_hash($password, PASSWORD_DEFAULT));
                    $_SESSION['flash'] = 'Registration successful. Please login.';
                    header('Location: /login');
                    exit;
                }
            } else {
                $_SESSION['flash'] = 'Fill all fields';
            }
        }
        echo $this->view('auth/register');
    }
}

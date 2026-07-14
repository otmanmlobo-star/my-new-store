<?php
namespace App\Core;

class Csrf
{
    public static function token()
    {
        if (empty($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(16));
        }
        return $_SESSION['_csrf_token'];
    }

    public static function check($token)
    {
        return isset($_SESSION['_csrf_token']) && hash_equals($_SESSION['_csrf_token'], $token);
    }
}

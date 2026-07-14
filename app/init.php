<?php
// extended init: existing requires kept, plus ensure admin user exists
require_once __DIR__.'/config/config.php';
require_once __DIR__.'/core/Database.php';
require_once __DIR__.'/core/Controller.php';
require_once __DIR__.'/core/Auth.php';
require_once __DIR__.'/controllers/HomeController.php';
require_once __DIR__.'/controllers/AuthController.php';
require_once __DIR__.'/controllers/ProductController.php';
require_once __DIR__.'/controllers/AdminController.php';
require_once __DIR__.'/controllers/AdminAuthController.php';
require_once __DIR__.'/models/User.php';
require_once __DIR__.'/models/Product.php';

// create DB connection and ensure admin seed
$db = new App\Core\Database($config['db']);
$pdo = $db->pdo();

// Create admin account if it doesn't exist
try {
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :e LIMIT 1');
    $stmt->execute([':e' => 'admin@example.com']);
    $exists = $stmt->fetch();
    if (!$exists) {
        $hash = password_hash('AdminPass123', PASSWORD_DEFAULT);
        $pdo->prepare('INSERT INTO users (name,email,password,role,email_verified) VALUES (:n,:e,:p,:r,1)')
            ->execute([':n' => 'Administrator', ':e' => 'admin@example.com', ':p' => $hash, ':r' => 'admin']);
    }
} catch (\Exception $e) {
    // ignore during install when DB not yet imported
}

// expose $config for public/index.php

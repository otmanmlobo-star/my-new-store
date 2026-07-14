<?php
// updated init to include new controllers and models
require_once __DIR__.'/config/config.php';
require_once __DIR__.'/core/Database.php';
require_once __DIR__.'/core/Controller.php';
require_once __DIR__.'/core/Auth.php';
require_once __DIR__.'/core/Csrf.php';
require_once __DIR__.'/core/Jwt.php';
require_once __DIR__.'/core/Mailer.php';

require_once __DIR__.'/controllers/HomeController.php';
require_once __DIR__.'/controllers/AuthController.php';
require_once __DIR__.'/controllers/ProductController.php';
require_once __DIR__.'/controllers/AdminController.php';
require_once __DIR__.'/controllers/AdminAuthController.php';
require_once __DIR__.'/controllers/CheckoutController.php';
require_once __DIR__.'/controllers/SellerController.php';
require_once __DIR__.'/controllers/UserController.php';

require_once __DIR__.'/models/User.php';
require_once __DIR__.'/models/Product.php';
require_once __DIR__.'/models/Order.php';
require_once __DIR__.'/models/Coupon.php';
require_once __DIR__.'/models/Review.php';

// create DB connection and ensure admin seed
$db = new App\Core\Database($config['db']);
$pdo = $db->pdo();

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

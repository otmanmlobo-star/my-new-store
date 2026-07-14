<?php
// add new routes for checkout in the front controller
// (This file replaces public/index.php with added routes — keep other routes unchanged)
require_once __DIR__.'/../app/init.php';

use App\Core\Database;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\ProductController;
use App\Controllers\AdminController;
use App\Controllers\AdminAuthController;
use App\Controllers\CheckoutController;

$db = new App\Core\Database($config['db']);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = trim($path, '/');
$segments = explode('/', $path);

session_start();

if ($path === '' || $path === 'index.php') {
    $ctrl = new HomeController($db);
    $ctrl->index();
    exit;
}
if ($path === 'login') { $ctrl = new AuthController($db); $ctrl->login(); exit; }
if ($path === 'logout') { $ctrl = new AuthController($db); $ctrl->logout(); exit; }
if ($path === 'register') { $ctrl = new AuthController($db); $ctrl->register(); exit; }
if ($segments[0] === 'product' && isset($segments[1])) { $ctrl = new ProductController($db); $ctrl->view((int)$segments[1]); exit; }
if ($path === 'seller/upload') { $ctrl = new ProductController($db); $ctrl->upload(); exit; }

// checkout routes
if ($path === 'cart') { $ctrl = new CheckoutController($db); $ctrl->cart(); exit; }
if ($path === 'checkout') { $ctrl = new CheckoutController($db); $ctrl->checkout(); exit; }
if ($segments[0] === 'invoice' && isset($segments[1])) { $ctrl = new CheckoutController($db); $ctrl->invoice((int)$segments[1]); exit; }

// admin routes
if ($path === 'admin') { $ctrl = new AdminController($db); $ctrl->index(); exit; }
if ($path === 'admin/login') { $ctrl = new AdminAuthController($db); $ctrl->login(); exit; }
if ($path === 'admin/logout') { $ctrl = new AdminAuthController($db); $ctrl->logout(); exit; }

// static files and 404
http_response_code(404);
include __DIR__.'/../app/views/errors/404.php';

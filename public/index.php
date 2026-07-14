<?php
// front controller (routes extended further)
require_once __DIR__.'/../app/init.php';

use App\Core\Database;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\ProductController;
use App\Controllers\AdminController;
use App\Controllers\AdminAuthController;
use App\Controllers\CheckoutController;
use App\Controllers\SellerController;
use App\Controllers\UserController;

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

// seller
if ($path === 'seller/dashboard') { $ctrl = new SellerController($db); $ctrl->dashboard(); exit; }
if ($path === 'seller/coupons') { $ctrl = new SellerController($db); $ctrl->coupons(); exit; }

// user
if ($path === 'profile') { $ctrl = new UserController($db); $ctrl->profile(); exit; }

// checkout routes
if ($path === 'cart') { $ctrl = new CheckoutController($db); $ctrl->cart(); exit; }
if ($path === 'checkout') { $ctrl = new CheckoutController($db); $ctrl->checkout(); exit; }
if ($segments[0] === 'invoice' && isset($segments[1])) { $ctrl = new CheckoutController($db); $ctrl->invoice((int)$segments[1]); exit; }

// pages
if ($path === 'about') { include __DIR__.'/../app/views/pages/about.php'; exit; }
if ($path === 'faq') { include __DIR__.'/../app/views/pages/faq.php'; exit; }
if ($path === 'contact') { include __DIR__.'/../app/views/pages/contact.php'; exit; }
if ($path === 'blog') { include __DIR__.'/../app/views/blog/index.php'; exit; }

// admin routes
if ($path === 'admin') { $ctrl = new AdminController($db); $ctrl->index(); exit; }
if ($path === 'admin/login') { $ctrl = new AdminAuthController($db); $ctrl->login(); exit; }
if ($path === 'admin/logout') { $ctrl = new AdminAuthController($db); $ctrl->logout(); exit; }

// static files and 404
http_response_code(404);
include __DIR__.'/../app/views/errors/404.php';

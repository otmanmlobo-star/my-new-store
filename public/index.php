<?php
// front controller
require_once __DIR__.'/../app/init.php';

use App\Core\Database;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\ProductController;

$db = new Database($config['db']);
$pdo = $db->pdo();

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = trim($path, '/');
$segments = explode('/', $path);

session_start();

// Basic routing
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

// static files and 404
http_response_code(404);
include __DIR__.'/../app/views/errors/404.php';

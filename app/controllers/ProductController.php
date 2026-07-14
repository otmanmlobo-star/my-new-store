<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function view($id)
    {
        $productModel = new Product($this->db);
        $product = $productModel->find($id);
        if (!$product) {
            http_response_code(404);
            echo $this->view('errors/404');
            return;
        }
        echo $this->view('product/view', ['product' => $product]);
    }

    public function upload()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login'); exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $price = floatval($_POST['price'] ?? 0);
            $desc = $_POST['description'] ?? '';
            $file = $_FILES['file'] ?? null;
            if ($file && $file['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $safeName = 'uploads/'.uniqid().'_'.basename($file['name']);
                move_uploaded_file($file['tmp_name'], __DIR__.'/../../public/'.$safeName);
                $productModel = new Product($this->db);
                $productModel->create($_SESSION['user_id'], null, $title, $desc, $price, $safeName, null);
                $_SESSION['flash'] = 'Product uploaded';
                header('Location: /seller/dashboard'); exit;
            }
            $_SESSION['flash'] = 'Upload failed';
        }
        echo $this->view('product/upload');
    }
}

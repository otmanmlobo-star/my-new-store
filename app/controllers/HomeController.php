<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $productModel = new Product($this->db);
        $featured = $productModel->getFeatured(6);
        $latest = $productModel->getLatest(8);
        echo $this->view('home', ['featured' => $featured, 'latest' => $latest]);
    }
}

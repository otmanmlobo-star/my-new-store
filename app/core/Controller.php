<?php
namespace App\Core;

class Controller
{
    protected $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    protected function view($name, $params = [])
    {
        extract($params);
        ob_start();
        include __DIR__.'/../views/'.$name.'.php';
        $content = ob_get_clean();
        include __DIR__.'/../views/layouts/main.php';
        return '';
    }
}

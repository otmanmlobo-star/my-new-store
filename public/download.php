<?php
// download handler: checks permissions and records download
require_once __DIR__.'/../app/init.php';
$db = new App\Core\Database($config['db']);
$pdo = $db->pdo();
$id = intval($_GET['id'] ?? 0);
if(!$id){ http_response_code(400); exit('Invalid'); }
$stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$stmt->execute([':id'=>$id]);
$p = $stmt->fetch();
if(!$p){ http_response_code(404); exit('Not found'); }
$path = __DIR__.'/'.($p['file_path'] ?: '');
if(!$p['file_path'] || !file_exists($path)){ http_response_code(404); exit('File missing'); }
// increment counter
$pdo->prepare('UPDATE products SET downloads = downloads + 1 WHERE id = :id')->execute([':id'=>$id]);
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename($p['file_path']).'"');
readfile($path);
exit;

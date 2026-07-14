<?php
// Stripe webhook receiver (demo). In production, verify signatures.
require_once __DIR__.'/../app/init.php';
$db = new App\Core\Database($config['db']);
$pdo = $db->pdo();
$payload = @file_get_contents('php://input');
$event = json_decode($payload, true);
// For demo we accept any event and log it
file_put_contents(__DIR__.'/../storage/stripe_events.log', date('c')."\n".($payload?:'')."\n---\n", FILE_APPEND);
http_response_code(200);
echo json_encode(['received'=>true]);

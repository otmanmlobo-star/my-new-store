<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Mailer;

class CheckoutController extends Controller
{
    public function cart()
    {
        $cart = $_SESSION['cart'] ?? [];
        echo $this->view('checkout/cart', ['cart' => $cart, 'csrf' => Csrf::token()]);
    }

    public function checkout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::check($_POST['_csrf'] ?? '')) {
                $_SESSION['flash'] = 'Invalid CSRF token';
                header('Location: /cart'); exit;
            }
            $cart = $_SESSION['cart'] ?? [];
            if (empty($cart)) { $_SESSION['flash'] = 'Cart is empty'; header('Location:/cart'); exit; }

            $user_id = $_SESSION['user_id'] ?? null;
            // create order
            $pdo = $this->db->pdo();
            $total = 0;
            foreach ($cart as $item) { $total += $item['price'] * $item['qty']; }
            $stmt = $pdo->prepare('INSERT INTO orders (user_id,total,status,payment_method) VALUES (:u,:t,:s,:pm)');
            $stmt->execute([':u'=>$user_id ?: 0, ':t'=>$total, ':s'=>'pending', ':pm'=>'stripe']);
            $order_id = $pdo->lastInsertId();
            $insertItem = $pdo->prepare('INSERT INTO order_items (order_id,product_id,price,qty) VALUES (:o,:p,:pr,:q)');
            foreach ($cart as $item) {
                $insertItem->execute([':o'=>$order_id,':p'=>$item['id'],':pr'=>$item['price'],':q'=>$item['qty']]);
            }

            // Simulate Stripe payment (in sandbox we accept any token)
            $stripeToken = $_POST['stripeToken'] ?? null;
            $paid = $stripeToken ? 1 : 0; // naive for demo
            if ($paid) {
                $pdo->prepare('UPDATE orders SET status = :s WHERE id = :id')->execute([':s'=>'paid', ':id'=>$order_id]);
                // record payment
                $pdo->prepare('INSERT INTO payments (order_id,provider,amount,status,created_at) VALUES (:o,:p,:a,:s,NOW())')
                    ->execute([':o'=>$order_id,':p'=>'stripe',':a'=>$total,':s'=>'paid']);

                // send invoice email (simulated)
                $mailer = new Mailer();
                $body = "Thank you for your purchase. Order #: $order_id - Total: $".number_format($total,2);
                $mailer->send($_SESSION['user_email'] ?? 'guest@example.com', 'Your Invoice #'.$order_id, $body);

                // clear cart
                unset($_SESSION['cart']);
                header('Location: /invoice/'.$order_id); exit;
            }

            $_SESSION['flash'] = 'Payment failed (demo)';
            header('Location: /cart'); exit;
        }
        header('Location: /cart'); exit;
    }

    public function invoice($id)
    {
        $pdo = $this->db->pdo();
        $stmt = $pdo->prepare('SELECT * FROM orders WHERE id = :id');
        $stmt->execute([':id'=>$id]);
        $order = $stmt->fetch();
        if (!$order) { http_response_code(404); echo $this->view('errors/404'); return; }
        $items = $pdo->prepare('SELECT oi.*, p.title FROM order_items oi JOIN products p ON oi.product_id=p.id WHERE oi.order_id = :o');
        $items->execute([':o'=>$id]);
        $rows = $items->fetchAll();
        echo $this->view('checkout/invoice', ['order'=>$order, 'items'=>$rows]);
    }
}

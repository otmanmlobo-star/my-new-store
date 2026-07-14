<div class="row">
  <div class="col-md-8">
    <h2>Your Cart</h2>
    <?php if(empty($cart)): ?>
      <p>Your cart is empty.</p>
    <?php else: ?>
      <table class="table">
        <thead><tr><th>Product</th><th>Qty</th><th>Price</th></tr></thead>
        <tbody>
        <?php $total=0; foreach($cart as $c): $total += $c['price']*$c['qty']; ?>
          <tr>
            <td><?php echo htmlspecialchars($c['title']); ?></td>
            <td><?php echo $c['qty']; ?></td>
            <td>$<?php echo number_format($c['price'],2); ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <p><strong>Total: $<?php echo number_format($total,2); ?></strong></p>
      <form method="post" action="/checkout">
        <input type="hidden" name="_csrf" value="<?php echo htmlspecialchars($csrf); ?>">
        <input type="hidden" name="stripeToken" value="tok_visa_demo">
        <button class="btn btn-success">Pay with Stripe (demo)</button>
      </form>
    <?php endif; ?>
  </div>
</div>

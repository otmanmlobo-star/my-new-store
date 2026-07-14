<div class="row">
  <div class="col-md-8">
    <h2>Invoice #<?php echo $order['id']; ?></h2>
    <p>Status: <?php echo htmlspecialchars($order['status']); ?></p>
    <table class="table">
      <thead><tr><th>Product</th><th>Qty</th><th>Price</th></tr></thead>
      <tbody>
      <?php $sum=0; foreach($items as $it): $sum += $it['price']*$it['qty']; ?>
        <tr>
          <td><?php echo htmlspecialchars($it['title']); ?></td>
          <td><?php echo $it['qty']; ?></td>
          <td>$<?php echo number_format($it['price'],2); ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <p><strong>Total: $<?php echo number_format($sum,2); ?></strong></p>
  </div>
</div>

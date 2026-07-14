<h3>User Profile</h3>
<p>Name: <?php echo htmlspecialchars($user['name']); ?></p>
<p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
<h5>Orders</h5>
<table class="table">
  <thead><tr><th>Order</th><th>Total</th><th>Status</th><th>Date</th></tr></thead>
  <tbody>
  <?php foreach($orders as $o): ?>
    <tr>
      <td>#<?php echo $o['id']; ?></td>
      <td>$<?php echo number_format($o['total'],2); ?></td>
      <td><?php echo htmlspecialchars($o['status']); ?></td>
      <td><?php echo $o['created_at']; ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

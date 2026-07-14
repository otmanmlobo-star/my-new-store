<h3>Seller Dashboard</h3>
<p>Welcome, <?php echo htmlspecialchars($user['name']); ?></p>
<a href="/seller/upload" class="btn btn-primary mb-3">Upload Product</a>
<h5>Your Products</h5>
<table class="table">
  <thead><tr><th>Title</th><th>Price</th><th>Downloads</th></tr></thead>
  <tbody>
  <?php foreach($products as $p): ?>
    <tr>
      <td><?php echo htmlspecialchars($p['title']); ?></td>
      <td>$<?php echo number_format($p['price'],2); ?></td>
      <td><?php echo $p['downloads']; ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<div class="row">
  <div class="col-md-8">
    <h2><?php echo htmlspecialchars($product['title']); ?></h2>
    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
    <p><strong>Price: </strong>$<?php echo number_format($product['price'],2); ?></p>
    <a class="btn btn-success" href="/download.php?id=<?php echo $product['id']; ?>">Download</a>
  </div>
  <div class="col-md-4">
    <h5>Seller</h5>
    <p><?php echo htmlspecialchars($product['seller_name']); ?></p>
  </div>
</div>

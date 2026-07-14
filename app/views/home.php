<div class="jumbotron text-center py-5">
  <h1>Welcome to ShadowMarket</h1>
  <p class="lead">A modern digital marketplace</p>
</div>

<h3>Featured</h3>
<div class="row">
<?php foreach($featured as $p): ?>
  <div class="col-md-4">
    <div class="card mb-3">
      <img src="/<?php echo $p['thumbnail'] ?: 'assets/img/placeholder.png' ?>" class="card-img-top" alt="">
      <div class="card-body">
        <h5 class="card-title"><?php echo htmlspecialchars($p['title']); ?></h5>
        <p class="card-text">$<?php echo number_format($p['price'],2); ?></p>
        <a href="/product/<?php echo $p['id']; ?>" class="btn btn-primary">View</a>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>

<h3>Latest</h3>
<div class="row">
<?php foreach($latest as $p): ?>
  <div class="col-md-3">
    <div class="card mb-3">
      <div class="card-body">
        <h6 class="card-title"><?php echo htmlspecialchars($p['title']); ?></h6>
        <p class="card-text">$<?php echo number_format($p['price'],2); ?></p>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>

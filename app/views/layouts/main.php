<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>ShadowMarket</title>
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="/">ShadowMarket</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <?php if(isset($_SESSION['user_id'])): ?>
          <li class="nav-item"><a class="nav-link" href="/logout">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
  <?php if(!empty($_SESSION['flash'])): ?>
    <div class="alert alert-info"><?php echo $_SESSION['flash']; unset($_SESSION['flash']); ?></div>
  <?php endif; ?>
  <?php echo $content ?? ''; ?>
</div>
<script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>

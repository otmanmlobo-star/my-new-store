<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>ShadowMarket - Admin</title>
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/css/admin.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="d-flex" id="admin-root">
  <nav class="bg-dark sidebar">
    <div class="p-3 text-white">
      <h4>ShadowMarket</h4>
    </div>
    <ul class="nav flex-column p-2">
      <li class="nav-item"><a class="nav-link text-white" href="/admin">Dashboard</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="/admin/products">Products</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="/admin/users">Users</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="/admin/orders">Orders</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="/logout">Logout</a></li>
    </ul>
  </nav>
  <main class="flex-grow-1 p-4">
    <?php echo $content ?? ''; ?>
  </main>
</div>
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/admin.js"></script>
</body>
</html>

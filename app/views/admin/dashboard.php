<div class="container-fluid">
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card p-3">
        <h5>Users</h5>
        <h2><?php echo $users; ?></h2>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card p-3">
        <h5>Products</h5>
        <h2><?php echo $products; ?></h2>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card p-3">
        <h5>Orders</h5>
        <h2><?php echo $orders; ?></h2>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-8">
      <div class="card p-3">
        <h5>Sales (last 7 days)</h5>
        <canvas id="salesChart" data-sales='<?php echo json_encode($sales); ?>'></canvas>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card p-3">
        <h5>Recent Activity</h5>
        <p>No recent activity demo.</p>
      </div>
    </div>
  </div>
</div>

<script>
  // inline script to render chart
  (function(){
    const canvas = document.getElementById('salesChart');
    if(!canvas) return;
    const sales = JSON.parse(canvas.getAttribute('data-sales')) || [];
    const labels = sales.map(s=>s.day);
    const data = sales.map(s=>parseInt(s.orders,10));
    new Chart(canvas.getContext('2d'), {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{ label: 'Orders', data: data, borderColor: '#007bff', tension: 0.3 }]
      },
      options: { responsive: true }
    });
  })();
</script>

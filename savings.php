<?php
  session_start();
  include 'config/connection.php';
  $id = $_SESSION['id'];
  
  // Retrieve total earning
  $earning_sql = "SELECT SUM(amount) AS total_earning FROM earning WHERE userId='$id'";
  $earning_result = mysqli_query($conn, $earning_sql);
  $earning_row = mysqli_fetch_assoc($earning_result);
  $total_earning = $earning_row['total_earning'] ?? 0;
  
  // Retrieve total expense
  $expense_sql = "SELECT SUM(ramount) AS total_expense FROM expense WHERE userId='$id'";
  $expense_result = mysqli_query($conn, $expense_sql);
  $expense_row = mysqli_fetch_assoc($expense_result);
  $total_expense = $expense_row['total_expense'] ?? 0;

  $savings = $total_earning - $total_expense;

// Check if savings are less than 5% of total earnings
$savings_percentage = ($savings / $total_earning) * 100;
if ($savings_percentage < 5) {
  $message = '<div style="text-align: right; font-size: 39px; color:red;">Savings Status:Bad!  Not enough savings,
Reduce your expenditure. </div>';
} else if($savings_percentage>=5 && $savings_percentage<15) {
  $message = '<div style="text-align: right; font-size: 39px; color:orange;">Savings Status:Not Bad! Savings can be used for 
Emergency funds,
Debt Repayment,
Retirement savings.
  </div>'; 
}
 else if($savings_percentage>=15 && $savings_percentage<30) {
  $message = '<div style="text-align: right; font-size: 39px; color:red;">Savings Status:Good! Savings can be used for 
  Investment in low-risk domains like mutual funds, stocks
Education savings,
Short term goals- car,
 house renovation,
 vacation.</div>';
 }
 else{
	  $message = '<div style="text-align: right; font-size: 39px; color:green;"><b>Savings Status:VGood! Savings can be used for 
	  Property,
       FD.</b>
	    </div>'; 
}
	 



?>
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>personal finance management system| Savings </title>
 
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script></head>
<body class="bg-light">
<
  <!-- Navbar -->
  <?php include 'include/navbar.php'; ?>
  <!-- Main Content -->
  <div class="container mt-3">
    <div class="row">
      <div class="col-md-12">
        <h4>Total earning: <?php echo $total_earning; ?>Rs. </h4>
        <h4>Total expense: <?php echo $total_expense; ?> Rs.</h4>
        <h4>Total Savings: <?php echo $savings; ?> Rs.</h4>
        <?php if (!empty($message)): ?>
          <p><?php echo $message; ?></p>
        <?php endif; ?>
        <!-- Bar Graph -->
        <canvas id="savingsChart" width="400" height="200"></canvas>
      </div>
    </div>
  </div>
  
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- Chart Script -->
  <script>
    $(function () {
      // Your existing PHP code to retrieve earnings, expenses, and savings
      
      // Retrieve the canvas element
      var ctx = document.getElementById('savingsChart').getContext('2d');
      
      // Create the chart
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Total Earnings', 'Total Expenses', 'Total Savings'],
          datasets: [{
            label: 'Amount (Rs.)',
			
            data: [<?php echo $total_earning; ?>, <?php echo $total_expense; ?>, <?php echo $savings; ?>],
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    });
  </script>
</body>
</html>
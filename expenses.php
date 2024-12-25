<?php
session_start();
include 'config/connection.php';
$sql = "SELECT * FROM expense";
$qry = mysqli_query($conn, $sql);

// Initialize arrays for chart data and table data
$labels = [];
$data = [];
$table_data = [];

// Fetch data for chart and table
while ($row = mysqli_fetch_array($qry)) {
    $labels[] = $row['item'];
    $data[] = $row['ramount'];
    $table_data[] = $row; // Store row data for table
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Personal Finance Management System | Expenses </title>
 
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      background-image: url('nd.png');
    }
  </style>
</head>
<body class="bg-light">
    <!-- Navbar -->
    <?php include 'include/navbar.php'; ?>  
<div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <a href="AddExpense.php" class="btn btn-danger float-right "><i class="fa fa-plus"></i> Add Expense </a>
            </div>
            <hr>
            <br>
            <div class="col-md-12 mt-2">
                <?php
                  if (isset($_GET["deleted"])){
                ?>
                <p class="btn btn-success btn-block disabled mx-auto text-light " style="margin-left:20px;">Successfully Deleted !</p>
                <?php     
                  }
                ?>	

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6">
                <!-- Pie chart for expenses -->
                <div class="card" style="opacity:96%;">
                    <div class="card-header bg-navy">
                        <h3 class="card-title">Expenses Pie Chart</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="expenseChart" style="width: 400px; height: 400px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card" style="opacity:96%;">
                    <div class="card-header bg-navy">
                        <h3 class="card-title">Daily Expenses Table</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <?php
                            if (empty($table_data)){
                        ?>
                            <h4 class="text-center text-danger"> No Expenses Available ! </h4>
                        <?php
                            } else {
                        ?>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Date</th>
                                        <th>Item</th>
                                        <th>Amount spent</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $i = 1;
                                    foreach ($table_data as $row) {
                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row['date']; ?></td>
                                        <td><?php echo $row['item']; ?></td>
                                        <td><?php echo $row['ramount']; ?> Rs.</td>
                                        <td>
                                            <div class="text-center">
                                                <a class="bg-navy p-1" href="EditExpense.php?id=<?php echo $row['id']; ?>"><i class="fa fa-pen"></i></a>
                                                <a class="bg-danger p-1" href="config/DeleteExpense.php?id=<?php echo $row['id']; ?>"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php 
                                        $i++;
                                    }
                                ?>
                                </tbody>
                            </table>
                        <?php 
                            }
                        ?>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    
    
    <!-- Pie chart script -->
    <script>
        var ctx = document.getElementById('expenseChart').getContext('2d');
        var expenseChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Expenses',
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: [
                        '#ff7f0e',
                        '#2ca02c',
                        '#1f77b4',
                        '#d62728',
                        '#9467bd',
                        '#8c564b',
                        '#e377c2',
                        '#7f7f7f',
                        '#bcbd22',
                        '#17becf'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'right'
                }
            }
        });
    </script>

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables & Plugins -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
      $(function () {
        $("#example1").DataTable({
          "responsive": true, "lengthChange": false, "autoWidth": false,
          "buttons": ["pdf"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0) ');
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        });
      });
    </script>
</body>
</html>
<?php
  session_start();
  $id=$_SESSION['id'];
  include 'config/connection.php';
  $sql="SELECT * FROM earning WHERE userId='$id'";
  $qry=mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>personal finance management system | Earnings </title>

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
</head>
<style>
  body {
    background-image: url('nd.png');
  }
</style>
<body class="bg-light">
  <!-- Navbar -->
  <?php include 'include/navbar.php'; ?>  

  <!-- login form -->
  <div class="container mt-3">
    <div class="row">
      <div class="col-md-12">
        <a href="AddEarning.php" class="btn btn-danger float-right"><i class="fa fa-plus"></i> Add Earning</a>
      </div>
      <hr>
      <br>

      <div class="col-md-6 mt-2">
        <canvas id="earningChart"></canvas>
      </div>

      <div class="col-md-6 mt-2">
        <?php
        if (isset($_GET["deleted"])){
          ?>
          <p class="btn btn-success btn-block disabled mx-auto text-light " style="margin-left:20px;">Successfully Deleted !</p>
          <?php     
        }
        ?>
        <div class="card" style="opacity:94%;">
          <div class="card-header bg-navy">
            <h3 class="card-title">Daily Earnings Table</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <?php
            if (mysqli_num_rows($qry) == 0){
              ?>
              <h4 class="text-center text-danger"> No Earnings Available ! </h4>
              <?php
            }
            else{
              ?>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>SN</th>
                    <th>Date</th>
                    <th>Source</th>
                    <th>Earned Amount</th>
                    <th>Total Earning</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  for ($i=1; $i<=mysqli_num_rows($qry); $i++){
                    $row = mysqli_fetch_array($qry);

                    $sql1="SELECT SUM(amount) FROM earning WHERE userId='$id' ";
                    $qry1=mysqli_query($conn,$sql1);
                    $res=mysqli_fetch_array($qry1);
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['source']; ?></td>
                    <td><?php echo $row['amount']; ?> Rs.</td>
                    <td><?php echo $row['total']; ?> Rs.</td>
                    <td>
                      <div class="text-center">
                        <a class="bg-navy p-1" href="EditEarning.php?id=<?php echo $row['id'];?>"><i class="fa fa-pen "></i></a>
                        <a class="bg-danger p-1" href="config/DeleteEarning.php?id=<?php echo $row['id'];?>"><i class="fa fa-trash "></i></a>
                      </div>
                    </td>
                  </tr>
                  <?php 
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
  

  <script>
    // PHP data to JavaScript
    var earningsData = [
      <?php
      $qry = mysqli_query($conn, $sql);
      while ($row = mysqli_fetch_array($qry)) {
        echo "{ label: '{$row['source']}', value: {$row['amount']} },";
      }
      ?>
    ];

    // Chart.js Pie Chart
    var ctx = document.getElementById('earningChart').getContext('2d');
    var myPieChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: earningsData.map(data => data.label),
        datasets: [{
          data: earningsData.map(data => data.value),
          backgroundColor: [
            'rgba(2, 97, 13, 0.7)',
            'rgba(54, 16, 23, 0.7)',
            'rgba(25, 20, 86, 0.7)',
            'rgba(75, 19, 19, 0.7)',
            'rgba(153, 10, 25, 0.7)',
            'rgba(25, 15, 64, 0.7)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true
      }
    });
  </script>
  <!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
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
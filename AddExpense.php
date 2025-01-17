<?php
  session_start();
  include 'config/connection.php';

  $id=$_SESSION['id'];
  $sql="SELECT * FROM user WHERE id='$id' ";
  $qry=mysqli_query($conn,$sql);
  $row=mysqli_fetch_array($qry);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>personal finance management system | Add Expense </title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>
<style>
body {
  background-image: url('back.jpg');

}
</style>
<body class="bg-light">
    <!-- Navbar -->
    <?php include 'include/navbar.php'; ?>


<div class="container mt-3">
    <div class="row">
        <div class="col-md-12 mx-auto">
    
            <a href="expenses.php" class="btn btn-danger float-right "><i class="fa fa-bars"></i> View Expenses  </a>
        </div>
        <!-- Processing form -->

<?php

if(isset($_POST['add'])) {
  $date=$_POST['date'];
  $item=$_POST['item'];
  $bamount=$_POST['bamount'];
  $ramount=$_POST['ramount'];
  $uid=$row['id'];
  $sql1="SELECT SUM(ramount) FROM expense WHERE `userId`='$uid' ";
  $qry1=mysqli_query($conn,$sql1);
  $res=mysqli_fetch_array($qry1);
  $total=$res['SUM(ramount)']+$ramount;

  $sql="INSERT INTO `expense` (`userId`,`date`,`item`,`bamount`,`ramount`,`total`) VALUES ('$id','$date','$item','$bamount','$ramount','$total')";
  $qry=mysqli_query($conn,$sql);

  if( !$qry){
    echo 'insertion error';
  }
  else{
    ?>
          <div class="col-md-12">
            <a class="btn btn-success btn-block disabled  text-left">Successfully added ! <i class="fa fa-times float-right"></i></a>
        
          </div>
      <?php  }
  }

?>
        <div class="col-md-12 mx-auto mt-2">
            <div class="card card-navy" style="opacity:94%;">
                <div class="card-header">
                  <h3 class="card-title text-light"><i class="fa fa-plus"></i> Add Expense </h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="quickForm" action="" method="post">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Date</label>
                      <input type="date" name="date" class="form-control" id="exampleInputEmail1" >
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Item</label>
                        <input type="text" name="item" class="form-control" id="exampleInputEmail1" placeholder="Enter Item">
                    </div>
                    
                    

                    <div class="form-group">
                        <label for="exampleInputEmail1">Amount Spent</label>
                        <input type="text" name="ramount" class="form-control" id="exampleInputEmail1" placeholder="Enter Actual Amount">
                    </div>
                 
               
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="submit" name="add" class="btn btn-outline-danger ">Add Expense</button>
                  </div>
                </form>
              </div>
              <!-- /.card -->
        </div>
    </div>
</div>


<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
</body>
</html>


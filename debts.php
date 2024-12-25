<?php
session_start();
include 'config/connection.php';
$sql = "SELECT * FROM debt";
$qry = mysqli_query($conn, $sql);

// Initialize arrays
$labels = [];
$data = [];

// Check if there are any rows returned by the query
if (mysqli_num_rows($qry) > 0) {
    // Fetch data for pie chart
    while ($row = mysqli_fetch_array($qry)) {
        $labels[] = $row['owner'];
        $data[] = $row['damount'] - $row['pamount']; // Remaining debt amount
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Personal Finance Management System| Debts</title>

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
            <a href="AddDebt.php" class="btn btn-danger float-right"><i class="fa fa-plus"></i> Add Debt</a>
        </div>
        <hr>
        <br>
        <div class="col-md-12 mt-2">
            <?php
            if (isset($_GET["deleted"])) {
                ?>
                <p class="btn btn-success btn-block disabled mx-auto text-light " style="margin-left:20px;">Successfully Deleted !</p>
            <?php
            }
            ?>
            <div class="card" style="opacity:96%;">
                <div class="card-header bg-navy">
                    <h3 class="card-title">Daily Debt Table</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <?php
                    if (empty($labels)) {
                        ?>
                        <h4 class="text-center text-danger">No Debt Available!</h4>
                        <?php
                    } else {
                        ?>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Owner</th>
                                <th>Reason</th>
                                <th>Debt Amount</th>
                                <th>Paid Amount</th>
                                <th>Remaining</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($qry as $i => $row) {
                                ?>
                                <tr>
                                    <td><?php echo $i + 1; ?></td>
                                    <td><?php echo $row['owner']; ?></td>
                                    <td><?php echo $row['reason']; ?></td>
                                    <td><?php echo $row['damount']; ?> Rs.</td>
                                    <td><?php echo $row['pamount']; ?> Rs.</td>
                                    <td><?php echo $row['damount'] - $row['pamount']; ?> Rs.</td>
                                    <td>
                                        <div class="text-center">
                                            <a class="bg-navy p-1"
                                               href="EditDebt.php?id=<?php echo $row['id']; ?>"><i
                                                        class="fa fa-pen "></i></a>
                                            <a class="bg-danger p-1"
                                               href="config/DeleteDebt.php?id=<?php echo $row['id']; ?>"><i
                                                        class="fa fa-trash "></i></a>
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

    <!-- Pie chart for debts -->
    <div class="container mt-3">
        <canvas id="debtChart" style="width: 400px; height: 400px;"></canvas>
    </div>

    <script>
        // Create pie chart for debts
        var ctx = document.getElementById('debtChart').getContext('2d');
        var debtChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Remaining Debt',
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: [
                        '#ff7f0e',
                        '#2ca02c',
                        '#1f77b4',
                        '#d62728'
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

</div>

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
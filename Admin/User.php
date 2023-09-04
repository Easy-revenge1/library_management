<?php
include_once("../db.php");
include_once("../Include/Header.php");
include_once("../Include/TopNavbar.php");
include_once("../Include/Sidebar.php");

$query = "SELECT * FROM `user`";
$SQL   = mysqli_query($conn,$query);

?>

<!DOCTYPE html>
<html>
<head>
  <title>DIGITAL LIBRARY</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="Assets/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="Assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="Assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="Assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="Assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">User Table</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">

              <div class="card">
                <div class="card-header bg-gradient-primary">
                  <h3 class="card-title">User List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="Userlist" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Contact</th>
                      <th>Status</th>
                      <th>Manage</th>
                      </tr>
                    </thead>
                    <tbody id="user-table-body">
                    <?php while ($row = mysqli_fetch_array($SQL)) { ?>
                      <tr class="tdhv">
                        <td><?= $row["user_id"] ?></td>
                        <td><?= $row["user_name"] ?></td>
                        <td><?= $row["user_email"] ?></td>
                        <td><?= $row["user_contact"] ?></td>
                        <td><?= $row["user_status"] ?></td>
                        <td>
                        <a class="btn btn-primary btn-sm" href="UserMaintenance.php?id=<?= $row['user_id'] ?>">
                              <i class="fas fa-edit">
                              </i>
                              Manage
                          </a>
                        </td>
                      </tr>
                    <?php } ?>
                    </tbody>
                    <tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
  </div>
  <!-- ./wrapper -->

</body>
</html>

<script src="Assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="Assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="Assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="Assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="Assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="Assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="Assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="Assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="Assets/plugins/jszip/jszip.min.js"></script>
  <script src="Assets/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="Assets/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="Assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="Assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="Assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <!-- AdminLTE App -->
  <script src="Assets/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script>
    $(function() {
  $("#Userlist").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "buttons": [
      {
        extend: 'copy',
        text: 'Copy',
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'colvis',
        text: 'Column Visibility',
        columns: ':gt(0)' // Exclude the first column (checkbox column)
      }
    ]
  }).buttons().container().appendTo('#Userlist_wrapper .col-md-6:eq(0)');
});

  </script>
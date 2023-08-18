<?php
ob_start();
include_once("../db.php");
include_once("../Include/Header.php");
include_once("../Include/TopNavbar.php");
include_once("../Include/Sidebar.php");

// Check if the form is submitted and the "id" parameter is set
if(isset($_POST['submit']) && isset($_GET['id'])) {
  // Retrieve user input from the form
  $u_name = $_POST['user_name'];
  $u_email = $_POST['user_email'];
  $u_password = $_POST['user_password'];
  $u_contact = $_POST['user_contact'];
  $u_status = $_POST['user_status'];

  // Prepare the SQL query with placeholders
  $query = "UPDATE user SET user_name = ?, user_email = ?, user_password = ?, user_contact = ?, user_status = ? WHERE user_id = ?";

  // Create a prepared statement
  $stmt = mysqli_prepare($conn, $query);

  // Bind the parameters to the prepared statement
  mysqli_stmt_bind_param($stmt, "sssssi", $u_name, $u_email, $u_password, $u_contact, $u_status, $_GET['id']);

  // Execute the prepared statement
  if(mysqli_stmt_execute($stmt)) {
    // If the update is successful, redirect to the user.php page
    header('Location: User.php');
    exit();
  } else {
    // If the update fails, display an error message
    $error_message = "Update Failed: " . mysqli_stmt_error($stmt);
  }

  // Close the prepared statement
  mysqli_stmt_close($stmt);
}

// Retrieve the user data based on the "id" parameter
$qry = "SELECT * FROM user WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $qry);
mysqli_stmt_bind_param($stmt, "i", $_GET['id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_array($result);

// Close the prepared statement
mysqli_stmt_close($stmt);

ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="Assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="Assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="Assets/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="Assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="Assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="Assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="Assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="Assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="Assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <link rel="stylesheet" href="Assets/plugins/bs-stepper/css/bs-stepper.min.css">
  <link rel="stylesheet" href="Assets/plugins/dropzone/min/dropzone.min.css">
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
              <h1>Project Edit</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Project Edit</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">General</h3>
              </div>
              <form action="UserMaintenance.php?id=<?=$_GET['id']?>" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="inputName">Name</label>
                    <input type="text" id="inputName" name="user_name" class="form-control" value="<?=$row['user_name']?>">
                  </div>

                  <div class="form-group">
                    <label for="inputAuthor">Email :</label>
                    <input type="text" id="inputDescription" name="user_email" class="form-control" value="<?=$row['user_email']?>"></input>
                  </div>

                  <div class="form-group">
                    <label for="inputPassword">Password</label>
                    <input type="text" id="inputDescription" name="user_password" class="form-control" value="<?=$row['user_password']?>"></input>
                  </div>

                  <div class="form-group">
                  <label for="inputContact">Contact :</label>
                  <input type="text" id="inputDescription" name="user_contact" class="form-control" value="<?=$row['user_contact']?>"></input>
                  </div>

                  <div class="form-group">
                    <label class="details" for="">Status :</label>
                    <select class="form-control custom-select" name="user_status">
                      <option value="Online" <?php if ($row['user_status'] === 'Online') echo 'selected'; ?>>Online</option>
                      <option value="Blacklisted" <?php if ($row['user_status'] === 'Blacklisted') echo 'selected'; ?>>Blacklisted</option>
                    </select>
                  </div>
                </div>

                <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <a href="User.php" class="btn btn-secondary">Cancel</a>
            <input type="submit" name="submit" value="Save Changes" class="btn btn-success float-right">
          </div>
        </div>
        </form>
      </section>
      <!-- /.content -->
    </div>
  </div>
  <!-- ./wrapper -->

</body>
</html>
  <!-- jQuery -->
<script src="Assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="Assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="Assets/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="Assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="Assets/plugins/moment/moment.min.js"></script>
<script src="Assets/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="Assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="Assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="Assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="Assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="Assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="Assets/plugins/dropzone/min/dropzone.min.js"></script>
<!-- AdminLTE App -->
<script src="Assets/dist/js/adminlte.min.js"></script>

<script src="Assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

  <script>
    function togglePicSize() {
      var pic = document.getElementById('pic');
      pic.classList.toggle('clicked');
    }
      //Date picker
  $('#book_public_date').datetimepicker({
    format: 'L'
  });
  $(function () {
  bsCustomFileInput.init();
});
  </script>

  
<?php
include_once("../Include/Footer.php");
?>
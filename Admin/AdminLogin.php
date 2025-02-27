<?php
include_once('../db.php');

if (isset($_POST['submit'])) {
  if (!empty($_POST['admin_name']) && !empty($_POST['admin_pass'])) {
    $admin_name = $_POST['admin_name'];
    $admin_pass = $_POST['admin_pass'];

    $query = "SELECT * FROM `admin` WHERE admin_name=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $admin_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);

    if (mysqli_num_rows($result) == 1) {

      if ($admin_pass == $row['admin_pass']) {
        $_SESSION['admin_name'] = $admin_name;
        $_SESSION['admin_pass'] = $admin_pass;
        $_SESSION["id"] = $row[0];

        $userId = $_SESSION["id"];
        $languageQuery = "SELECT language FROM `admin` WHERE admin_id = ?";
        $languageStmt = mysqli_prepare($conn, $languageQuery);
        mysqli_stmt_bind_param($languageStmt, "i", $userId);
        mysqli_stmt_execute($languageStmt);
        $languageResult = mysqli_stmt_get_result($languageStmt);

        if ($languageRow = mysqli_fetch_assoc($languageResult)) {
          $_SESSION['lang'] = $languageRow['language'];
        }

        mysqli_stmt_close($languageStmt);

        include('../Language/' . $_SESSION['lang'] . '/lang.' . $_SESSION['lang'] . '.php');

        header('location: AdminIndex.php');
        exit();
      } else {
        echo "<script>alert('Wrong Password, Please try again');</script>";
      }
    } else {
      echo "<script>alert('Wrong Username or Password, Please try again');</script>";
    }
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="Assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="Assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="Assets/dist/css/adminlte.min.css">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel Login</title>
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <h3>Admin Panel Login</h3>
      </div>
      <div class="card-body">

        <form action="AdminLogin.php" method="post">
          <div class="input-group mb-3">
            <input name="admin_name" type="text" class="form-control" placeholder="Name" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name='admin_pass' placeholder="Code" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>

</html>

<script src="Assets/plugins/jquery/jquery.min.js"></script>
<script src="Assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="Assets/dist/js/adminlte.min.js"></script>
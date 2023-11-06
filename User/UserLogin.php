<?php
include_once('../db.php');

if (isset($_POST['submit'])) {
  if (!empty($_POST['user_name']) && !empty($_POST['user_pass'])) {
    $user_name = $_POST['user_name'];
    $user_pass = $_POST['user_pass'];

    $query = "SELECT * FROM `user` WHERE `user_name`=?";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $user_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {

      $row = mysqli_fetch_assoc($result);

      if (password_verify($user_pass, $row['user_password'])) {
        $_SESSION['id'] = $row['user_id'];
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_name'] = $row['user_name'];
        $_SESSION['user_email'] = $row['user_email'];
        $_SESSION['user_contact'] = $row['user_contact'];

        header("Location: UserIndex.php");
        exit();
      } else {
        echo "<script>alert('Wrong Password, Please try again');</script>";
      }
    } else {
      echo "<script>alert('User does not exist, Please try again');</script>";
    }

    mysqli_stmt_close($stmt);
  } else {
    echo "<script>alert('Please Insert Username and Password');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/reset.css">
  <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/site.css">

  <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/container.css">
  <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/grid.css">
  <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/header.css">
  <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/image.css">
  <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/menu.css">

  <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/divider.css">
  <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/segment.css">
  <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/form.css">
  <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/input.css">
  <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/button.css">
  <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/list.css">
  <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/message.css">
  <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/icon.css">
  <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/semantic.min.css">
  <!-- <link rel="stylesheet" type="text/css" href="Main.css"> -->
  <!-- <link rel="stylesheet" href="Utility.css"> -->
  <title>Digital Library</title>
</head>

<body>
  <div class="ui middle aligned center aligned grid">
    <div class="column">
      <!-- <h2 class="ui teal image header">
        <img src="assets/images/logo.png" class="image">
 
      </h2> -->
      <div class="login-bg">

      </div>
      
      <form class="ui large form" action="UserLogin.php" method="POST">
        <div class="ui stacked segment" id="login-form">
          <div class="field">
            <div class="ui left icon input">
              <i class="user icon"></i>
              <input type="text" name="user_name" placeholder="Enter Your Username">
            </div>
          </div>
          <div class="field">
            <div class="ui left icon input">
              <i class="lock icon"></i>
              <input type='password' name='user_pass' placeholder="Enter Your Password">
            </div>
          </div>
          <a href="ForgotPassword.php">Forgot Password</a>
          <!-- <div class="ui fluid large teal submit button" name='submit' value='submit'>Login</div> -->
          <button type='submit' name='submit' value='submit' class="ui inverted secondary button" id="login-button">Login</button>
        </div>

        <div class="ui error message"></div>

      </form>

      <div class="ui message">
        New to us? <a href="SignUp.php">Sign Up</a> |
      </div>
    </div>
  </div>


</body>

</html>

<style type="text/css">
  body {
    background-color: #eeeeee;
  }

  body>.grid {
    height: 100%;
  }

  .image {
    margin-top: -100px;
  }

  .column {
    max-width: 450px;
  }
  #login-form{
    height:400px;
  }
  #login-form a{
    float:right;
  }
  #login-button{
    width:100%;
    /* position: absolute; */
    margin:210px 0px;
    transition:0.4s;
  }
</style>

<script src="../Fomantic-ui/dist/semantic.min.js"></script>
<!-- <script src="assets/library/jquery.min.js"></script> -->
<script src="../Fomantic-ui/dist/components/form.js"></script>
<script src="../Formantic-ui/dist/components/transition.js"></script>
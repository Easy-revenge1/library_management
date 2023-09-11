<?php 
include_once('db.php');

if(isset($_POST['submit'])){
  if(!empty($_POST['user_name']) && !empty($_POST['user_pass'])){
    $user_name=$_POST['user_name'];
    $user_pass=$_POST['user_pass'];

    echo $Query="SELECT * FROM `user` WHERE user_name='".$user_name."' AND user_password='".$user_pass."'";
    $result=mysqli_query($conn,$Query);
    $rows=mysqli_num_rows($result);
    $row=mysqli_fetch_array($result);
  
    if($rows==1){
      $_SESSION['user_name']=$user_name;
      $_SESSION['user_pass']=$user_pass;
      $_SESSION["id"]=$row[0];
      echo "<script>window.location.href='index_user.php';
           alert('Hi! $user_name, Welcome to DIGITAL Library');</script>";
    }else{      
      echo "<script>alert('Wrong Username or Password, Please try again :(');</script>";
    }
  }else{
    echo "<script>alert('Please Insert Username or Password ):');</script>";
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
    <link rel="stylesheet" type="text/css" href="Fomantic-ui/dist/components/reset.css">
    <link rel="stylesheet" type="text/css" href="Fomantic-ui/dist/components/site.css">

    <link rel="stylesheet" type="text/css" href="Fomantic-ui/dist/components/container.css">
    <link rel="stylesheet" type="text/css" href="Fomantic-ui/dist/components/grid.css">
    <link rel="stylesheet" type="text/css" href="Fomantic-ui/dist/components/header.css">
    <link rel="stylesheet" type="text/css" href="Fomantic-ui/dist/components/image.css">
    <link rel="stylesheet" type="text/css" href="Fomantic-ui/dist/components/menu.css">

    <link rel="stylesheet" type="text/css" href="Fomantic-ui/dist/components/divider.css">
    <link rel="stylesheet" type="text/css" href="Fomantic-ui/dist/components/segment.css">
    <link rel="stylesheet" type="text/css" href="Fomantic-ui/dist/components/form.css">
    <link rel="stylesheet" type="text/css" href="Fomantic-ui/dist/components/input.css">
    <link rel="stylesheet" type="text/css" href="Fomantic-ui/dist/components/button.css">
    <link rel="stylesheet" type="text/css" href="Fomantic-ui/dist/components/list.css">
    <link rel="stylesheet" type="text/css" href="Fomantic-ui/dist/components/message.css">
    <link rel="stylesheet" type="text/css" href="Fomantic-ui/dist/components/icon.css">
    <link rel="stylesheet" type="text/css" href="Fomantic-ui/dist/semantic.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="Main.css"> -->
    <!-- <link rel="stylesheet" href="Utility.css"> -->
    <title>Digital Library</title>
</head>
<body>
<!-- <div>
  <div class="ui grid padded">
    <div class="sixteen wide column">
      <div class="activate-box q-mt-lg">
        <div class="test">
          test
        </div>
      </div>
    </div>
  </div>
  <div>
  <form action="login_user.php" method="POST">
      <div>
       <p>LOGIN</p>
        <input type="text" name="user_name" placeholder="Enter Your Username">
        <input type='password' name='user_pass' placeholder="Enter Your Password">
         
          <a href="">Forget Password</a>
  
        <hr>
        <button type='submit' name='submit' value='submit'>DONE</button>
        <div>
         <span>Don't have account yet?</span>
         <span><a href="">Sign Up</a></span>
        </div>
      </div>
     </form>
  </div>
</div> -->

<div class="ui middle aligned center aligned grid">
  <div class="column">
    <h2 class="ui teal image header">
      <img src="assets/images/logo.png" class="image">
      <div class="content">
        Log-in to your account
      </div>
    </h2>
    <form class="ui large form">
      <div class="ui stacked segment">
        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="email" placeholder="E-mail address">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="password" placeholder="Password">
          </div>
        </div>
        <div class="ui fluid large teal submit button">Login</div>
      </div>

      <div class="ui error message"></div>

    </form>

    <div class="ui message">
      New to us? <a href="#">Sign Up</a>
    </div>
  </div>
</div>


</body>
</html>

<style type="text/css">
    body {
      background-color: #dadada;
    }
    body > .grid {
      height: 100%;
    }
    .image {
      margin-top: -100px;
    }
    .column {
      max-width: 450px;
    }
  </style>

<script src="Fomantic-ui/dist/semantic.min.js"></script>

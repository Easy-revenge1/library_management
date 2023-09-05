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
    <link rel="stylesheet" type="text/css" href="semantic/dist/semantic.min.css">
    <link rel="stylesheet" type="text/css" href="Main.css">
    <link rel="stylesheet" href="Utility.css">
    <title>Digital Library</title>
<style>
</style>
</head>
<body>
<div>
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
</div>
</body>
</html>


<script src="semantic/dist/semantic.min.js"></script>

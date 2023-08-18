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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>DIGITAL LIBRARY</title>
<style>
</style>
</head>
<body class="user-body">
<div class="user-login-box">
  <div class="user-logo">
   <div class="logo">
   
   </div>
  </div>
  <div class="user-login-input">
  <form action="login_user.php" method="POST">
      <div class="user-input-box">
       <p class="logintext">LOGIN</p>
        <input class="userinput" type="text" name="user_name" placeholder="Enter Your Username">
        <input class="userinput" type='password' name='user_pass' placeholder="Enter Your Password">
         
          <a href="" class="">Forget Password</a>
  
        <hr>
        <button type='submit' name='submit' value='submit' class='submit'>DONE</button>
        <div class="na_op-user">
         <span class="noacc" >Don't have account yet?</span>
         <span><a class="signup" href="">Sign Up</a></span>
        </div>
      </div>
     </form>
  </div>
</div>
</body>
</html>
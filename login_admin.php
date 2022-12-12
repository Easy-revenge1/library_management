<?php 
include_once('db.php');

if(isset($_POST['submit'])){
  if(!empty($_POST['admin_name']) && !empty($_POST['admin_pass'])){
    $admin_name=$_POST['admin_name'];
    $admin_pass=$_POST['admin_pass'];

    $Query="SELECT * FROM `admin` WHERE admin_name='".$admin_name."' AND admin_pass='".$admin_pass."'";
    $result=mysqli_query($conn,$Query);
    $rows=mysqli_num_rows($result);
    $row=mysqli_fetch_array($result);
  
    if($rows==1){
      $_SESSION['admin_name']=$admin_name;
      $_SESSION['admin_pass']=$admin_pass;
      $_SESSION["id"]=$row[0];
      echo "<script>window.location.href='index_admin.php';
           alert('Hi! $admin_name, Welcome to DIGITAL Library');</script>";
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
    <title>DIGITAL LIBRARY</title>
</head>
<style>
body {
    background-color:#262626;
    font-family: Arial, Helvetica, sans-serif;
}
.loginbox{
    background-color:#;
    height:500px;
    width:100%;
    max-width:100%;
    margin:auto;
    margin-top:80px;
    display:flex;
}
.logobox{
    font-family: system-ui;
    height:100%;
    width:625px;
    border-right:3px solid #4d4d4d;
}
.logo{
    margin-top:200px;
    margin-left:120px;
    transition:0.4s;
}
.logo1{
    color:#999;
    font-size:20px;
    letter-spacing: 1px;
    filter:opacity(100%);
    animation: logo1A 1.5s;
}
@keyframes logo1A{
    0%{filter:opacity(0%);}
    100%{filter:opacity(100%);}
}
.logo1_2{
    color:#999;
    font-size:20px;
    letter-spacing: 1px;
    filter:opacity(0%);
    animation: logo12A 1.5s;
    animation-delay: 1s;
    animation-fill-mode: forwards;
}
@keyframes logo12A{
    0%{filter:opacity(0%);}
    100%{filter:opacity(100%);}
}
.logo2{
    color:#fff;
    font-size:40px;
    letter-spacing: 3px;
    margin:0px;
    filter:opacity(0%);
    animation: logo2A 1.5s;
    animation-delay: 2s;
    animation-fill-mode: forwards;
}
@keyframes logo2A{
    0%{filter:opacity(0%);}
    100%{filter:opacity(100%);}
}
.mblogo{
  font-size:45px;
  color:#fff;
  display:none;
}
.mblogoT1{
  color:#fff;
  letter-spacing: 3px;
}
.mblogoT2{
  color:#999;
  letter-spacing: 3px;
}
.login{
    height:100%;
    width:625px;
}
.login_box {
    font-family: "arial",sans-serif;
    width: 80%;
    height: 100%;
    margin:auto;
    border-radius: 10px;
    transition: 0.4s;
}
.logintext{
    text-align:center; 
    font-size: 20px; 
    color:#fff;
    font-weight:normal;
    letter-spacing:1px;
}
.logintext2{
  text-align:center;
  font-size:20px;
  color:#fff;
  font-weight:normal;
  letter-spacing: 3px;
}
.login_box .left{
    width: 41%;
    height: %;
    padding: 25px 25px;
  
}
.login_box .right{
    width: 59%;
    height: 100%  
}
.left .top_link a {
    color: #452A5A
    font-weight: 400;
}
.left .top_link{
  height: 20px
}
.left .contact{
  display: flex;
    align-items: center;
    justify-content: center;
    align-self: center;
    height: 100%;
    width: 73%;
    margin: auto;
}
.left p{
  font-family: "arial",sans-serif;
  margin-bottom: 40px;
}
.left h1{
  font-family: "arial",sans-serif;
  margin-bottom: 40px;
}
.leftinput .logininput{
    text-align:center;
    color:#fff;
    background-color:#1a1a1a;
    border: none;
    width: 80%;
    margin: 10px 0px;
    border: 2px solid #1a1a1a;
    border-radius:5px;
    padding: 10px 0px;
    width: 100%;
    overflow: hidden;
    font-weight: ;
    font-size: 14px;
    transition:0.4s;
}
.leftinput .logininput:hover{
    border:2px solid #b366ff;
}
.leftinput{
  color: white;
  font-weight: bold;
  width: 100%;
  padding: 40px;
  animation:lgb 1s;
  animation-fill-mode: forwards;
}
@keyframes lgb{
  0%{filter:opacity(0%);}
  100%{filter:opacity(100%);}
}
.left{
  background-image:url(pic5.jpg);
   filter: blur(6px);
  -webkit-filter: blur(6px);
  background-repeat: no-repeat;
  background-size: cover;
}
.submit {
    border: none;
    width:100%;
    padding: 15px 90px;
    border-radius: 5px;
    margin: auto;
    margin-top: 30px;
    background: #1a1a1a;
    color: #fff;
    font-weight: bold;
    transition:0.4s;
}
.submit:hover{
    background:#fff;
    color:#000;
}
hr{
    margin-top:20px;
    border: 1px solid #555;
}
.loginOPT{
  width:100%;
}
.loginOP{
    font-size:13px;
    color:#b366ff;
    text-decoration:none;
    transition:0.4s;
}
.loginOP2{
    font-size:13px;
    color:#b366ff;
    margin:135px;
    text-decoration:none;
    transition:0.4s;
}
.loginOP:hover{
    color:#99ccff;
}
.loginOP2:hover{
    color:#99ccff;
}
.tick{
    background-color:#000;
}
.na_op{
  margin-left:150px;
  margin-top:15px;
}
.noacc{
  font-size:13px;
}
.signup{
  color:#b366ff;
  transition:0.4s;
  font-size:13px;
  text-decoration:none;
}
.signup:hover{
  color:#99ccff;
}
@media only screen and (max-width: 1150px) {
  .logo{
    margin-left:70px;
  }
}
@media only screen and (max-width: 1125px) {
  .logo{
    margin-left:50px;
  }
}
@media only screen and (max-width: 1090px) {
  .logo{
    margin-left:30px;
  }
}
@media only screen and (max-width: 1040px) {
  .logo{
    margin-left:5px;
  }
}
@media only screen and (max-width: 1005px) {
  .loginbox{
    background-color:#;
    height:300px;
    width:0%;
    margin:130px;
    margin-top:20px;
    display:flex;
}
.login_box {
    font-family: "arial",sans-serif;
    width: 100%;
    height: 100%;
    margin:auto;
    border-radius: 10px;
    transition: 0.4s;
}
.leftinput{
  color: white;
  font-weight: bold;
  width: 100%;
  animation:lgb 1s;
  animation-fill-mode: forwards;
}
  .logobox{
    font-family: system-ui;
    height:0%;
    width:0px;
    border-right:3px solid #4d4d4d;
  }
  .logo1{
    font-size:0px;
}
.logo1_2{
    font-size:0px;
}

.logo2{
    font-size:0px;
}
.mblogo{
  margin:60px 280px;
  display:flex;
  width:50%;
}
}
</style>
<body>
<div class="mblogo">
  <span class="mblogoT1">DIGITAL</span>
  <span class="mblogoT2">LIBRARY</span>
 </div>
<div class="loginbox">
 <div class="logobox">
  <div class="logo">
   <span class="logo1">WELCOME</span>
   <span class="logo1_2">TO</span>
   <br>
   <span class="logo2">DIGITAL LIBRARY</span>
  </div>
 </div>
 <div class="login">
  <div class="login">
   <div class="login_box">
    <div class="conta ">
     <form action="login_admin.php" method="POST">
      <div class="leftinput">
       <p class="logintext">ADMIN LOGIN</p>
        <input class="logininput" type="text" name="admin_name" placeholder="Enter Your Username">
        <input class="logininput" type='password' name='admin_pass' placeholder="Enter Your Password">
          <a href="" class="loginOP">Forget Password</a>
        <hr>
        <button type='submit' name='submit' value='submit' class='submit'>DONE</button>
        <div class="na_op">
         <span class="noacc" >Don't have account yet?</span>
         <span><a class="signup" href="">Sign Up</a></span>
        </div>
      </div>
     </form>
    </div>
   </div>
  </div>
 </div>
</div>
</body>
</html>
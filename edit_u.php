<?php 
include_once("db.php");

$SQL = "SELECT * FROM user";
$query  = mysqli_query($conn,$SQL);

if(isset($_POST['submit']) && isset($_GET['id'])){
  $u_name = $_POST['user_name'];
  $u_email = $_POST['user_email'];
  $u_password = $_POST['user_password'];
  $u_contact = $_POST['user_contact'];
  $u_status = $_POST['user_status'];

 $query = "UPDATE user SET user_name = '$u_name', user_email = '$u_email', user_password = '$u_password', user_contact = '$u_contact', user_status = '$u_status' WHERE user_id='".$_GET['id']."'";

  if($result = mysqli_query($conn,$query)){
    echo "<script>alert('Update Success');
    window.location.href='user.php';
    </script>";
  }else{
    echo "<script>alert('Update Failed');</script>";
  }
}

$qry = "SELECT * FROM user WHERE user_id = '".$_GET['id']."'";
$sql = mysqli_query($conn,$qry);
$row = mysqli_fetch_array($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>DIGITAL LIBRARY</title>
<style>
body {
    background-color:#262626;
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
    color:#fff;
}
.topnav{
    background-color:#000;#e6e6e6
    opacity:100%;
    position:fixed;
    overflow: hidden;
    transition: 0.4s;
    height:58px;
    width:100%;
    z-index: 9999;
}
.toptext{
    text-align:;
    padding:20px ;
    transition:0.4s;
}
.stext{
    transition:0.5s;
    color:#737373;
    padding:35px ;
    text-decoration:none;
}
.stext:hover{
  color:#fff;
}
.firstT{
    color: #fff;
    text-decoration: none;
    letter-spacing: 2px;
    padding:0px;
}
.firstT2{
    color: #999;
    text-decoration: none;
    letter-spacing: 2px;
    padding:0px;
}
.firstT3{
    color: #fff;
    text-decoration: none;
    letter-spacing: 2px;
    padding:0px 7px;
    border-left:1px solid #999;
}
.firstT4{
  color:#fff;
  letter-spacing:2px;
  padding:0px 7px;
  margin:0px -7px;
  border-left:1px solid #999;
}
.logo{
  margin-left:0px;
}
.topnav .search-container {
  position: absolute;
  top:17px;
  left:1080px;
}
.topnav input[type=text] {
  padding: 0px;
  transition:0.4s;
  margin-top: 0px;
  font-size: 17px;
  border: none;
  background-color:#000; 
  border:0px; 
  border-bottom:2px solid #737373; 
  color:#fff;
}
.topnav input[type=text]:hover{
  border-bottom:2px solid #fff;
}
.topnav .search-container button {
  float: right;
  transition:0.3s;
  padding: 3px 10px;
  margin-top: 0px;
  margin-right: 16px;
  background: #000;
  color:#999;
  font-size: px;
  border: none;
  cursor: pointer;
}

.topnav .search-container button:hover {
  color:#fff;
}
@media screen and (max-width: 600px) {
  .topnav .search-container {
    float: none;
  }
  .topnav a, .topnav input[type=text], .topnav .search-container button {
    float: none;
    display: block;
    text-align: left;
    width: 100%;
    margin: 0;
    padding: 14px;
  }
  .topnav input[type=text] {
    background-color:#000;
  }
}
.idx{
  margin-left:210px;
  margin-top:10px;
  width:1120px;
}
.idx2{
  margin-left:780px;
  float:left;
  height:850px;
  width:560px;
}
.htext{
  color:#fff;
  font-size:50px;
  text-align:center;
  text-decoration:none;
}
.sidebar {
  margin: 0;
  padding: 0;
  width: 200px;
  margin-top:58px;
  background-color: #0d0d0d;
  position: fixed;
  height: 100%;
  overflow: auto;
}

.sidebar a {
  display: block;
  font-size:20px;
  transition:0.4s;
  color: #737373;
  padding: 20px;
  text-decoration: none;
}


.sidebar a:hover:not(.active) {
  color: #fff;
}

div.content {
  margin-left: 200px;
  padding: 1px 16px;
  height: 1000px;
}

@media screen and (max-width: 700px) {
  .sidebar {
    width: 100%;
    height: auto;
    position: relative;
  }
  .sidebar a {float: left;}
  div.content {margin-left: 0;}
}
.uploadfc{
    background-color:#0d0d0d;
    border:4px solid #0d0d0d;
    border-radius:10px;
    transition:0.4s;
    box-shadow:;
    height:500px;
    width:83.4%;
    margin-left:210px;
    margin-top:65px;
    position:fixed;
    filter:opacity(0%);
    animation: uploadfcA 1s;
    animation-fill-mode: forwards;
}
@keyframes uploadfcA{
    0%{filter:opacity(0%);}
    100%{filter:opacity(100%);}
}
.uploadfc:hover , .uppic img:hover{
    border:4px solid #66ff66;
}
.user-details{
    position:fixed;
    width:40%;
}
.title{
    text-align:center;
    font-size:30px;
    letter-spacing: 2px;
    font-weight:normal;
    padding:7px 0px;
}
.ttudl{
    width:95%;
    margin:auto;
}
.ipt{
    background-color:#1a1a1a;
    font-size:17px;
    width:99%;
    color:#fff;
    border-radius:4px;
    border:2px solid #333;
    transition:0.4s;
}

.uploadfc .ipt:hover{
    border:2px solid #66ff66;
}
.input-box{
    margin:25px 35px;
    font-size:17px;
    font-weight:normal;
    letter-spacing: 1px;
}
.button{
  margin:30px 0px;
  width:100%;
}
.smb{
    margin: 5px 0px;
    width:100%;
    background-color:#000;
    border:0px;
    color:#fff;
    transition:0.4s;
    border-radius:5px;
    padding:10px 80px;
}
.smb:hover{
    background-color:#66ff66;
    color:#000;
}
.uppic{
    background-color:#;
    height:500px;
    width:60%;
    border-radius:6px;
    float:right;
    margin-left:5px;
    display:block;
}
.uppic img{
    height:300px;
    width:300px;
    border:4px solid #222;
    margin:95px 190px;
    border-radius:50%;
    background-size: auto;
     transition:0.4s;
}
#pic.clicked {
    height:400px;
    width:400px;
    margin:45px 140px;
    border-radius:6px;
}
</style>
</head>
<body>
<div class="topnav">
 <div class="toptext">
 <span><a class="firstT" href="index_admin.php">DIGITAL</a></span>
  <span><a class="firstT2" href="index_admin.php">LIBRARY</a></span>
  <span class="firstT3">USER</span>
  <span class="firstT4">EDIT</span>
 </div>
 <div class="search-container">
    <form action="upload.php">
      <input type="text" placeholder="Search.." name="search">
      <button type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>
</div>
 <div class="sidebar">
 <a class="" href="index_admin.php">HOME</a>
  <a href="book.php">BOOK</a>
  <a href="upload.php">UPLOAD</a>
  <a href="user.php">USER</a>
  <a href="">ABOUT</a>
</div>
    <div class="uploadfc">
    <form action="edit_u.php?id=<?=$_GET['id']?>" method="POST">
            <div class="user-details">
                <div class="input-box">
                         <label class="details" for="">Name :</label>
                         <input class="ipt" type="text" name="user_name" value="<?=$row['user_name']?>">
                </div>
                <div class="input-box">
                         <label class="details" for="">Email :</label>
                         <input class="ipt" type="text" name="user_email" value="<?=$row['user_email']?>">
                </div>
                <div class="input-box">
                         <label class="details" for="">Password :</label>
                         <input class="ipt" type="text" name="user_password" value="<?=$row['user_password']?>" >
                </div>
                <div class="input-box">
                        <label class="details" for="">Contact :</label>
                        <input class="ipt" type="text" name="user_contact" value="<?=$row['user_contact']?>" >
                </div>
                <div class="input-box">
                         <label class="details" for="">Status :</label>
                         <input class="ipt" type="text" name="user_status" value="<?=$row['user_status']?>" >
          
                    <div class="button">
                        <button type="submit" value="submit" name="submit" class="smb">DONE</button>
                        <button type="button" onclick="window.location.href='user.php'" class="smb">BACK</button>
                    </div>
                </div>
            </div>
            <div class="uppic">
           <img src="pic/fscat.jpg" alt="" id='pic' onclick="mouseOver()">
        </div>
        </form>
    </div>
  
</body>
<script type='text/javascript'>   
$('#pic').on('click', function() {
    $(this).toggleClass('clicked');
});
</script>
</html>

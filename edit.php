<?php 
include_once("db.php");

$SQL = "SELECT * FROM book";
$query  = mysqli_query($conn,$SQL);

if(isset($_POST['submit']) && isset($_GET['id'])){
  $book_tittle=$_POST['book_title'];
  $book_name=$_POST['book_name'];
  $book_author=$_POST['book_author'];
  $book_public_date=$_POST['book_public_date'];
  $book_language=$_POST['book_language'];

 echo $query = "UPDATE book SET book_title='$book_title',book_name='$book_name',book_author='$book_author',book_public_date='$book_public_date',book_language='$book_language' WHERE book_id='".$_GET['id']."'";

  if($result = mysqli_query($conn,$query)){
    echo "<script>alert('Update Success');
    window.location.href='book.php';
    </script>";
  }else{
    echo "<script>alert('Update Failed');</script>";
  }
}

$qry = "SELECT * FROM book WHERE book_id = '".$_GET['id']."'";
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
    width:83%;
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
.uploadfc:hover{
    border:4px solid #b366ff;
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
    border:2px solid #b366ff;
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
    background-color:#b366ff;
    color:#000;
}
.uppic{
    background-color:#000;
    height:500px;
    width:60%;
    border-radius:6px;
    float:right;
    margin-left:5px;
    display:block;
}
.uppic img{
    height:100%;
    width:100%;
    border-radius:6px;
    background-size: auto;
}
</style>
</head>
<body>
<div class="topnav">
 <div class="toptext">
 <span><a class="firstT" href="index_admin.php">DIGITAL</a></span>
  <span><a class="firstT2" href="index_admin.php">LIBRARY</a></span>
  <span class="firstT3">BOOK</span>
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
        <form action="edit.php?id=<?=$_GET['id']?>" method="POST">
            <div class="user-details">
                <div class="input-box">
                         <label class="details" for="">Title :</label>
                         <input class="ipt" type="text" name="book_title" value="<?=$row['book_title']?>">
                </div>
                <div class="input-box">
                         <label class="details" for="">Name :</label>
                         <input class="ipt" type="text" name="book_name" value="<?=$row['book_name']?>">
                </div>
                <div class="input-box">
                         <label class="details" for="">Author :</label>
                         <input class="ipt" type="text" name="book_author" value="<?=$row['book_author']?>" >
                </div>
                <div class="input-box">
                        <label class="details" for="">Language :</label>
                        <input class="ipt" type="text" name="book_language"value="<?=$row['book_language']?>" >
                </div>
                <div class="input-box">
                         <label class="details" for="">Public Date :</label>
                         <input class="ipt" type="date" name="book_public_date" value="<?=$row['book_public_date']?>" >
          
                    <div class="button">
                        <button type="submit" value="submit" name="submit" class="smb">DONE</button>
                        <button type="button" onclick="window.location.href='book.php'" class="smb">BACK</button>
                    </div>
                </div>
            </div>
            <div class="uppic">
           <img src="pic/<?=$row['book_name']?>" alt="">
        </div>
        </form>
    </div>
  
</body>
<script>
</script>
</html>

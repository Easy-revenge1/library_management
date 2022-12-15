<?php 
include_once("db.php");

$query = "SELECT * FROM `user`";
$SQL   = mysqli_query($conn,$query);

?>

 <!DOCTYPE html>
 <html>
 <head>
    <title>DIGITAL LIBRARY</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {
    background-color:#262626;
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
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
    border-left:1px solid #999  ;
}
.line{
    width:1%;
    background-color:#999;
}
.textc{
    margin-left:115px;
}
.rainbow {
  text-align: ;
  font-size: px;
  text-decoration: none;
  letter-spacing: 1px;
  animation: colorRotate 8s linear 0s infinite;
}

@keyframes colorRotate {
  from {
    color: #6666ff;
  }
  10% {
    color: #0099ff;
  }
  50% {
    color: #00ff00;
  }
  75% {
    color: #ff3399;
  }
  100% {
    color: #6666ff;
  }
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
.tableshow{
    background-color:#1a1a1a;
    position:fixed;
    border:4px solid #1a1a1a;
    border-radius:10px;
    transition:0.4s;
    margin-top:110px;
    margin-left:210px;
    width:83%;
    border-radius:5px;
}
.tableshow:hover{
    border:4px solid #66ff66;
}
.table{
    text-align:center;
    margin:5px 10px;
    width:98%;
    color:#fff;
}
table{
    border-collapse: collapse;
}
th{
    padding: 8px;
    text-align: center;
    border-bottom:1px solid #999;
    border-collapse: collapse;
}
td{
    padding:5px 0px;
}
tr{
    transition:0.4s;
}
tr:hover {
    background-color: #66ff66;
    color:#000;
}
.booksearch{
  position:fixed;
  width:81.8%;
  margin-top:65px;
  margin-left:210px;
}
.searchbook{
  background-color:#1a1a1a;
  color:#fff;
  transition:0.4s;
  width: 100%;
  padding:10px;
  border:2px solid #1a1a1a;
  border-radius:5px;
}
.searchbook:hover{
    border:2px solid #66ff66;
}
.idamt{
    filter:opacity(0%);
    animation: indexA1 1s;
    animation-fill-mode: forwards;
}
@keyframes indexA1{
    0%{filter:opacity(0%);}
    100%{filter:opacity(100%);}
}
.edt{
  background-color:#333;
  color:#fff;
  border:0px;
  border-radius:3px;
  padding:7px 40px;
  transition:0.4s;
}
.edt:hover{
  background-color:#e6e6e6;
  color:#000;
}
</style>
 </head>
 <body>
 <div class="topnav">
 <div class="toptext">
 <span><a class="firstT" href="index_admin.php">DIGITAL</a></span>
  <span><a class="firstT2" href="index_admin.php">LIBRARY</a></span>
  <span class="firstT3">USER</span>
 </div>
 <div class="search-container">
    <form action="index_admin.php">
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
<div class="idamt">
<div class="booksearch">
    <input type="text" placeholder="What book you looking for..." class="searchbook" name="">
</div>
<div class="tableshow">
<table class="table"> 
    <tr>
    <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Password</th>
        <th>Contact</th>
        <th>Status</th>
        <th></th>
    </tr>
    <div>
    <tr class="tdhv">
        <?php while($row = mysqli_fetch_array($SQL))  {?>
            <td><?=$row["user_id"]?></td>
            <td><?=$row["user_name"]?></td>
            <td><?=$row["user_email"]?></td>
            <td><?=$row["user_password"]?></td>
            <td><?=$row["user_contact"]?></td>
            <td><?=$row["user_status"]?></td>
            <td><button class="edt" onclick="window.location.href='edit.php?id=<?=$row['user_id']?>'"><i class="fa fa-pencil"></i></button></td>
    </tr>
 <?php  }?>
    </div>
 </table>
</div>
</div>
 </html>
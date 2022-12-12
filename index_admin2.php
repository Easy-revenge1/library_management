<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>DIGITAL LIBRARY</title>
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
    margin:0px 450px;
    
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
.rcm{
  background-color:#bf00ff;
  height:200px;
  width:50%;
  margin-top:10px;
  transition:0.4s;
  filter: grayscale(70%);
  border-radius:10px;
  transform: scale(0, 0);
  animation: zoom-in-zoom-out 1s ease;
  animation-fill-mode: forwards;
  animation-delay:0.2s;
}
@keyframes zoom-in-zoom-out {
  0% {
    transform: scale(0, 0);
  }
  100% {
    transform: scale(1.0, 1.0);
  }
}
.rcm:hover{
  filter: grayscale(0%);
}
.rcm2{
  background-color:#1a1aff;
  height:200px;
  width:50%;
  
  margin-top:10px;
  transition:0.4s;
  filter: grayscale(70%);
  border-radius:10px;
  transform: scale(0, 0);
  animation: zoom-in-zoom-out2 1s ease;
  animation-fill-mode: forwards;
  animation-delay:0.3s;
}
@keyframes zoom-in-zoom-out2 {
  0% {
    transform: scale(0, 0);
  }
  100% {
    transform: scale(1.0, 1.0);
  }
}
.rcm2:hover{
  filter: grayscale(0%);
}
.rcm3{
  background-color:#ff5050;
  height:200px;
  width:50%;
  margin-top:10px;
  transition:0.7s;
  filter: grayscale(70%);;
  border-radius:10px;
  transform: scale(0, 0);
  animation: zoom-in-zoom-out3 1s ease;
  animation-fill-mode: forwards;
  animation-delay:0.4s;
}
@keyframes zoom-in-zoom-out3 {
  0% {
    transform: scale(0, 0);
  }
  100% {
    transform: scale(1.0, 1.0);
  }
}
.rcm3:hover{
  filter: grayscale(0%);
}
.rcm4{
  background-color:#e6e600;
  height:200px;
  width:50%;
  margin-top:10px;
  transition:0.7s;
  filter: grayscale(70%);;
  border-radius:10px;
  transform: scale(0, 0);
  animation: zoom-in-zoom-out3 1s ease;
  animation-fill-mode: forwards;
  animation-delay:0.5s;
}
@keyframes zoom-in-zoom-out3 {
  0% {
    transform: scale(0, 0);
  }
  100% {
    transform: scale(1.0, 1.0);
  }
}
.rcm4:hover{
  filter: grayscale(0%);
}
.rcm5{
  background-color:#248f24;
  height:410px;
  width:100%;
  margin-top:10px;
  transition:0.7s;
  filter: grayscale(70%);;
  border-radius:10px;
  transform: scale(0, 0);
  animation: zoom-in-zoom-out3 1s ease;
  animation-fill-mode: forwards;
  animation-delay:0.6s;
}
@keyframes zoom-in-zoom-out3 {
  0% {
    transform: scale(0, 0);
  }
  100% {
    transform: scale(1.0, 1.0);
  }
}
.rcm5:hover{
  filter: grayscale(0%);
}
.rcm6{
  background-color:#248f24;
  height:413px;
  width:100%;
  margin-top:10px;
  transition:0.7s;
  filter: grayscale(70%);
  border-radius:10px;
  transform: scale(0, 0);
  animation: zoom-in-zoom-out3 1s ease;
  animation-fill-mode: forwards;
  animation-delay:0.7s;
}
@keyframes zoom-in-zoom-out3 {
  0% {
    transform: scale(0, 0);
  }
  100% {
    transform: scale(1.0, 1.0);
  }
}
.rcm6:hover{
  filter: grayscale(0%);
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

@media only screen and (max-width:800px) {
  /* For tablets: */
  .main {
    width: 80%;
    padding: 0;
  }
  .right {
    width: 100%;
  }
}
@media only screen and (max-width:500px) {
  /* For mobile phones: */
  .topnav, .search-container, .logo , .rcm {
    width: 100%;
  }
}
</style>
</head>
<body>
<div class="topnav">
 <div class="toptext">
  <span class="firstT">DIGITAL</span>
  <span class="firstT2">LIBRARY</span>
  <span class="firstT3">ADMIN WEBPAGE</span>
 </div>
 <div class="search-container">
    <form action="index_admin.php">
      <input type="text" placeholder="Search.." name="search">
      <button type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>
</div>
 <div class="sidebar">
  <a class="" href="index_admin2.php">HOME</a>
  <a href="book.php">BOOK</a>
  <a href="upload.php">UPLOAD</a>
  <a href="">ABOUT</a>
</div>
 <div style="height:57px;"></div>
 <div class="idx2">
 <div class="rcm5">
   </div>
   <div class="rcm5">
   </div>
</div>
<div class="idx">
   <div class="rcm">
   </div>
   <div class="rcm2">
   </div>
   <div class="rcm3">
   </div>
   <div class="rcm4">
   </div>
</div>
</body>
</html>
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
    filter:opacity(0%);
    animation: topnav1A 2s;
    animation-fill-mode: forwards;
}
@keyframes topnav1A{
    0%{filter:opacity(0%);}
    100%{filter:opacity(100%);}
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
    margin-left: ;
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
.rcm{
  background-image:url('pic/pyh.jpg');
  height:300px;
  width:1149px;
  transition:0.4s;
  filter: grayscale(90%);;
  background-position:center;
  background-repeat: no-repeat;
  background-size:cover;
  margin-left:200px;
  margin-top:1px;
  border-radius:0px;
  transform: scale(0, 0);
  animation: zoom-in-zoom-out 1s ease;
  animation-fill-mode: forwards;
  animation-delay:2s;
}
@keyframes zoom-in-zoom-out {
  0% {
    transform: scale(0, 0);
  }
  100% {
    transform: scale(1.0, 1.0);
  }
}
.htext{
  color:#000;
  font-size:50px;
  text-decoration:none;

}
.rcm:hover{
  filter: grayscale(0%);
}
.rcm2{
  background-image:url('pic/pys5.jpg');
  height:300px;
  width:1149px;
  transition:0.7s;
  filter: grayscale(90%);;
  background-position:center;
  background-repeat: no-repeat;
  background-size:cover;
  margin-left:200px;
  margin-top:1px;
  border-radius:0px;
  transform: scale(0, 0);
  animation: zoom-in-zoom-out2 1s ease;
  animation-fill-mode: forwards;
  animation-delay:2.1s;
}
@keyframes zoom-in-zoom-out2 {
  0% {
    transform: scale(0, 0);
  }
  100% {
    transform: scale(1.0, 1.0);
  }
}
.htext{
  color:#000;
  font-size:50px;
  text-decoration:none;
}
.rcm2:hover{
  filter: grayscale(0%);
}
.rcm3{
  background-image:url('pic/sce.jpg');
  height:300px;
  width:1149px;
  transition:0.7s;
  filter: grayscale(90%);;
  background-position:center;
  background-repeat: no-repeat;
  background-size:cover;
  margin-left:200px;
  margin-top:1px;
  border-radius:0px;
  transform: scale(0, 0);
  animation: zoom-in-zoom-out3 1s ease;
  animation-fill-mode: forwards;
  animation-delay:2.2s;
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
.sidebar {
  margin: 0;
  padding: 0;
  width: 200px;
  margin-top:58px;
  position: absolute;
  left:-200px;
  background-color: #0d0d0d;
  position: fixed;
  height: 100%;
  overflow: auto;
  animation-name: example;
  animation-delay:0.8s;
  animation-duration: 1s;
  animation-fill-mode: forwards;
}
@keyframes example {
  0%   {left:-200px; top:0px;}
  100% {left:0px; top:0px;}
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
  <span class="logo"><a href="" class="firstT">DIGITAL</a></span>
  <span class="logo"><a href="" class="firstT" style="color:#999;">LIBRARY</a></span>
 </div>
 <div class="search-container">
    <form action="demo.php">
      <input type="text" placeholder="Search.." name="search">
      <button type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>
</div>
 <div class="sidebar">
  <a class="demo2.php" href="">HOME</a>
  <a href="">BOOK</a>
  <a href="">ABOUT</a>
</div>
 <div style="height:57px;"></div>
<div class="idx">
   <div class="rcm">
     <a href="" class="htext"></a>
   </div>
   <div class="rcm2">
   </div>
   <div class="rcm3">
   </div>
</div>
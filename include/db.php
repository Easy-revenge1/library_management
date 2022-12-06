<?php 
session_start();

$server = "localhost";
$user	= "root";
$pass	= "lobak050902";
$data	= "library_mng";

$conn = mysqli_connect($server,$user,$pass,$data);

if($conn -> connect_error){
	die("Connect failed: ".$conn->connect_error);
}

 ?>
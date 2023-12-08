<?php 
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');

$server = "localhost";
$name   = "root";
$pass   ="";
$db     ="library_management";


$conn   = mysqli_connect($server,$name,$pass,$db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}  


?>
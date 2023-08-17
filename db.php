<?php 
session_start();

$server = "localhost:3307";
$name   = "root";
$pass   ="";
$db     ="library_management";


$conn   = mysqli_connect($server,$name,$pass,$db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}  

?>
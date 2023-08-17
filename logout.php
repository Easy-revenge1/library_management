<?php 
include_once('db.php');
session_destroy();
header("location:login_admin.php");
exit; 
 ?>
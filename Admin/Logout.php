<?php 
// Properly handle errors and warnings
error_reporting(E_ALL);
ini_set('display_errors', true);

// Include the database configuration file
require_once('../db.php');

// Check if the session is active before destroying it
if(session_status() === PHP_SESSION_ACTIVE) {
    session_destroy();
}

// Redirect to the login page using a relative URL
header("Location: AdminLogin.php");
exit();
?>

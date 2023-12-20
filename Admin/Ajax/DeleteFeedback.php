<?php
include_once("../../db.php");

if ($_GET['action'] == 'delete' && isset($_GET['id'])) {
    $feedbackId = $_GET['id'];

    $deleteQuery = "DELETE FROM contact WHERE id = ?";
    $deleteStmt = mysqli_prepare($conn, $deleteQuery);
    mysqli_stmt_bind_param($deleteStmt, "i", $feedbackId);

    if (mysqli_stmt_execute($deleteStmt)) {
        $response = array('success' => true);
        echo json_encode($response);
        exit();
    } else {
        $error = mysqli_stmt_error($deleteStmt);
        $response = array('success' => false, 'error' => $error);
        echo json_encode($response);
        exit();
    }
}
?>

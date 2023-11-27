<?php
include_once("../../db.php");

if ($_GET['action'] == 'delete' && isset($_GET['id'])) {
    $bookId = $_GET['id'];

    $deleteQuery = "DELETE FROM book WHERE book_id = ?";
    $deleteStmt = mysqli_prepare($conn, $deleteQuery);
    mysqli_stmt_bind_param($deleteStmt, "i", $bookId);

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

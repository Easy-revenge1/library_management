<?php
include_once("../../db.php");

if (isset($_GET['query'])) {
    $query = '%' . $_GET['query'] . '%';
    $userId = $_SESSION["user_id"];

    $searchQuery = "SELECT watch_record.*, book.*
    FROM `watch_record`
    INNER JOIN `book` ON watch_record.book_id = book.book_id
    WHERE watch_record.user_id = ? AND
          (book.book_title LIKE ? OR
           book.book_author LIKE ?)";

    $stmt = mysqli_prepare($conn, $searchQuery);
    $stmt->bind_param("iss", $userId, $query, $query);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    $books = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($books);
    exit;
}
?>

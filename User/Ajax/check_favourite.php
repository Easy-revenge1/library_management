<?php
include('../../db.php');

// Initialize $favoriteCount to 0
$favoriteCount = 0;

if (isset($_POST['userId']) && isset($_POST['bookId'])) {
    $userId = $_POST['userId'];
    $bookId = $_POST['bookId'];

    $checkFavouriteQuery = "SELECT 1 FROM favourites WHERE user_id = ? AND book_id = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $checkFavouriteQuery);
    mysqli_stmt_bind_param($stmt, 'ii', $userId, $bookId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $favoriteCount);
    mysqli_stmt_fetch($stmt);
}

// Return the value of $favoriteCount
echo $favoriteCount;
?>

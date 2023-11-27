<?php
include_once("../../db.php");

if (isset($_GET['query'])) {
    $query = '%' . $_GET['query'] . '%';

    // Additional filters
    $languageFilter = isset($_GET['language']) ? $_GET['language'] : '';
    $categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';

    $searchQuery = "SELECT book.*, category.category_name, language.language_name
    FROM `book`
    INNER JOIN `category` ON book.category_id = category.category_id
    INNER JOIN `language` ON book.language_id = language.language_id
    WHERE (book.book_title LIKE '$query' OR book.book_author LIKE '$query')";

    // Apply language filter if set
    if ($languageFilter !== '') {
        $searchQuery .= " AND language.language_id = $languageFilter";
    }

    // Apply category filter if set
    if ($categoryFilter !== '') {
        $searchQuery .= " AND category.category_id = $categoryFilter";
    }

    error_log("Debug: Search Query: " . $searchQuery);

    $result = mysqli_query($conn, $searchQuery);

    $books = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($books);
    exit;
}
?>

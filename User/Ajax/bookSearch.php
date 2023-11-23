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
    WHERE book.book_title LIKE ? OR book.book_author LIKE ?";

    // Apply language filter
    if ($languageFilter !== '') {
        $searchQuery .= " AND language.language_id = ?";
    }

    // Apply category filter
    if ($categoryFilter !== '') {
        $searchQuery .= " AND category.category_id = ?";
    }

        error_log("Debug: Search Query: " . $searchQuery);  // Log the search query


    $stmt = mysqli_prepare($conn, $searchQuery);

    // Create an array to store parameters and their types
    $params = ["ss", &$query, &$query];
    
    // Add parameters and types for language and category filters
    if ($languageFilter !== '') {
        $params[0] .= "i"; // Add "i" for integer type
        $params[] = &$languageFilter;
    }
    
    if ($categoryFilter !== '') {
        $params[0] .= "i"; // Add "i" for integer type
        $params[] = &$categoryFilter;
    }
    
    // Call bind_param with the dynamic parameters
    call_user_func_array([$stmt, 'bind_param'], $params);
    
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

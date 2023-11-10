<?php
include_once("../db.php");
include_once("NavigationBar.php");

$bookListQuery = "SELECT * FROM `book`";
$bookListStmt = mysqli_prepare($conn, $bookListQuery);

if ($bookListStmt) {
    if (mysqli_stmt_execute($bookListStmt)) {
        $result = mysqli_stmt_get_result($bookListStmt);
        mysqli_stmt_close($bookListStmt);
    } else {
        echo "Error executing the prepared statement: " . mysqli_stmt_error($bookListStmt);
    }
} else {
    echo "Error preparing the statement: " . mysqli_error($conn);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/semantic.min.css">
    <title>Your Profile</title>
    <style>
        .book-card {
            height: 350px;
            margin-bottom:100px;
        }

        .book-img {
            width: 300px;
            height: 350px;
            object-fit: cover;
            border-radius: 15px;
        }

        .book-title {
            text-align: center;
        }
    </style>


</head>

<body style="margin-top: 100px;">
    <div class="ui three column grid">
        <?php

        if ($bookListStmt) {

            while ($row = mysqli_fetch_assoc($result)) {
                $bookTitle = $row['book_title'];
                $bookCover = $row['book_cover'];

                echo '<div class="">';
                echo '<div class="book-card">';
                echo '<div class="image">';
                echo '<img class="book-img" src="' . $bookCover . '" alt="' . $bookTitle . '">';
                echo '</div>';
                echo '<div class="book-title">';
                echo '<h4>' . $bookTitle . '</h4>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "Error executing the prepared statement: " . mysqli_stmt_error($bookListStmt);
        }

        ?>
    </div>
</body>
<script src="../Fomantic-ui/dist/semantic.min.js"></script>

</html>
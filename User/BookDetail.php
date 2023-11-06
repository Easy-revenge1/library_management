<?php
include('../db.php');
date_default_timezone_set('Asia/Kuala_Lumpur');

$bookId = $_GET['id'];

$BookDetail = "SELECT * FROM `book` WHERE book_id = ?";

$stmt = mysqli_prepare($conn, $BookDetail);
mysqli_stmt_bind_param($stmt, 'i', $bookId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (isset($_POST['favourite'])) {
    $bookId = $_GET['id'];
    $userId = $_SESSION['user_id'];

    // Check if the combination of user_id and book_id already exists in favorites
    // $checkFavouriteQuery = "SELECT COUNT(*) FROM favourites WHERE user_id = ? AND book_id = ?";
    // $checkStmt = mysqli_prepare($conn, $checkFavouriteQuery);
    // mysqli_stmt_bind_param($checkStmt, "ii", $userId, $bookId);
    // mysqli_stmt_execute($checkStmt);
    // mysqli_stmt_bind_result($checkStmt, $favoriteCount);
    // mysqli_stmt_fetch($checkStmt);
    // mysqli_stmt_close($checkStmt);

    if ($favoriteCount == 0) {
        // The book is not in favorites, so add it
        $addToFavouriteQuery = "INSERT INTO `favourites` (`user_id`, `book_id`) VALUES (?, ?)";
        $addstmt = mysqli_prepare($conn, $addToFavouriteQuery);
        mysqli_stmt_bind_param($addstmt, "ii", $userId, $bookId);

        if (mysqli_stmt_execute($addstmt)) {
            $book_name = $row['book_name'];
            // echo '<div class="ui success message">' . $book_name . ' had added to your bookmark</div>';
            header("Location: BookDetail.php?id=" . $bookId);
            // exit();
        } else {
            // Handle database error
            $error = mysqli_error($conn);
            // Log the error and show a user-friendly message
            error_log("Database Error: $error");
            // echo '<div class="ui error message">Failed to add to favorites. Please try again later</div>';
        }
    } else {
        echo '<div class="ui error message">This book is already in your favorites.</div>';
    }
} elseif (isset($_POST['unfavourite'])) {
    $bookId = $_GET['id'];
    $userId = $_SESSION['user_id'];

    $removeFavouriteQuery = "DELETE FROM favourites WHERE user_id = ? AND book_id = ?";
    $removestmt = mysqli_prepare($conn, $removeFavouriteQuery);
    mysqli_stmt_bind_param($removestmt, "ii", $userId, $bookId);

    if (mysqli_stmt_execute($removestmt)) {
        $book_name = $row['book_name'];
        // echo '<div class="ui success message">' . $book_name . ' has been remove from your bookmark</div>';
        header("Location: BookDetail.php?id=" . $bookId);
        exit();
    } else {
        $error = mysqli_error($conn);
        //Log the error
        error_log("Database Error: $error");
        // echo '<div class="ui error message">Error</div>';
    }
}

$baseURL = "http://localhost/library_management/";

?>


<!DOCTYPE html>
<html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/reset.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/site.css">

    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/container.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/grid.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/header.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/image.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/menu.css">

    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/divider.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/segment.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/form.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/input.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/button.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/list.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/message.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/icon.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/semantic.min.css">
</head>

<body>
    <div class="ui container">
        <div class="ui grid">
            <div class="four wide column">
                <?php
                $bookCoverPath = $row["book_cover"];
                $bookCoverUrl = $baseURL . $bookCoverPath;
                ?>
                <img src="<?= $bookCoverUrl ?>" alt="Book Cover" class="ui fluid image">
            </div>
            <div class="twelve wide column">
                <h1 class="ui header"><?php echo $row['book_title']?></h1>
                <p><?php echo $row['book_description']?></p>
                <div class="ui label">$19.99</div>
                <div class="ui buttons">
                    <form id="watchNowForm" action="watch_now.php" method="post">
                        <button class="ui blue button" type="submit">Watch Now</button>
                    </form>
                    <form id="favoriteForm" action="BookDetail.php?id=<?php echo $bookId; ?>" method="post">
                        <button id="favoriteButton" type="submit" name="favourite" value="favourite">Favorite</button>
                    </form>
                </div>

                <div class="ui divider"></div>

                <h2 class="ui header">Reviews</h2>
                <div class="ui items">
                    <div class="item">
                        <div class="content">
                            <div class="header">Review Title 1</div>
                            <div class="meta">
                                <span class="rating">Rating: 4/5</span>
                            </div>
                            <div class="description">
                                <p>Review content goes here.</p>
                            </div>
                            <div class="extra">
                                <p>By User123 - 2023-10-31</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ui divider"></div>

                <h2 class="ui header">Add a Review</h2>
                <form class="ui form">
                    <div class="field">
                        <label>Rating</label>
                        <select class="ui dropdown">
                            <option value="5">5 - Excellent</option>
                            <option value="4">4 - Very Good</option>
                            <option value="3">3 - Good</option>
                            <option value="2">2 - Fair</option>
                            <option value="1">1 - Poor</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Review Title</label>
                        <input type="text" name="reviewTitle" placeholder="Enter your review title">
                    </div>
                    <div class="field">
                        <label>Review Comment</label>
                        <textarea rows="2" name="reviewComment" placeholder="Enter your review comment"></textarea>
                    </div>
                    <button class="ui primary button" type="submit">Submit Review</button>
                </form>

                <div class="ui divider"></div>

                <!-- <h2 class="ui header">Preview</h2>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/VIDEO_ID" frameborder="0" allowfullscreen></iframe> -->
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            checkFavoriteStatus();

            function checkFavoriteStatus() {
                var userId = <?php echo $_SESSION['user_id']; ?>;
                var bookId = <?php echo $bookId; ?>; // Retrieve the book's ID from your PHP code

                // Use AJAX to asynchronously check the favorite status
                $.ajax({
                    type: 'POST',
                    url: 'Ajax/check_favourite.php',
                    data: {
                        userId: userId,
                        bookId: bookId
                    },
                    success: function(response) {
                        var button = $('#favoriteButton');

                        if (response == '1') {
                            // The book is already a favorite
                            button.removeClass('ui yellow button').addClass('ui grey button');
                            button.text('Unfavorite');
                            button.attr('name', 'unfavourite');
                            button.attr('value', 'unfavourite');
                            // console.log('work');
                        } else {
                            // The book is not a favorite
                            button.removeClass('ui grey button').addClass('ui yellow button');
                            button.text('Favorite');
                            button.attr('name', 'favourite');
                            button.attr('value', 'favourite');
                        }
                    },

                    error: function(xhr, status, error) {
                        // Handle AJAX errors here
                        console.log('AJAX error: ' + error);
                        // You can display an error message or take other actions as needed
                    }
                });
            }
        });
    </script>
</body>

</html>

<script src="../Fomantic-ui/dist/semantic.min.js"></script>
<script src="../Fomantic-ui/dist/components/form.js"></script>
<script src="../Fomantic-ui/dist/components/transition.js"></script>
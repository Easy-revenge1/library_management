<?php
include('../db.php');

$bookId = $_GET['id'];
$baseURL = "http://localhost/library_management/";

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$totalReview = "SELECT COUNT(*) as total FROM `reviews` WHERE book_id = $bookId";
$reviewCountResult = mysqli_query($conn, $totalReview);
$reviewCountData = mysqli_fetch_assoc($reviewCountResult);
$totalReviews = $reviewCountData['total'];

$BookDetail = "SELECT * FROM `book` WHERE book_id = ?";
$stmt = mysqli_prepare($conn, $BookDetail);
mysqli_stmt_bind_param($stmt, 'i', $bookId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

$reviewsPerPage = 4;

$offset = ($page - 1) * $reviewsPerPage;

$ReviewListing = "SELECT reviews.*, `user`.`user_name`, `user`.`user_id` 
                 FROM `reviews` 
                 INNER JOIN `user` ON reviews.user_id = user.user_id
                 WHERE reviews.book_id = ?
                 LIMIT ?, ?";
$reviewStmt = mysqli_prepare($conn, $ReviewListing);
mysqli_stmt_bind_param($reviewStmt, "iii", $bookId, $offset, $reviewsPerPage);
mysqli_stmt_execute($reviewStmt);
$reviewResult = mysqli_stmt_get_result($reviewStmt);

$totalPages = ceil($totalReviews/$reviewsPerPage);


if (isset($_POST['favourite'])) {
    $bookId = $_GET['id'];
    $userId = $_SESSION['user_id'];

    if ($favoriteCount == 0) {
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

if (isset($_POST["submit"])) {
    $userId = $_SESSION["user_id"];
    $rating = $_POST["rating"];
    $title = $_POST["title"];
    $comment = $_POST["comment"];

    // Check if any of the fields are empty
    if (empty($rating) || empty($title) || empty($comment)) {
        echo '<div class="ui error message">Please fill in all the required fields.</div>';
    } else {
        // All fields are filled, proceed with inserting the review
        $submitReviewQuery = "INSERT INTO `reviews`(`book_id`, `user_id`, `rating`, `title`, `comment`) VALUES(?, ?, ?, ?, ?)";
        $submitReview = mysqli_prepare($conn, $submitReviewQuery);

        if ($submitReview) {
            mysqli_stmt_bind_param($submitReview, 'iiiss', $bookId, $userId, $rating, $title, $comment);

            if (mysqli_stmt_execute($submitReview)) {
                echo '<div class="ui success message">Your Review on this book has been submitted</div>';
                // Optionally, you can redirect the user after a successful submission
                // header("Location: BookDetail.php?id=" . $bookId);
                // exit();
            } else {
                echo '<div class="ui error message">Failed to submit your review.</div>';
            }
        }
    }
}

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
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/rating.min.css">
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
                <h1 class="ui header">
                    <?php echo $row['book_title'] ?>
                </h1>
                <p>
                    <?php echo $row['book_description'] ?>
                </p>
                <div class="ui label">$19.99</div>
                <div class="ui buttons">
                    <form id="watchNowForm" action="watch_now.php" method="post">
                        <button class="ui blue button" type="submit">Watch Now</button>
                    </form>
                    <form id="favoriteForm" action="BookDetail.php?id=<?php echo $bookId ?>" method="post">
                        <button id="favoriteButton" type="submit" name="favourite" value="favourite">Favorite</button>
                    </form>
                </div>

                <div class="ui divider"></div>

                <h2 class="ui header">Reviews</h2>
                <div class="ui items">
                    <?php if ($totalReviews > 0) {
                        while ($rowReview = mysqli_fetch_assoc($reviewResult)) {
                            ?>
                            <div class="item">
                                <div class="content">
                                    <div class="header">
                                        <?= $rowReview['title'] ?>
                                    </div>
                                    <div class="meta">
                                        <div class="ui yellow disabled rating" data-rating="<?= $rowReview['rating'] ?>"
                                            data-max-rating="5"></div>
                                    </div>
                                    <div class="description">
                                        <p>
                                            <?= $rowReview['comment'] ?>
                                        </p>
                                    </div>
                                    <div class="extra">
                                        <p>By
                                            <?= $rowReview['user_name'] ?> -
                                            <?php
                                            $datePosted = $rowReview['date_posted'];
                                            $formattedDate = date('Y-m-d H:i', strtotime($datePosted));
                                            echo $formattedDate;
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="message">No reviews yet for this book.</div>
                    <?php } ?>
                </div>

                <?php if ($totalReviews > 0) { ?>
                    <div class="ui pagination menu">
                        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                            <a class="item <?php echo $i === $page ? 'active' : ''; ?>"
                                href="?id=<?php echo $bookId; ?>&page=<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>


                <div class="ui divider"></div>

                <h2 class="ui header">Add a Review</h2>
                <form class="ui form" action="BookDetail.php?id=<?php echo $bookId ?>" method="POST">
                    <div class="field">
                        <label>Rating</label>
                        <select class="ui dropdown" name="rating">
                            <option value="5">5 - Excellent</option>
                            <option value="4">4 - Very Good</option>
                            <option value="3">3 - Good</option>
                            <option value="2">2 - Fair</option>
                            <option value="1">1 - Poor</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Review Title</label>
                        <input type="text" name="title" placeholder="Enter your review title">
                    </div>
                    <div class="field">
                        <label>Review Comment</label>
                        <textarea rows="2" name="comment" placeholder="Enter your review comment"></textarea>
                    </div>
                    <button class="ui primary button" type="submit" name="submit">Submit Review</button>
                </form>

                <div class="ui divider"></div>

                <!-- <h2 class="ui header">Preview</h2>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/VIDEO_ID" frameborder="0" allowfullscreen></iframe> -->
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.ui.rating').rating({
                maxRating: 5,
            });

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
                    success: function (response) {
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

                    error: function (xhr, status, error) {
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
<script src="../Fomantic-ui/dist/components/rating.js"></script>

<style>
    .img {
        background-size: cover;
    }
</style>
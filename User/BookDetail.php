<?php
include('../db.php');
ob_start();
include_once("NavigationBar.php");

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

$BookDetail = "SELECT b.*, l.language_name, c.category_name,
    COALESCE(COUNT(wr.book_id), 0) AS total_views,
    AVG(reviews.rating) AS overall_rating
FROM `book` b
INNER JOIN `language` l ON b.`language_id` = l.`language_id`
INNER JOIN `category` c ON b.`category_id` = c.`category_id`
LEFT JOIN `watch_record` wr ON b.`book_id` = wr.`book_id`
LEFT JOIN `reviews` ON b.`book_id` = reviews.`book_id`
WHERE b.`book_id` = ?
GROUP BY b.`book_id`";

$stmt = mysqli_prepare($conn, $BookDetail);
mysqli_stmt_bind_param($stmt, 'i', $bookId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);



$reviewsPerPage = 8;

$offset = ($page - 1) * $reviewsPerPage;

$ReviewListing = "SELECT reviews.*, user.*
FROM reviews
INNER JOIN user ON reviews.user_id = user.user_id
WHERE reviews.book_id = ?
LIMIT ?, ?";
$reviewStmt = mysqli_prepare($conn, $ReviewListing);
mysqli_stmt_bind_param($reviewStmt, "iii", $bookId, $offset, $reviewsPerPage);
mysqli_stmt_execute($reviewStmt);
$reviewResult = mysqli_stmt_get_result($reviewStmt);


$totalPages = ceil($totalReviews / $reviewsPerPage);


if (isset($_POST['favourite'])) {
    $bookId = $_GET['id'];
    $userId = $_SESSION['user_id'];

    if ($favoriteCount == 0) {
        $addToFavouriteQuery = "INSERT INTO `favourites` (`user_id`, `book_id`) VALUES (?, ?)";
        $addstmt = mysqli_prepare($conn, $addToFavouriteQuery);
        mysqli_stmt_bind_param($addstmt, "ii", $userId, $bookId);

        if (mysqli_stmt_execute($addstmt)) {
            $book_name = $row['book_name'];
            header("Location: BookDetail.php?id=" . $bookId . "&page=1");
            // exit();
        } else {
            $_SESSION['favorite_operation'] = false;
            $error = mysqli_error($conn);
            error_log("Database Error: $error");
        }
    } else {
    }
} elseif (isset($_POST['unfavourite'])) {
    $bookId = $_GET['id'];
    $userId = $_SESSION['user_id'];

    $removeFavouriteQuery = "DELETE FROM favourites WHERE user_id = ? AND book_id = ?";
    $removestmt = mysqli_prepare($conn, $removeFavouriteQuery);
    mysqli_stmt_bind_param($removestmt, "ii", $userId, $bookId);

    if (mysqli_stmt_execute($removestmt)) {
        $book_name = $row['book_name'];
        header("Location: BookDetail.php?id=" . $bookId . "&page=1");
        exit();
    } else {
        $_SESSION['favorite_operation'] = false;
        $error = mysqli_error($conn);
        error_log("Database Error: $error");
    }
}

if (isset($_POST["submit"])) {
    $userId = $_SESSION["user_id"];
    $rating = $_POST["rating"];
    $comment = $_POST["comment"];

    // Check if any of the fields are empty
    if (empty($rating) || empty($comment)) {

    } else {
        $submitReviewQuery = "INSERT INTO `reviews`(`book_id`, `user_id`, `rating`, `comment`) VALUES(?, ?, ?, ?)";
        $submitReview = mysqli_prepare($conn, $submitReviewQuery);

        if ($submitReview) {
            mysqli_stmt_bind_param($submitReview, 'iiis', $bookId, $userId, $rating, $comment);

            if (mysqli_stmt_execute($submitReview)) {
                $_SESSION['review_operation'] = true;
                header("Location: BookDetail.php?id=" . $bookId . "&page=1");
                // exit();
            } else {
                $_SESSION['review_operation'] = false;
            }
        }
    }
}


if (isset($_GET['review_id']) && isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['review_id'];

    // Fetch the review details to check user_id
    $getReviewQuery = "SELECT * FROM reviews WHERE review_id = ?";
    $getReviewStmt = mysqli_prepare($conn, $getReviewQuery);
    mysqli_stmt_bind_param($getReviewStmt, "i", $id);
    mysqli_stmt_execute($getReviewStmt);
    $getReviewResult = mysqli_stmt_get_result($getReviewStmt);
    $reviewData = mysqli_fetch_assoc($getReviewResult);

    if ($reviewData['user_id'] == $_SESSION['user_id']) {
        $deleteQuery = "DELETE FROM reviews WHERE review_id = ?";
        $deleteStmt = mysqli_prepare($conn, $deleteQuery);
        mysqli_stmt_bind_param($deleteStmt, "i", $id);

        if (mysqli_stmt_execute($deleteStmt)) {
            $_SESSION['review_operation'] = "delete";
        } else {
            $_SESSION['review_operation'] = "FailDelete";

        }
    } else {
        $_SESSION['review_operation'] = "PermissionDelete";
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
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/form.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/input.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/icon.min.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/semantic.min.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/rating.min.css">
    <script src="Assets/plugins/sweetalert2/sweetalert2.all.js"></script>
    <script src="Assets/plugins/toastr/toastr.min.js"></script>
    <script src="Assets/js/SweetAlert.js"></script>
    <link rel="stylesheet" type="text/css" href="Css/Utility.css">
    <title>
        <?php echo $row['book_title'] ?>
    </title>
</head>

<body>

    <?php
    if (isset($_SESSION["review_operation"])) {
        if ($_SESSION["review_operation"] === true) {
            // echo '<script>testToast(' . json_encode("Review Posted") . ')</script>';
        } elseif ($_SESSION["review_operation"] === false) {
            echo '<script>failToast(' . json_encode("Post Review Failed") . ')</script>';
        }
    }

    if (isset($_SESSION['favorite_operation'])) {
        if ($_SESSION['favorite_operation'] === false) {
            echo '<script>failToast(' . json_encode("Add to favorite fail, please try again later") . ')</script>';
        } else {

        }
    }
    ?>

    <div class="detailBox">
        <div class="ui grid" style="width:99.7%; margin:auto;">
            <div class="four wide column" id="detailImg">
                <?php
                $bookCoverPath = $row["book_cover"];
                $fileName = basename($bookCoverPath);
                $bookCoverUrl = $baseURL . 'cover/' . $fileName;

                ?>
                <img src="<?= $bookCoverUrl ?>" alt="Book Cover" class="ui fluid image" id="bookCover">
            </div>
            <div class="twelve wide column">
                <h1 class="" style="font-size:50px;">
                    <?php echo $row['book_title'] ?>
                </h1>
                <hr style="width:100%; border:2px solid #B4B4B3;">
                <div class="description">
                    <p>
                        <?php echo $row['book_description'] ?>
                    </p>
                </div>

                <hr style="width:100%; border:2px solid #B4B4B3; margin-bottom:50px;">

                <div class="detailInfo">
                    <div class="info">
                        <span class="infoTitle">Author</span>
                        <p class="infomation">
                            <?php echo $row['book_author'] ?>
                        </p>
                    </div>

                    <div class="info">
                        <span class="infoTitle">Public Date</span>
                        <p class="infomation">
                            <?php echo $row['book_public_date'] ?>
                        </p>
                    </div>

                    <div class="info">
                        <span class="infoTitle">Language</span>
                        <p class="infomation">
                            <?php echo $row['language_name'] ?>
                        </p>
                    </div>

                    <div class="info">
                        <span class="infoTitle">Total View</span>
                        <p class="infomation">
                            <?php echo $row['total_views'] ?>
                        </p>
                    </div>

                    <div class="info">
                        <span class="infoTitle">Category</span>
                        <p class="infomation">
                            <?php echo $row['category_name'] ?>
                        </p>
                    </div>
                </div>

                <div class="ui buttons" id="detailButton">
                    <form id="watchNowForm" action="Book.php?id=<?php echo $bookId ?>" method="post">
                        <button class="ui black button" type="submit">Watch Now</button>
                    </form>
                    <form id="favoriteForm" action="BookDetail.php?id=<?php echo $bookId ?>" method="post">
                        <button id="favoriteButton" class="ui button" type="submit" name="favourite"
                            value="favourite"></button>
                    </form>
                </div>

            </div>

            <hr style="width:100%; border:2px solid #000; margin:25px 0px;">


        </div>


        <div class="commentInfo">
            <div class="reviewTitleBox">
                <div class="flex-container">
                    <h2 class="" style="font-size: 40px; margin: 0;">Review</h2>
                    <div class="overall-rating q-ml-md q-mt-sm" style="color: #7D7C7C; font-weight: 900;">
                        <div class="ui yellow disabled rating" data-rating="<?= $row['overall_rating'] ?>"
                            data-max-rating="5"></div>
                        <?php echo number_format($row['overall_rating'], 1); ?>
                    </div>

                    <div class="spacer"></div>
                    <button class="ui black button" id="showButton">Add Review</button>
                </div>
            </div>


            <div class="ui items">
                <?php if ($totalReviews > 0) {
                    while ($rowReview = mysqli_fetch_assoc($reviewResult)) {
                        ?>
                        <div class="item" id="userComment">
                            <div class="content">

                                <div class="ui comments">
                                    <div class="comment">
                                        <a class="avatar" id="avatarImg">
                                            <img
                                                src="<?php echo $rowReview['user_profilepicture'] ? $rowReview['user_profilepicture'] : '../ProfilePic/tom.jpg'; ?>">
                                        </a>
                                        <div class="content" style="margin:0px 60px;">
                                            <a class="author" style="font-size:20px;">
                                                <?= $rowReview['user_name'] ?>
                                            </a>
                                            <div class="metadata">
                                                <div class="date" style="font-size: 15px; color: #7D7C7C;">
                                                    <?php
                                                    $datePosted = $rowReview['date_posted'];
                                                    $formattedDate = date('Y-m-d H:i', strtotime($datePosted));
                                                    echo $formattedDate;
                                                    ?>
                                                </div>
                                                <div class="meta">
                                                    <div class="ui yellow disabled rating"
                                                        data-rating="<?= $rowReview['rating'] ?>" data-max-rating="5"></div>
                                                </div>
                                            </div>

                                            <div class="text">
                                                <?= $rowReview['comment'] ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if ($rowReview['user_id'] == $_SESSION['user_id']) {
                                ?>
                                <a class="btn btn-danger btn-sm" style="float:right"
                                    href="BookDetail.   ?id=<?php echo $bookId ?>&page=1&review_id=<?= $rowReview['review_id'] ?>&action=delete"
                                    onclick="handleDeleteClick(event, <?= $rowReview['review_id'] ?>)">
                                    <i class="trash icon" style="color: red;"></i>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="message">No reviews yet for this book.</div>
                <?php } ?>


            </div>

            <?php if ($totalReviews > 0) { ?>
                <div class="ui pagination menu" id="detailPagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                        <a class="item <?php echo $i === $page ? 'active' : ''; ?>"
                            href="?id=<?php echo $bookId; ?>&page=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php } ?>
                </div>
            <?php } ?>




        </div>
    </div>


    <div class="addCommentBox" id="addCommentBox">
        <div class="addForm">
            <h2 class="ui header">Add Review</h2>
            <form class="" action="BookDetail.php?id=<?php echo $bookId ?>&page=1" method="POST">

                <div>
                    <select id="ratingForm" name="rating">
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Very Good</option>
                        <option value="3">3 - Good</option>
                        <option value="2">2 - Fair</option>
                        <option value="1">1 - Poor</option>
                    </select>
                </div>

                <div class="ui form" style="margin-bottom:10px;">
                    <label>Comment</label>
                    <textarea required rows="2" name="comment" style="border:3px solid #000;background: transparent;"
                        placeholder="Enter your review comment"></textarea>
                </div>
                <button class="ui black button" style="width:100%;" type="submit" name="submit">Post</button>
            </form>

        </div>
    </div>
    </div>
    </div>

    <div style="height:10px;"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.ui.rating').rating({
                maxRating: 5,
            });

            checkFavoriteStatus();

            function checkFavoriteStatus() {
                var userId = <?php echo $_SESSION['user_id']; ?>;
                var bookId = <?php echo $bookId; ?>;

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
                            button.removeAttr('id').attr('id', 'activeFavoriteButton');
                            button.empty().append('<i class="heart icon"></i>');
                            button.attr('name', 'unfavourite');
                            button.attr('value', 'unfavourite');
                        } else {
                            button.removeAttr('id').attr('id', 'favoriteButton');
                            button.empty().append('<i class="heart outline icon"></i>');
                            button.attr('name', 'favourite');
                            button.attr('value', 'favourite');
                        }
                    },

                    error: function (xhr, status, error) {
                        console.log('AJAX error: ' + error);
                    }
                });
            }
        });

        function handleDeleteClick(event, reviewId) {
            event.preventDefault();

            // Show SweetAlert confirmation
            swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this\!',
                icon: 'warning',
                width: 300,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                reverseButtons: true,
                confirmButtonColor: "#E81D1D",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `../Admin/Ajax/DeleteReview.php?id=${reviewId}&action=delete`,
                        type: 'GET',
                        dataType: 'json',
                        success: function (response) {
                            if (response && response.success) {
                                swal.fire(
                                    'Deleted',
                                    'Your review has been deleted.',
                                    'success'
                                );
                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            } else {
                                swal.fire(
                                    'Error',
                                    'Failed to delete the review. Check the console for more details.',
                                    'error'
                                );
                            }
                        },
                        error: function (xhr, status, error) {
                            swal.fire(
                                'Error',
                                'Failed to delete the review. Check the console for more details.',
                                'error'
                            );
                        }
                    });
                }
            });
        }


        const showButton = document.getElementById('showButton');
        const addCommentBox = document.getElementById('addCommentBox');
        const addForm = document.querySelector('.addForm');

        // Initially hide the comment box
        addCommentBox.style.opacity = '0';
        addCommentBox.style.pointerEvents = 'none'; // disable pointer events

        showButton.addEventListener('click', function () {
            if (addCommentBox.style.opacity === "0") {
                addCommentBox.style.opacity = "1";
                addCommentBox.style.pointerEvents = 'auto'; // enable pointer events when shown
            } else {
                addCommentBox.style.opacity = "0";
                addCommentBox.style.pointerEvents = 'none'; // disable pointer events when hidden
            }
        });

        // Close comment box when clicking outside of it
        document.addEventListener('click', function (event) {
            if (!addForm.contains(event.target) && event.target !== showButton) {
                addCommentBox.style.opacity = "0";
                addCommentBox.style.pointerEvents = 'none';
            }
        });


    </script>
    <script src="../Fomantic-ui/dist/semantic.min.js"></script>
    <script src="../Fomantic-ui/dist/components/form.js"></script>
    <script src="../Fomantic-ui/dist/components/transition.js"></script>
    <script src="../Fomantic-ui/dist/components/rating.js"></script>
</body>

</html>

<style>
        .title{
        color:#000 !important;
    }
.navHref{
    color:#000 !important;
}
    .ui.comments .comment .text {
        width: 1100px
    }

    .swal2-styled.swal2-confirm:focus {
        box-shadow: none;
    }

    .lboxcss {
        width: 100%;
        position: relative;
        height: 60px;
        overflow: hidden;
        margin: 10px 0px;
    }

    .lboxcss .lbox-input {
        width: 100%;
        height: 100%;
        color: #000;
        padding-top: 20px;
        border: none;
        background: transparent;
    }

    .lboxcss .lbox-input-wrapper {
        display: flex;
    }

    .lboxcss .lbox-input-wrapper .icon {
        margin-left: 5px;
    }

    .lboxcss label {
        position: absolute;
        bottom: 0px;
        left: 0px;
        width: 100%;
        height: 100%;
        pointer-events: none;
        border-bottom: 1px solid grey;
    }

    .lboxcss label::after {
        content: "";
        position: absolute;
        bottom: -1px;
        left: 0px;
        width: 100%;
        height: 100%;
        border-bottom: 3px solid #000;
        transform: translateX(-100%);
        transition: all 0.3s ease;
    }

    .content-name {
        position: absolute;
        bottom: 0px;
        left: 0px;
        padding-bottom: 5px;
        transition: all 0.3s ease;
    }

    .lboxcss .lbox-input:focus {
        outline: none;
    }

    .lboxcss .lbox-input:focus+.label-name .content-name,
    .lboxcss .lbox-input:valid+.label-name .content-name {
        transform: translateY(-150%);
        font-size: 14px;
        left: 0px;
        color: #000;
    }

    .lboxcss .lbox-input:focus+.label-name::after,
    .lboxcss .lbox-input:valid+.label-name::after {
        transform: translateX(0%);
    }

    #showPasswordButton {
        background: transparent;
        border: 0px;
        margin: 35px 0px;
        position: absolute;
        right: 0;
    }


    .lboxcss .lbox-input-wrapper .lbox-input {
        flex: 1;
    }

    .lboxcss .lbox-input-wrapper .icon {
        margin-left: 5px;
    }



    .addCommentBox {
        background: rgb(0, 0, 0, 0.8);
        position: fixed;
        z-index: 120;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        transition: opacity 0.2s;
    }

    .addForm {
        background: #FFFBF5;
        width: 60%;
        margin: auto;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 20px;
        border-radius: 10px;
    }

    #ratingForm {
        width: 100%;
        font-size: 15px;
        padding: 10px;
        background: transparent;
        border: 0;
        border: 3px solid #000;
        border-radius: 5px;
        margin-bottom: 15px
    }

    #ratingForm option {
        background: #FFFBF5;
        color: #000;
    }

    #ratingForm option:hover {
        background: #fff;
        color: #fff;
    }

    #bookCover {
        background-size: cover;
        object-fit: cover;
        height: 100%;
    }

    .detailBox {
        background: #FFFBF5;
        width: 90%;
        margin: 100px auto;
        padding: 20px;
        border: 4px solid #000;
        border-radius: 20px;
    }

    #detailImg {
        height: 500px;
        width: 250px;
        padding: 0;
        border: 5px solid #000;
        border-radius: 10px;
        overflow: hidden;
    }

    .detailInfo {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        grid-gap: 20px;
    }

    .detailInfo .info {
        margin-bottom: 30px;
    }

    .detailInfo .info .infoTitle {
        font-size: 25px;
        font-weight: 900;
    }

    .detailInfo .info .infomation {
        color: #7D7C7C;
        font-weight: 900;
    }

    .description {
        /* height:350px; */
    }

    #detailButton {
        position: absolute;
        bottom: 0;
        width: 99.2%;
    }

    #detailButton form {
        width: 50%;
        margin-right: 5px;
    }

    #detailButton button {
        width: 100%;
    }

    #detailButton #favoriteForm {
        /* background:#eee; */
        width: 5.5%;

    }

    #detailButton #favoriteButton {
        /* width:1%; */
        background: #7e7e7e;
        color: #fff;
        size: 1.5rem;
    }

    #detailButton #activeFavoriteButton {
        /* width:1%; */
        background: red;
        color: #fff;
        size: 1.5rem;
        /* box-shadow:3px 3px grey; */
    }

    .reviewTitleBox {
        display: flex;
        justify-content: space-between;
    }

    .commentInfo {
        margin-top: 0px;
        width: 100%;
    }

    .flex-container {
        display: flex;
        align-items: center;
        width: 100%;
    }

    .spacer {
        flex-grow: 1;
    }

    #userComment {
        background: #F7EFE5;
        border: 4px solid #000;
        border-radius: 10px;
        padding: 20px;
    }

    #detailPagination {
        background: #F7EFE5;
        border-radius: 5px;
        margin: auto;
    }

    #avatarImg img {
        border-radius: 5px;
        object-fit: cover;
        border-radius: 50%;
        height: 45px;
        width: 45px;
    }
</style>
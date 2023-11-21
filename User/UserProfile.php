<?php
include_once('../db.php');
include_once('NavigationBar.php');

$user_id = $_SESSION['user_id'];

$username = $_SESSION['user_name'];
$email = $_SESSION['user_email'];
$contact = $_SESSION['user_contact'];

$favoriteList = "SELECT f.*, b.*
FROM favourites AS f
INNER JOIN book AS b ON f.book_id = b.book_id
WHERE f.user_id = ? LIMIT 3;";
$favoritestmt = mysqli_prepare($conn, $favoriteList);
mysqli_stmt_bind_param($favoritestmt, "i", $user_id);
mysqli_stmt_execute($favoritestmt);
$favoriteresult = mysqli_stmt_get_result($favoritestmt);



$watchRecord = "SELECT w.*, b.*
FROM watch_record AS w
INNER JOIN book AS b ON w.book_id = b.book_id
WHERE w.user_id = ? LIMIT 3;";
$recordStmt = mysqli_prepare($conn, $watchRecord);
mysqli_stmt_bind_param($recordStmt, "i", $user_id);
mysqli_stmt_execute($recordStmt);
$recordResult = mysqli_stmt_get_result($recordStmt);



$UserProfile = "SELECT * FROM `user` WHERE `user_id` = ?";
$stmt = mysqli_prepare($conn, $UserProfile);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);
mysqli_close($conn);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/semantic.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"
        integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"
        integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Your Profile</title>
</head>

<body>
    <div class="empty"></div>
    <div class="user-profile">

        <div class="user-info-box">
            <div class="user-image">
                <img src="<?php echo $row['user_profilepicture'] ? $row['user_profilepicture'] : '../ProfilePic/tom.jpg'; ?>"
                    class="user-pic" alt="profilepic">
                <img src="<?php echo $row['user_profilebackground'] ? $row['user_profilebackground'] : '../BackgroundPic/pyh.jpg'; ?>"
                    class="user-background" alt="background">
            </div>
            <div class="empty2">
                <p>
                    <?php echo $row['user_name']; ?>
                </p>
            </div>
            <div class="user-info">
                <p>Email:
                    <?php echo $row['user_email']; ?>
                </p>
                <p>Contact:
                    <?php echo $row['user_contact']; ?>
                </p>
                <p>Join date:
                    <?php echo $row['user_signupdate']; ?>
                </p>

                

                 <div>
                    
                 </div>

                 <div style="position: absolute; bottom:10px; width:50%;">
                <form action="EditProfile.php" method="get">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    <input type="submit" class="manage-profile ui black button" value="Manage your profile"><br>
                </form>
                <a class="change-pass ui red button" href="ChangePassword.php?user_id=<?php echo $user_id; ?>"
                    style="text-decoration: none;">
                    Change Password
                </a>
                 </div>

            </div>
        </div>

        <div class="user-book-info">
            <div class="favorite">
                <span class="favorite-title">FAVORITE</span>
                <span class="view-more"><a href="Favorites.php" class="view-more">View More</a></span>
                <div class="favorite-book">
                    <?php
                    while ($row = mysqli_fetch_assoc($favoriteresult)) {
                        echo '<div class="smallCover">';
                        echo '<div class="small-linear-bg"></div>';
                        echo '<p class="book-title">' . $row['book_title'] . '</p>';
                        echo '<button type="button" class="small-hidden-button" onclick="location.href=\'BookDetail.php?id=' . $row['book_id'] . '&page=1\'">View Detail</button>';
                        echo '<img class="book-image" src="' . $row['book_cover'] . '" alt="Book Cover">';
                        echo '</div>';
                    }
                    ?>
                </div>


                <div class="favorite" style="margin:30px 0px;">
                    <span class="favorite-title">Watch Record</span>
                    <span class="view-more"><a href="WatchRecord.php" class="view-more">View More</a></span>
                    <div class="favorite-book">
                        <?php
                        while ($row = mysqli_fetch_assoc($recordResult)) {
                            echo '<div class="smallCover">';
                            echo '<div class="small-linear-bg"></div>';
                            echo '<p class="book-title">' . $row['book_title'] . '</p>';
                            echo '<button type="button" class="small-hidden-button" onclick="location.href=\'BookDetail.php?id=' . $row['book_id'] . '&page=1\'">View Detail</button>';
                            echo '<img class="book-image" src="' . $row['book_cover'] . '" alt="Book Cover">';
                            echo '</div>';
                            // You can display other columns from the result as well
                        }
                        ?>
                    </div>


                </div>
            </div>
        </div>
        


        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"
            integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>

</html>

<script src="../Fomantic-ui/dist/semantic.min.js"></script>

<style>
    .empty {
        height: 100px;
        width: 100%;
    }

    .empty2 {
        height: 100px;
        width: 84%;
    }

    .empty2 p {
        font-weight: 900;
        padding: 10px 250px;
        /* text-align:center; */
        font-size: 40px;
    }

    .user-profile {
        margin: 0px auto;
        display: flex;
        width: 96%;

    }

    .user-info-box {
        background: #FFFBF5;
        border: 4px solid #000;
        border-radius: 20px;
        width: 48%;
        padding: 0px 0px;
        margin: 0px 15px;
        overflow: hidden;
        /* height:610px; */
    }

    .user-image {
        height: 250px;
        overflow: hidden;
        border-bottom: 4px solid #000;
    }

    .user-background {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        object-fit: cover;
        filter: brightness(50%);
        z-index: 1;
    }

    .user-pic {
        background: #fff;
        height: 200px;
        width: 200px;
        border: 4px solid #000;
        border-radius: 50%;
        position: absolute;
        margin: 150px 30px;
        z-index: 2;
        object-fit: cover;
    }

    .user-info {
        /* position:absolute; */
        padding: 20px 20px;
        /* top:32%;
    width:46%; */
    }

    .user-info .manage-profile {
        width: 100%;
        margin: 10px 0px;
        padding: 10px;
        border-radius: 7px;
        border: 0px;
    }

    .user-info .change-pass {
        width: 100%;
        padding: 10px;
        border-radius: 7px;
        border: 0px;
    }

    .user-book-info {
        background: #FFFBF5;
        border: 4px solid #000;
        border-radius: 20px;
        width: 48%;
        padding: 0px 20px;
        position: relative;
    }

    .user-book-info .favorite-title {
        font-size: 20px;
        letter-spacing: 3px;
        font-weight: 900;
        padding: 0px 7px;
    }

    .user-book-info .view-more {
        float: right;
        font-weight:bold;
    }

    .favorite {
        margin: 20px 0px;
    }

    .favorite-book {
        margin: 20px 0px;
        display: flex;
    }

    .smallCover {
        height: 250px;
        width: 200px;
        margin: 5px 10px;
        border-radius: 10px;
        overflow: hidden;
        position: relative;
    }

    .small-linear-bg {
        background: linear-gradient(to top, black, transparent);
        position: absolute;
        height: 130px;
        width: 100%;
        border-radius: 10px;
        bottom: 0%;
        transition: 0.4s;
        /* z-index:2; */
    }

    .book-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        background-repeat: no-repeat;
        background-position: center;
        /* z-index:1; */
    }

    .book-title {
        color: #fff;
        position: absolute;
        bottom: -7%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 1;
        transition: 0.4s;
    }

    .small-hidden-button {
        background: transparent;
        padding: -10px 50px;
        height: 30px;
        width: 100px;
        font-size: 13px;
        position: absolute;
        border: 3px solid #fff;
        color: #fff;
        border-radius: 5px;
        top: 50%;
        /* 垂直居中 */
        left: 50%;
        /* 水平居中 */
        transform: translate(-50%, -50%);
        /* 用于水平和垂直居中 */
        z-index: 2;
        transition: 0.4s;
        opacity: 0;
        /* 初始化时隐藏按钮 */
    }

    .smallCover:hover .small-hidden-button {
        opacity: 1;
        /* 鼠标悬停时显示按钮 */
        display: inline;
    }

    .smallCover:hover .small-linear-bg {
        /* filter: brightness(50%); */
        height: 300px;
    }

    .smallCover:hover .book-title {
        opacity: 0;
        /* 鼠标悬停时标题不可见 */
    }

    .small-hidden-button:hover {
        background: #fff;
        color: #000;
    }
</style>
<?php
include_once('../db.php');
include_once("NavigationBar.php");

// 获取传递过来的作者名字参数
$authorName = $_GET['book_author']; // 这里需要进行适当的参数验证和准备工作

// 查询该作者的所有书籍
$authorBooksQuery = "SELECT * FROM book WHERE book_author = ?";
$stmt = mysqli_prepare($conn, $authorBooksQuery);
mysqli_stmt_bind_param($stmt, "s", $authorName);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>作者及其书籍</title>
</head>

<body>
    <!-- <h1>作者及其书籍</h1> -->

    <div class="AuthorDetail">
        <h2>
            <?php echo $authorName; ?>
        </h2>


        <div class="slider" id="bookList">
            <?php if (mysqli_num_rows($result) > 0) {
                while ($book = mysqli_fetch_assoc($result)) { ?>
                    <div class="book-cover">
                        <div class="linear-bg"></div>
                        <p class="book-title">
                            <?php echo $book['book_title']; ?>
                        </p>
                        <button class="hidden-button" onclick="redirectToBookDetails(<?= $row['book_id'] ?>)">View
                            Detail</button>
                        <img src="<?php echo $book['book_cover']; ?>" alt="<?php echo $book['book_title']; ?>"
                            class="book-image">
                    </div>
                <?php }
            } else { ?>
                <p>该作者暂无其他书籍</p>
            <?php } ?>
        </div>


</body>

</html>
<style>
    /* ...................................................................................................................... */
    /* no need add to main css */
    .title {
        color: #000 !important;
    }

    .navHref {
        color: #000 !important;
    }




    #bookList {
        width: 100%;
        height: 100%;
        /* margin-left: 430px; */
        display: flex;
        flex-wrap: wrap;
        /* justify-content: space-around; */
        margin: auto;
        margin-bottom: 100px;
        border-radius: 20px;
    }

    .book-cover {
        height: 400px;
        width: 300px;
        margin: 15px 15px;
        /* border: 5px solid #000; */
        border-radius: 20px;
        overflow: hidden;
        position: relative;
    }

    .linear-bg {
        background: linear-gradient(to top, black, transparent);
        position: absolute;
        height: 230px;
        width: 100%;
        border-radius: 10px;
        bottom: 0%;
        transition: 0.4s;
        z-index: 4;
    }

    .book-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        background-repeat: no-repeat;
        background-position: center;
        transition: 0.4s;
        z-index: 1;
    }

    .book-title {
        color: #fff;
        position: absolute;
        bottom: 3%;
        left: 5%;
        /* transform: translate(-50%, -50%); */
        transition: 0.4s;
        opacity: 1;
        font-weight: 900;
        z-index: 5;
    }

    .hidden-button {
        background: transparent;
        padding: 10px 30px;
        position: absolute;
        border: 3px solid #fff;
        color: #fff;
        border-radius: 10px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 6;
        transition: 0.4s;
        opacity: 0;
        cursor: pointer;
    }

    .book-cover:hover {
        filter: grayscale(0%);
    }

    .book-cover:hover .hidden-button {
        opacity: 1;
        display: inline;
    }

    .book-cover:hover .linear-bg {
        /* filter: brightness(50%); */
        height: 500px;
    }

    .book-cover:hover .book-title {
        opacity: 0;
    }

    .book-cover:hover .book-image {
        transform: scale(1.2);
    }

    .hidden-button:hover {
        background: #fff;
        color: #000;
    }

    /* ...................................................................................................................... */



    .AuthorDetail {
        margin: 100px 0px;
    }
</style>
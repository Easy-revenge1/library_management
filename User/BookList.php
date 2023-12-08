<?php
ob_start();
include_once("../db.php");
include_once("NavigationBar.php");

if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
    header("Location: UserLogin.php");
    exit();
  }

$bookListQuery = "SELECT * FROM book";
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


// language_query
$languageQuery = "SELECT language_id, language_name FROM language";
$languageResult = mysqli_query($conn, $languageQuery);

if (!$languageResult) {
    die("Error retrieving languages: " . mysqli_error($conn));
}


// category_query
$categoryQuery = "SELECT category_id, category_name FROM category";
$categoryResult = mysqli_query($conn, $categoryQuery);

if (!$categoryResult) {
    die("Error retrieving categories: " . mysqli_error($conn));
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
    <link rel="stylesheet" type="text/css" href="Css/Utility.css">
    <title>All Book</title>


</head>

<body style="margin-top: 70px;">

    <div class="bookContent">
        <div class="sideMenu">
            <input type="text" placeholder="Search.." class="searchInput" id="searchInput">

            <div class="ui selection dropdown dropDownSearch q-mb-md" id="languageDropdown">
                <input type="hidden" name="language">
                <i class="dropdown icon"></i>
                <div class="default text">Language</div>
                <div class="scrollhint menu">
                    <div class="item" data-value="">Select Language</div>

                    <?php
                    mysqli_data_seek($languageResult, 0);

                    while ($language = mysqli_fetch_assoc($languageResult)) {
                        echo '<div class="item" data-value="' . $language['language_id'] . '">' . $language['language_name'] . '</div>';
                    }
                    ?>
                </div>
            </div>

            <div class="ui selection dropdown dropDownSearch q-mb-md" id="categoryDropdown">
                <input type="hidden" name="category">
                <i class="dropdown icon"></i>
                <div class="default text">Select Category</div>
                <div class="scrollhint menu">
                    <div class="item" data-value="">Select Category</div>

                    <?php
                    mysqli_data_seek($categoryResult, 0);

                    while ($category = mysqli_fetch_assoc($categoryResult)) {
                        echo '<div class="item" data-value="' . $category['category_id'] . '">' . $category['category_name'] . '</div>';
                    }
                    ?>
                </div>
            </div>

            <div class="bookListSearch">
                <button class="ui black button" id="searchButton" style="width:88.5%; position: absolute; bottom: 35px;" type="submit">
                    <i class="ui search icon"></i> Search</button>

                <button class="ui black button" id="resetButton" style="width:88.5%; position: absolute; bottom: 85px;">
                    <i class="undo icon"></i> Reset</button>
            </div>
        </div>




        <div class="ui three column bookList" id="bookList">
            <?php

            if ($bookListStmt) {

                while ($row = mysqli_fetch_assoc($result)) {
                    $bookTitle = $row['book_title'];
                    $bookCover = $row['book_cover'];

                    echo '<div class="book-cover">';
                    echo '<div class="linear-bg"></div>';
                    echo '<p class="book-title">' . $bookTitle . '</p>';
                    echo '<button type="button" class="hidden-button" onclick="location.href=\'BookDetail.php?id=' . $row['book_id'] . '&page=1\'">View Detail</button>';
                    echo '<img class="book-image" src="' . $bookCover . '" alt="' . $bookTitle . '">';
                    echo '</div>';
                }
            } else {
                echo "Error executing the prepared statement: " . mysqli_stmt_error($bookListStmt);
            }

            ?>
            <div class="spacer" style="height:15px; width:100%;"></div>
        </div>
    </div>
</body>
<script src="../Fomantic-ui/dist/semantic.min.js"></script>

</html>
<script>
    $('.ui.dropDownSearch')
        .dropdown()
        ;
    $(document).ready(function () {
        $('#resetButton').on('click', function () {
            location.reload();
        });
        $('#searchButton').on('click', function () {
            var query = $('#searchInput').val().trim();
            var selectedLanguage = $('#languageDropdown').dropdown('get value');
            var selectedCategory = $('#categoryDropdown').dropdown('get value');

            selectedLanguage = selectedLanguage === '' ? null : selectedLanguage;
            selectedCategory = selectedCategory === '' ? null : selectedCategory;

            console.log('Query:', query);
            console.log('Selected Language:', selectedLanguage);
            console.log('Selected Category:', selectedCategory);

            $('#bookList').empty();

            $.ajax({
                url: 'Ajax/bookSearch.php',
                method: 'GET',
                data: {
                    query: query,
                    language: selectedLanguage !== null ? selectedLanguage : '',
                    category: selectedCategory !== null ? selectedCategory : ''
                },
                dataType: 'json',
                beforeSend: function () {
                    // You can show a loading indicator here if needed
                },
                success: function (data) {
                    if (data.length > 0) {
                        $.each(data, function (index, book) {
                            var bookCover = $('<div class="book-cover"></div>');
                            bookCover.append('<div class="linear-bg"></div>');
                            bookCover.append('<p class="book-title">' + book.book_title + '</p>');

                            // Dynamically create the button using JavaScript
                            var viewDetailButton = $('<button type="button" class="hidden-button">View Detail</button>');
                            viewDetailButton.on('click', function () {
                                location.href = 'BookDetail.php?id=' + book.book_id + '&page=1';
                            });
                            bookCover.append(viewDetailButton);

                            bookCover.append('<img class="book-image" src="../cover/' + book.book_cover + '" alt="Book Cover">');

                            $('#bookList').append(bookCover);
                        });
                    } else {
                        $('#bookList').append('<p class="NoMatching">No matching books found.</p>');
                    }
                },

                error: function (error) {
                    console.error('AJAX Error:', error);
                }
            });
        });
        $('#languageDropdown, #categoryDropdown').dropdown();

    });

</script>
<style>
    .title{
        color:#000 !important;
    }
.navHref{
    color:#000 !important;
}

 .NoMatching{
        color: #252525;
        position: absolute;
    top: 50%;
    left: 65%;
    transform: translate(-50%, -50%);
        font-size:20px;
        font-weight:500;
    }
    .bookListSearch {
        width: 100%;
        margin: auto;
    }

    .searchInput {
        background: transparent;
        width: 100%;
        padding: 8px;
        border-radius: 4px;
        border: 3px solid #000;
        margin-bottom: 10px;
    }

    .bookContent {
        display: flex;
        height: 100%;
        border-top: ;
    }

    #bookList {
        width: 100%;
        margin-left: 430px;
        display: flex;
        flex-wrap: wrap;
        /* justify-content: space-around; */
        /* margin: auto; */
    }

    /* .book-card {
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
        } */

    .sideMenu {
        position: fixed;
        /* margin: 15px 50px; */
        /* background: #FFFBF5; */
        height: 93%;
        width: 28%;
        border-right: 2px solid #A9A9A9;
        overflow: hidden;
        padding: 50px 20px;
        z-index: 1;
    }

    #categoryDropdown,
    #languageDropdown {
        width: 100%;
        background: transparent;
        border: 0px;
        border-bottom: 3px solid #000;
        border-radius: 0px;
    }

    #languageSelector {
        background: #FFFBF5;
        color: #252525;
        /* border:0px;
        border-bottom:3px solid #000; */
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

    .ui.selection.active.dropdown .menu {
        border-color: #FFFBF5 !important;
    }

    .ui.selection.dropdown:focus .menu {
        border-color: #FFFBF5 !important;
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

    .countBook {
        float: right;
        font-size: 23px;
        padding: 0px 10px;
    }

    .countNumber {
        color: #FF6C22;
        font-weight: bolder;
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
</style>
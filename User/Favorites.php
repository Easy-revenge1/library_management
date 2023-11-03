<?php
include_once("../db.php");
include_once("NavigationBar.php");

$userId = $_SESSION["user_id"];

$baseURL = "http://localhost/library_management/";

$bookmarkList = "SELECT favourites.*, book.*
FROM `favourites`
INNER JOIN `book` ON favourites.book_id = book.book_id
WHERE favourites.user_id = ?";
$stmt = mysqli_prepare($conn, $bookmarkList);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

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
    <h1>Favorite Items</h1>
    <ul>
        <div class="ui bookshelf">
        <?php while ($row = mysqli_fetch_array($result)) { ?>
            <?php
              $bookCoverPath = str_replace('..', '', $row["book_cover"]);
              $bookCoverUrl = $baseURL . $bookCoverPath;
              ?>
                <div class="ui book">
                    <div class="bookDetail">
                    <img src="<?= $bookCoverUrl ?>" alt="Book Cover" class="bookCover">
                        <h3><?= $row["book_title"] ?></h3>
                    </div>
                </div>
        <?php } ?>
        </div>
    </ul>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</body>

</html>

<script src="../Fomantic-ui/dist/semantic.min.js"></script>
<script src="../Fomantic-ui/dist/components/form.js"></script>
<script src="../Fomantic-ui/dist/components/transition.js"></script>
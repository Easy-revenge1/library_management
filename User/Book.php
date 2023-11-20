<?php
include_once("../db.php");

$bookId = $_GET['id'];
$userId = $_SESSION['user_id'];

$bookInfo = "SELECT * FROM `book` WHERE book_id = ?";
$stmt = mysqli_prepare($conn, $bookInfo);
$stmt->bind_param("s", $bookId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $filePath = $row['book_content'];
} else {
    die("Book not found");
}

$stmt->close();

$checkWatchRecordQuery = "SELECT * FROM `watch_record` WHERE `book_id` = ? AND `user_id` = ?";
$checkWatchRecordStmt = mysqli_prepare($conn, $checkWatchRecordQuery);
mysqli_stmt_bind_param($checkWatchRecordStmt, "ii", $bookId, $userId);
mysqli_stmt_execute($checkWatchRecordStmt);
$existingWatchRecord = mysqli_stmt_get_result($checkWatchRecordStmt);

if ($existingWatchRecord->num_rows > 0) {
    // If the user has already watched the book, update the timestamp
    $updateWatchRecordQuery = "UPDATE `watch_record` SET `watch_timestamp` = current_timestamp() WHERE `book_id` = ? AND `user_id` = ?";
    $updateWatchRecordStmt = mysqli_prepare($conn, $updateWatchRecordQuery);
    mysqli_stmt_bind_param($updateWatchRecordStmt, "ii", $bookId, $userId);
    mysqli_stmt_execute($updateWatchRecordStmt);
    mysqli_stmt_close($updateWatchRecordStmt);
} else {
    // If the user hasn't watched the book, insert a new record
    $insertWatchRecordQuery = "INSERT INTO `watch_record` (`book_id`, `user_id`) VALUES (?, ?)";
    $insertWatchRecordStmt = mysqli_prepare($conn, $insertWatchRecordQuery);
    mysqli_stmt_bind_param($insertWatchRecordStmt, "ii", $bookId, $userId);
    mysqli_stmt_execute($insertWatchRecordStmt);
    mysqli_stmt_close($insertWatchRecordStmt);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch</title>
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/semantic.min.css">
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
    <link rel="stylesheet" type="text/css" href="Css/Utility.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #222;
            color: #fff;
        }

        #pdf-container {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #FFF;
        }

        #pdf-object {
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #333;
            border: 4px solid #555;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
            overflow: hidden;
        }

        #pdf-object object {
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>
    <div id="pdf-container" class="ui container">
        <div id="pdf-object" class="ui raised segment">
            <object type="application/pdf" data="<?php echo $filePath; ?>" class="pdf-viewer">
                Your browser does not support embedded PDF files.
                You can <a href="<?php echo $filePath; ?>" download>download the PDF</a> instead.
            </object>
        </div>
    </div>

    <!-- Add Fomantic UI JS and jQuery CDN links -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>

<script src="../Fomantic-ui/dist/semantic.min.js"></script>
<script src="../Fomantic-ui/dist/components/form.js"></script>
<script src="../Fomantic-ui/dist/components/transition.js"></script>
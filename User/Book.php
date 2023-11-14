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

$WatchRecordInsert = "INSERT INTO `watch_record` (`book_id`, `user_id`) VALUES (?, ?)";
$watchrecordstmt = mysqli_prepare($conn, $WatchRecordInsert);

mysqli_stmt_bind_param($watchrecordstmt, "ii", $bookId, $userId);
mysqli_stmt_execute($watchrecordstmt);
mysqli_stmt_close($watchrecordstmt);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch</title>
    <!-- Add Fomantic UI CSS link -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/fomantic-ui@2.8.7/dist/semantic.min.css">
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

        html {
            --iron-icon-height: 20px;
            --iron-icon-width: 20px;
            --viewer-icon-ink-color: rgb(189, 189, 189);
            --viewer-pdf-toolbar-background-color: #7e7e7e;
            --viewer-text-input-selection-color: #7e7e7e;
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fomantic-ui@2.8.7/dist/semantic.min.js"></script>
</body>

</html>


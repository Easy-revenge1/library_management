<?php
include_once("db.php");

$bookId = $_GET['id'];

if (isset($_POST['submit'])) {
  $book_title = mysqli_real_escape_string($conn, $_POST['book_title']);
  $book_author = mysqli_real_escape_string($conn, $_POST['book_author']);
  $book_public_date = $_POST['book_public_date'];
  $book_language = mysqli_real_escape_string($conn, $_POST['book_language']);
  $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
  $book_status = mysqli_real_escape_string($conn, $_POST['book_status']);

  // Handle uploaded book content
  if (!empty($_FILES['book_content']['tmp_name'])) {
    $book_content = $_FILES['book_content']['tmp_name'];
    $book_content_path = "content/" . $_FILES['book_content']['name'];
    if (!move_uploaded_file($book_content, $book_content_path)) {
      die('Failed to move uploaded content');
    }
  } else {
    // Retrieve existing book content path if no new content is uploaded
    $contentQuery = "SELECT book_content FROM book WHERE book_id = ?";
    $contentStmt = mysqli_prepare($conn, $contentQuery);
    if ($contentStmt === false) {
      die('mysqli_prepare failed: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($contentStmt, 'i', $bookId);
    mysqli_stmt_execute($contentStmt);
    mysqli_stmt_store_result($contentStmt);
    mysqli_stmt_bind_result($contentStmt, $existingContentPath);
    mysqli_stmt_fetch($contentStmt);
    mysqli_stmt_free_result($contentStmt);
    $book_content_path = $existingContentPath;
  }

  // Handle uploaded book cover
  if (!empty($_FILES['book_cover']['tmp_name'])) {
    $book_cover = $_FILES['book_cover']['tmp_name'];
    $book_cover_path = "cover/" . $_FILES['book_cover']['name'];
    move_uploaded_file($book_cover, $book_cover_path);
  } else {
    // Retrieve existing book cover if no new cover is uploaded
    $coverQuery = "SELECT book_cover FROM book WHERE book_id = ?";
    $coverStmt = mysqli_prepare($conn, $coverQuery);
    if ($coverStmt === false) {
      die('mysqli_prepare failed: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($coverStmt, 'i', $bookId);
    mysqli_stmt_execute($coverStmt);
    mysqli_stmt_store_result($coverStmt);
    mysqli_stmt_bind_result($coverStmt, $existingCover);
    mysqli_stmt_fetch($coverStmt);
    mysqli_stmt_free_result($coverStmt);
    $book_cover_path = $existingCover;
  }

  echo $Update = "UPDATE book SET book_title=?, book_content=?, book_author=?, book_public_date=?, book_language=?, category_id=?, book_cover=?, Status=? WHERE book_id=?";
  $stmt = mysqli_prepare($conn, $Update);
  if ($stmt === false) {
    die('mysqli_prepare failed: ' . mysqli_error($conn));
  }
  mysqli_stmt_bind_param($stmt, 'sssssssis', $book_title, $book_content_path, $book_author, $book_public_date, $book_language, $category_id, $book_cover_path, $book_status, $bookId);
  mysqli_stmt_execute($stmt);
    if (mysqli_stmt_execute($stmt)) {
      echo "<script>window.location.href='book.php';</script>";
      exit;
    } else {
      echo "<script>alert('Update Failed');</script>";
    }
  }

  $query = "SELECT book.*, category.category_name, language.language_name, bookstatus.BookStatus
            FROM book
            INNER JOIN category ON book.category_id = category.category_id
            INNER JOIN language ON book.book_language = language.language_id
            INNER JOIN bookstatus ON book.Status = bookstatus.BookStatusId
            WHERE book.book_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $bookId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

$categoryQuery = "SELECT *FROM category";
$categoryResult = mysqli_query($conn, $categoryQuery);

$languageQuery = "SELECT * FROM language";
$languageResult = mysqli_query($conn, $languageQuery);

$statusQuery = "SELECT * FROM bookstatus";
$statusResult = mysqli_query($conn, $statusQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="fe.css">
    <title>DIGITAL LIBRARY</title>
</head>
<body>
<div class="topnav2">
 <div class="toptext">
 <span><a class="firstT" href="index_admin.php">DIGITAL</a></span>
  <span><a class="firstT2" href="index_admin.php">LIBRARY</a></span>
  <span class="firstT3">BOOK</span>
  <span class="firstT4">EDIT</span>
 </div>
 <div class="search-container">
    <form action="upload.php">
    <a href=""><i class="fa fa-user-circle-o"></i><?php echo $_SESSION["admin_name"]; ?></a>
    </form>
  </div>
</div>
 <div class="sidebar2">
  <a class="" href="index_admin.php">HOME</a>
  <a href="book.php">BOOK</a>
  <a href="user.php">USER</a>
  <a href="">ABOUT</a>
</div>
    <div class="uploadfc">
    <form action="edit.php?id=<?= $bookId ?>" method="POST" enctype="multipart/form-data">
        <button type="button" onclick="window.location.href='book.php'" class="bck"><i class="fa fa-arrow-left"></i></button>
            <div class="user-details">
                <div class="input-box">
                    <label class="details" for="">Title :</label>
                    <input class="ipt" type="text" name="book_title" value="<?= htmlspecialchars($row['book_title']) ?>">
                </div>
                <div class="input-box">
                    <label class="details" for="">Author :</label>
                    <input class="ipt" type="text" name="book_author" value="<?= htmlspecialchars($row['book_author']) ?>">
                </div>
                <div class="input-box">
                    <label class="details" for="">Cover :</label>
                    <input class="ipt" type="file" name="book_cover">
                </div>
                <div class="input-box">
                  <label class="details" for="">Content :</label>
                  <input class="ipt" type="file" name="book_content">
                </div>
                <div class="input-box">
                    <label class="details" for="">Language :</label>
                    <select class="ipt" name="book_language" class="form-control form-control-lg">
                        <?php while ($languageRow = mysqli_fetch_assoc($languageResult)) { ?>
                            <option value="<?= $languageRow['language_id'] ?>" <?= ($languageRow['language_id'] == $row['book_language']) ? 'selected' : '' ?>>
                                <?= $languageRow['language_name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="input-box">
                <label class="details" for="">Category :</label><br>
                <select class="ipt" name="category_id">
                <?php while ($categoryRow = mysqli_fetch_assoc($categoryResult)) { ?>
                    <option value="<?= $categoryRow['category_id'] ?>" <?= ($categoryRow['category_id'] == $row['category_id']) ? 'selected' : '' ?>>
                      <?= $categoryRow['category_name'] ?>
                    </option>
                  <?php } ?>
                </select>
                </div>
                <div class="input-box">
                    <label class="details" for="">Public Date :</label>
                    <input class="ipt" type="date" name="book_public_date" value="<?= $row['book_public_date'] ?>">
                </div>
                <div class="input-box">
                  <label class="details" for="">Status :</label>
                  <select class="ipt" name="book_status" class="form-control form-control-lg">
                    <?php while ($statusRow = mysqli_fetch_assoc($statusResult)) { ?>
                        <option value="<?= $statusRow['BookStatusId'] ?>" <?= ($statusRow['BookStatusId'] == $row['Status']) ? 'selected' : '' ?>>
                            <?= $statusRow['BookStatus'] ?>
                        </option>
                    <?php } ?>
                  </select>
              </div>
                <div class="button">
                    <button type="submit" value="submit" name="submit" class="smb">DONE</button>
                </div>
            </div>
            <div class="uppic" >
              <img src="<?php echo $row['book_cover']; ?>" alt="Failed">
            </div>
        </form>
    </div>
</body>
<style>
.uploadfc {
  background-color: #0d0d0d;
  border: 4px solid #0d0d0d;
  border-radius: 10px;
  transition: 0.4s;
  width: 83%;
  height: 600px;
  margin-left: 210px;
  margin-top: 65px;
  position: fixed;
  filter: opacity(0%);
  animation: uploadfcA 1s;
  animation-fill-mode: forwards;
}
@keyframes uploadfcA{
  0%{filter:opacity(0%);}
  100%{filter:opacity(100%);}
}
.uploadfc:hover{
  border:4px solid #66ff66;
}
.input-box{
  margin:10px 35px;
  font-size:17px;
  font-weight:normal;
  letter-spacing: 1px;
}
.user-details{
    position:fixed;
    width:38%;
    margin:45px 0px;
}
.details{
  letter-spacing:2px;
  color:#fff;
}
.input-box label{
    color:#fff;
}
.input-box input{
    color:#fff;
}
.title{
    text-align:center;
    font-size:30px;
    letter-spacing: 2px;
    font-weight:normal;
    padding:7px 0px;
}
.ttudl{
    width:95%;
    margin:auto;
}
.ipt{
    background-color:#1a1a1a;
    color:#fff;
    font-size:17px;
    width:98%;
    border-radius:4px;
    border:2px solid #1a1a1a;
    transition:0.4s;
}
.uploadfc .ipt:hover{
    border:2px solid #66ff66;
}
.input-box{
    margin:35px 35px;
    font-size:17px;
    font-weight:normal;
    letter-spacing: 1px;
}
.button{
  margin:20px 0px;
}
.smb{
    margin: 5px 0px;
    width:100%;
    background-color:#000;
    border:0px;
    color:#fff;
    transition:0.4s;
    border-radius:5px;
    padding:10px 80px;
}
.smb:hover{
    background-color:#66ff66;
    color:#000;
}
.bck{
    background-color:#0d0d0d;
    color:#777;
    border:0px;
    font-size:20px;
    margin:20px 20px;
    position:fixed;
    transition:0.4s;
}
.bck:hover{
    color:#fff;
}
.sidebar a:hover:not(.active) {
  color: #fff;
}

div.content {
  margin-left: 200px; 
  padding: 1px 16px;
  height: 1000px;
}

</style>
</html>

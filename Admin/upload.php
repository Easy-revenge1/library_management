<?php
include_once('../db.php');

$query1 = "SELECT * FROM category";
$result1 = mysqli_query($conn, $query1);

$query2 = "SELECT * FROM language";
$result2 = mysqli_query($conn, $query2);

if (isset($_FILES["book_cover"]) && isset($_FILES["PDF"])) {
  $tmpFilePath1 = $_FILES["book_cover"]["tmp_name"];
  $newFilePath1 = "../" . "cover/" . $_FILES["book_cover"]["name"];

  $tmpFilePath2 = $_FILES["PDF"]["tmp_name"];
  $newFilePath2 = "../" . "content/" . $_FILES["PDF"]["name"];

  $book_title = $_POST['book_title'];
  $book_author = $_POST['book_author'];
  $book_public_date = $_POST['book_public_date'];
  $book_language = $_POST['book_language'];
  $category_id = $_POST['category_id'];
  $date = date("Y/m/d");

  if (move_uploaded_file($tmpFilePath2, $newFilePath2) && move_uploaded_file($tmpFilePath1, $newFilePath1)) {
    // Sanitize the input values before inserting into the database
    $book_title = mysqli_real_escape_string($conn, $book_title);
    $book_author = mysqli_real_escape_string($conn, $book_author);
    $book_public_date = mysqli_real_escape_string($conn, $book_public_date);
    $book_language = mysqli_real_escape_string($conn, $book_language);
    $category_id = mysqli_real_escape_string($conn, $category_id);

    $query = "INSERT INTO `book` (book_title, book_cover, book_content, book_author, book_public_date, book_language, category_id, upload_date, Status) 
              VALUES ('$book_title', '$newFilePath1', '$newFilePath2', '$book_author', '$book_public_date', '$book_language', '$category_id', '$date', '1')";

    if (mysqli_query($conn, $query)) {
      echo "<script>window.location.href='book.php';</script>";
    } else {
      echo "<script>alert('Failed to Upload, please try again :(');</script>";
    }
  } else {
    echo "<script>alert('Failed to Upload, please try again :(');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/main.css">
  <title>DIGITAL LIBRARY</title>
</head>

<body>
  <div class="topnav2">
    <div class="toptext">
      <span><a class="firstT" href="index_admin.php">DIGITAL</a></span>
      <span><a class="firstT2" href="index_admin.php">LIBRARY</a></span>
      <span><a class="firstT3" href="">BOOK</a></span>
      <span class="firstT4">ADD</span>
    </div>
    <div class="search-container">
      <a href=""><i class="fa fa-user-circle-o"></i><?php echo $_SESSION["admin_name"]; ?></a>
    </div>
  </div>

  <div class="sidebar2">
    <a class="" href="index_admin.php">HOME</a>
    <a href="book.php">BOOK</a>
    <a href="user.php">USER</a>
    <a href="">ABOUT</a>
  </div>

  <div class="uploadfc">
    <form action="upload.php" method="POST" enctype="multipart/form-data">
      <button type="button" onclick="window.location.href='book.php'" class="bck"><i class="fa fa-arrow-left"></i></button>
      <div class="user-details">
        <div class="input-box">
          <span class="details">Book Title :</span>
          <input class="ipt" type="text" placeholder="Book Title" name="book_title" required>
        </div>
        <div class="input-box">
          <span class="details">Book Cover :</span>
          <input class="" type="file" placeholder="Book Cover" name="book_cover" id="img" required>
        </div>
        <div class="input-box">
          <label for="myfile">Book Content :</label>
          <input type="file" class="" name="PDF" required>
        </div>
        <div class="input-box">
          <span class="details">Book Author :</span>
          <input class="ipt" type="text" placeholder="Book Author" name="book_author" required>
        </div>
        <div class="input-box">
          <span class="details">Book Public Date :</span>
          <input class="ipt" type="date" name="book_public_date" required>
        </div>
        <div class="input-box">
          <span class="details">Book Language :</span>
          <select class="slt" name="book_language" class="form-control form-control-lg">
            <?php while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)) { ?>
              <option value="<?php echo $row['language_id']; ?>">
                <?php echo $row["language_name"]; ?>
              </option>
            <?php } ?>
          </select>
        </div>
        <div class="input-box">
          <label for="category_id">Choose a Category ID :</label>
          <select class="slt" name="category_id" class="form-control form-control-lg">
            <?php while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)) { ?>
              <option value="<?php echo $row['category_id']; ?>">
                <?php echo $row["category_name"]; ?>
              </option>
            <?php } ?>
          </select>
        </div>
        <div class="button">
          <button type="submit" value="submit" name="submit" class="smb">DONE</button>
        </div>
      </div>
    </form>
    <div class="uppic" id="selectedBanner"></div>
  </div>
</body>
</html>

<style>
 .uploadfc{
  background-color:#0d0d0d;
  border:4px solid #0d0d0d;
  border-radius:10px;
  transition:0.4s;
  height:530px;
  width:83%;
  margin-left:210px;
  margin-top:65px;
  position:fixed;
  filter:opacity(0%);
  animation: uploadfcA 1s;
  animation-fill-mode: forwards;
}
@keyframes uploadfcA{
  0%{filter:opacity(0%);}
  100%{filter:opacity(100%);}
}
.uploadfc:hover , .uppic-user img:hover{
  border:4px solid #66ff66;
}
.input-box{
  margin:15px 35px;
  font-size:17px;
  font-weight:normal;
  letter-spacing: 1px;
}
.user-details{
    position:fixed;
    width:38%;
    margin:40px 15px;
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
.input-box .slt{
    background-color:#1a1a1a;
    color:#fff;
    font-size:17px;
    width:100%;
    border-radius:4px;
    border:2px solid #1a1a1a;
    transition:0.4s;
}
.input-box .slt:hover{
  border:2px solid #66ff66;
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
.uppic{
  background-color:#000;
  height:100%;
  width:60%;
  border-radius:6px;
  float:right;
  margin-left:5px;
  display:block;
}
.uppic img{
  height:100%;
  width:100%;
  border-radius:6px;
  background-size: auto;
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

<script>
 var selDiv = "";
      var storedFiles = [];
      $(document).ready(function () {
        $("#img").on("change", handleFileSelect);
        selDiv = $("#selectedBanner");
      });

      function handleFileSelect(e) {
        var files = e.target.files;
        var filesArr = Array.prototype.slice.call(files);
        filesArr.forEach(function (f) {
          if (!f.type.match("image.*")) {
            return;
          }
          storedFiles.push(f);

          var reader = new FileReader();
          reader.onload = function (e) {
            var html =
              '<img src="' +
              e.target.result +
              "\" data-file='" +
              f.name +
              "alt='Category Image'>";
            selDiv.html(html);
          };
          reader.readAsDataURL(f);
        });
      }
    

  function handleFileSelect(e) {
    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    filesArr.forEach(function(f) {
      if (!f.type.match("image.*")) {
        return;
      }
      storedFiles.push(f);

      var reader = new FileReader();
      reader.onload = function(e) {
        var html =
          '<img src="' +
          e.target.result +
          "\" data-file='" +
          f.name +
          "alt='Category Image'>";
        selDiv.html(html);
      };
      reader.readAsDataURL(f);
    });
  }
</script>
</html>
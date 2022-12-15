<?php
include_once('db.php');

$SQL = "SELECT * FROM category";
$query 	= mysqli_query($conn,$SQL);

if(isset($_POST['submit'])){
	$book_title=$_POST['book_title'];
	$book_name=$_POST['book_name'];
	$book_author=$_POST['book_author'];
    $book_public_date=$_POST['book_public_date'];
    $book_language=$_POST['book_language'];
    $category_id=$_POST['category_id'];
    $date = date("Y/m/d");
	    
	$query="INSERT INTO book (book_title,book_name,book_author,book_public_date,book_language,category_id, upload_date) VALUES ('$book_title','$book_name','$book_author','$book_public_date','$book_language','$category_id', '$date')";
	if($result=mysqli_query($conn,$query)){
	echo "<script>
	alert('Successfully Add.');</script>";
}else{
	echo "<script>window.location.href ='upload.php';
	alert('Failed Add.');</script>";    
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>DIGITAL LIBRARY</title>
<style>
body {
    background-color:#262626;
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
    color:#fff;
}
.topnav{
    background-color:#000;#e6e6e6
    opacity:100%;
    position:fixed;
    overflow: hidden;
    transition: 0.4s;
    height:58px;
    width:100%;
    z-index: 9999;
}
.toptext{
    text-align:;
    padding:20px ;
    transition:0.4s;
}
.stext{
    transition:0.5s;
    color:#737373;
    padding:35px ;
    text-decoration:none;
}
.stext:hover{
  color:#fff;
}
.firstT{
    color: #fff;
    text-decoration: none;
    letter-spacing: 2px;
    padding:0px;
}
.firstT2{
    color: #999;
    text-decoration: none;
    letter-spacing: 2px;
    padding:0px;
}
.firstT3{
    color: #fff;
    text-decoration: none;
    letter-spacing: 2px;
    padding:0px 7px;
    border-left:1px solid #999  ;
}
.logo{
  margin-left:0px;
}
.topnav .search-container {
  position: absolute;
  top:17px;
  left:1080px;
}
.topnav input[type=text] {
  padding: 0px;
  transition:0.4s;
  margin-top: 0px;
  font-size: 17px;
  border: none;
  background-color:#000; 
  border:0px; 
  border-bottom:2px solid #737373; 
  color:#fff;
}
.topnav input[type=text]:hover{
  border-bottom:2px solid #fff;
}
.topnav .search-container button {
  float: right;
  transition:0.3s;
  padding: 3px 10px;
  margin-top: 0px;
  margin-right: 16px;
  background: #000;
  color:#999;
  font-size: px;
  border: none;
  cursor: pointer;
}

.topnav .search-container button:hover {
  color:#fff;
}
@media screen and (max-width: 600px) {
  .topnav .search-container {
    float: none;
  }
  .topnav a, .topnav input[type=text], .topnav .search-container button {
    float: none;
    display: block;
    text-align: left;
    width: 100%;
    margin: 0;
    padding: 14px;
  }
  .topnav input[type=text] {
    background-color:#000;
  }
}
.idx{
  margin-left:210px;
  margin-top:10px;
  width:1120px;
}
.idx2{
  margin-left:780px;
  float:left;
  height:850px;
  width:560px;
}
.htext{
  color:#fff;
  font-size:50px;
  text-align:center;
  text-decoration:none;
}
.sidebar {
  margin: 0;
  padding: 0;
  width: 200px;
  margin-top:58px;
  background-color: #0d0d0d;
  position: fixed;
  height: 100%;
  overflow: auto;
}

.sidebar a {
  display: block;
  font-size:20px;
  transition:0.4s;
  color: #737373;
  padding: 20px;
  text-decoration: none;
}


.sidebar a:hover:not(.active) {
  color: #fff;
}

div.content {
  margin-left: 200px;
  padding: 1px 16px;
  height: 1000px;
}

@media screen and (max-width: 700px) {
  .sidebar {
    width: 100%;
    height: auto;
    position: relative;
  }
  .sidebar a {float: left;}
  div.content {margin-left: 0;}
}
.uploadfc{
    background-color:#0d0d0d;
    border:4px solid #0d0d0d;
    border-radius:10px;
    transition:0.4s;
    box-shadow:;
    height:500px;
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
.uploadfc:hover{
    border:4px solid #66ff66;
}
.user-details{
    position:fixed;
    width:38%;
}
.details{
  letter-spacing:2px;
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
    font-size:17px;
    width:98%;
    color:#fff;
    border-radius:4px;
    border:2px solid #333;
    transition:0.4s;
}

.uploadfc .ipt:hover{
    border:2px solid #66ff66;
}
.input-box{
    margin:30px 35px;
    font-size:17px;
    font-weight:normal;
    letter-spacing: 1px;
}
.smb{
    margin: 30px 0px;
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
</style>
</head>
<body>
<div class="topnav">
 <div class="toptext">
 <span><a class="firstT" href="index_admin.php">DIGITAL</a></span>
  <span><a class="firstT2" href="index_admin.php">LIBRARY</a></span>
  <span class="firstT3">UPLOAD </span>
 </div>
 <div class="search-container">
    <form action="upload.php">
      <input type="text" placeholder="Search.." name="search">
      <button type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>
</div>
 <div class="sidebar">
 <a class="" href="index_admin.php">HOME</a>
  <a href="book.php">BOOK</a>
  <a href="upload.php">UPLOAD</a>
  <a href="user.php">USER</a>
  <a href="">ABOUT</a>
</div>
    <div class="uploadfc">
        <form action="upload.php" method="POST">
            <div class="user-details">
                <div class="input-box">
                    <span class="details">Title :</span>
                    <input class="ipt" type="text" placeholder="Book Title" name="book_title" required>
                </div>
                <div class="input-box">
                    <label for="myfile">Name :</label>
                    <input type="file" id="img" name="book_name" required>
                </div>
                <div class="input-box">
                    <span class="details">Author :</span>
                    <input class="ipt" type="text" placeholder="Book Author" name="book_author" required>
                </div>
                <div class="input-box">
                    <span class="details">Public Date :</span>
                    <input class="ipt" type="date" name="book_public_date" required>
                </div>
                <div class="input-box">
                    <span class="details">Language :</span>
                    <input class="ipt" type="text" placeholder="Book Language"  name="book_language" required>
                </div>
                <div class="input-box">
                    <label for="category_id">Category :</label>
                    <select name="category_id" class="form-control form-control-lg">
      <?php 
          while ($rows = mysqli_fetch_array($query,MYSQLI_ASSOC)):; 
      ?>
            <option value="<?php echo $rows['category_id'] ;
                    // The value we usually set is the primary key
              ?>">
        <?php echo $rows["category_name"];
                        // To show the category name to the user
                ?>
            </option>
            <?php 
                endwhile; 
                // While loop must be terminated
            ?>
      </select><br>
                    <div class="button">
                        <button type="submit" value="submit" name="submit" class="smb">DONE</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="uppic" id="selectedBanner"></div>
    </div>
  
</body>
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
</script>
</html>

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

$CountBook = "SELECT COUNT(user_id) FROM `favourites` WHERE user_id = ?";
if ($Countstmt = mysqli_prepare($conn, $CountBook)) {
    // 绑定参数
    mysqli_stmt_bind_param($Countstmt, "i", $userId);

    // 执行查询
    if (mysqli_stmt_execute($Countstmt)) {
        // 获取查询结果
        $CountResult = mysqli_stmt_get_result($Countstmt);

        // 从结果集中获取数据
        $countData = mysqli_fetch_assoc($CountResult);
        $book = $countData['COUNT(user_id)'];

        // 关闭准备语句
        mysqli_stmt_close($Countstmt);
    } else {
        // 处理查询执行错误
        $book = 0; // 设置默认值或者其他处理方式
    }
} else {
    // 处理准备查询错误
    $book = 0; // 设置默认值或者其他处理方式
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Book Mark</title>
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
    <link rel="stylesheet" type="text/css" href="Css/Utility.css">
</head>

<body>

<div class="user-book-info">
           <div class="favorite">
            <div class="titleBox">
            <span class="book-mark-title">BOOK MARK</span>
             <!-- <span class="view-more"><a href="" class="view-more">View More</a></span> -->
             <span class="countBook">You have mark <span class="countNumber"><?php echo $book; ?></span> Book</span>
            </div>

            <div class="ui action input" id="searchBox">
  <input type="text" id="searchInput" placeholder="Search...">
  <button class="ui icon button">
      <i class="search icon q-mr-xs"></i>
      Search
  </button>
</div>
            <!-- <div class="ui icon input" id="searchBox">
  <i class="search icon"></i>
  <input type="text" id="searchInput" placeholder="Search...">
</div> -->
             <!-- <div class="searchBox" id="">
  <input type="text" placeholder="Search..." id="searchInput" fdprocessedid="wepybm">
  <i class="search icon"></i>
</div> -->
             <div class="favorite-book">
             
    <?php
    while ($row = mysqli_fetch_array($result)) {

        echo '<div class="book-cover">';
        echo '<div class="linear-bg"></div>';
        echo '<p class="book-title">' . $row['book_title'] .'</p>';
        echo '<button type="button" class="hidden-button">View Detail</button>';
        echo '<img class="book-image" src="../cover/' . $row['book_cover'] . '" alt="Book Cover">';
        echo '</div>';
        // You can display other columns from the result as well
    } ?>
</div>
</div>


    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</body>

</html>

<script src="../Fomantic-ui/dist/semantic.min.js"></script>
<script src="../Fomantic-ui/dist/components/form.js"></script>
<script src="../Fomantic-ui/dist/components/transition.js"></script>

<style>
    
.user-book-info{
    background:#FFFBF5;
    border:4px solid #000;
    flex-wrap: wrap;
    border-radius:20px;
    width:90%;
    padding:20px 30px;
    margin:100px auto;
    position: relative;
}

.user-book-info .book-mark-title{
    font-size:30px;
    letter-spacing:3px;
    font-weight:900;
    padding:0px 7px;
}

.user-book-info .view-more{
    float:right;
}

.favorite{
    margin:20px 0px;
}

.favorite-book{
    margin:20px 0px;
    display:flex;
}
#searchBox{
    width:100%;
    padding:10px 10px;
    display:flex;
}
#searchInput{
    width:90%;
    padding:10px;
    font-size:15px;
    background: transparent;
    border-top:3px solid #000;
    border-right: 0px;
   border-bottom:3px solid #000;
   border-left: 3px solid #000;
   border-top-left-radius: 6px;
   border-bottom-left-radius: 6px;
}
#searchBox button{
    background: #000;
    color: #fff;
    border-top:3px solid #000;
    border-right: 3px solid #000;
   border-bottom:3px solid #000;
   border-left: 0px;
}
#searchBox i{
    margin-right: 6px !important;
}
.book-cover{
    height:400px;
    width:400px;
    margin:5px 10px;
    border:5px solid #000;
    border-radius:20px;
    overflow:hidden;
    position: relative;
}



.linear-bg{
    background: linear-gradient(to top, black, transparent);
    position: absolute;
    height:230px;
    width:100%;
    border-radius:10px;
    bottom:0%;
    transition:0.4s;
    /* z-index:2; */
}

.book-image{
    width:100%;
    height:100%;
    object-fit: cover;
    background-repeat: no-repeat;
    background-position:center;
    transition:0.4s;
    /* z-index:1; */
}
.book-title{
    color:#fff;
    position:absolute;
    bottom:0;
    padding:0px 30px;
    transition:0.4s;
    opacity: 1; 
    font-weight:900;
}

.countBook{
    float:right;
    font-size:23px;
    padding:0px 10px;
}

.countNumber{
    color:#FF6C22;
    font-weight: bolder;
}

.hidden-button {
    background: transparent;
    padding: 10px 30px;
    position: absolute;
    border: 3px solid #fff;
    color: #fff;
    border-radius: 10px;
    top: 50%; /* 垂直居中 */
    left: 50%; /* 水平居中 */
    transform: translate(-50%, -50%); /* 用于水平和垂直居中 */
    z-index: 2;
    transition: 0.4s;
    opacity: 0; /* 初始化时隐藏按钮 */
}

.book-cover:hover .hidden-button {
    opacity: 1; /* 鼠标悬停时显示按钮 */
    display: inline;
}

.book-cover:hover .linear-bg{
    /* filter: brightness(50%); */
    height:500px;
}
.book-cover:hover .book-title {
    opacity: 0; /* 鼠标悬停时标题不可见 */
}
.hidden-button:hover{
    background:#fff;
    color:#000;
}
</style>
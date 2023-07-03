<?php 
include_once("db.php");

$query = "SELECT book.*, category.category_name, language.language_name 
          FROM book
          INNER JOIN category ON book.category_id = category.category_id
          INNER JOIN language ON book.book_language = language.language_id";

$SQL = mysqli_query($conn, $query);

?>

 <!DOCTYPE html>
 <html>
 <head>
    <title>DIGITAL LIBRARY</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="fe.css">
 </head>
 <body>
 <div class="topnav2">
 <div class="toptext">
 <span><a class="firstT" href="index_admin.php">DIGITAL</a></span>
  <span><a class="firstT2" href="index_admin.php">LIBRARY</a></span>
  <span class="firstT3">BOOK</span>
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
<div class="idamt">
<div class="booksearch">
    <input type="text" placeholder="What book you looking for..." class="searchbook" name="">
    <button class="uplbtn" onclick="window.location.href='upload.php'"><i class="fa fa-plus"></i> ADD</button>
    <button class="dltbtn"><i class="fa fa-trash-o"></i> Delete</button>
</div>
<div class="tableshow">
<table class="table"> 
    <thead class="trh">
        <th>#</th>
        <th>Title</th>
        <th>Author</th>
        <th>Public Date</th>
        <th>Language</th>
        <th>Category</th>
        <th></th>
    </thead>
    <div>
    <tr class="tdhv">
        <?php while($row = mysqli_fetch_array($SQL))  {?>
            <td><?=$row["book_id"]?></td>
            <td><?=$row["book_title"]?></td>
            <td><?=$row["book_author"]?></td>
            <td><?=$row["book_public_date"]?></td>
            <td><?=$row["language_name"]?></td>
            <td><?=$row["category_name"]?></td>
            <td>
             <a href="edit.php?id=<?=$row['book_id']?>" class="edt"><i class="fa fa-pencil"></i></a>
            </td>
    </tr>
 <?php  }?>
    </div>
 </table>
</div>
</div>
 </html>
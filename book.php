<?php 
include_once("db.php");

$query = "SELECT book.book_id, book.book_title, book.book_name, book.book_author, book.book_public_date, book.book_language, book.category_id, category.category_id, category.category_name FROM book
INNER JOIN category ON book.category_id = category.category_id";
$SQL   = mysqli_query($conn,$query);

?>

 <!DOCTYPE html>
 <html>
 <head>
 </head>
 <body>
<table>
    <tr>
        <th>Book ID</th>
        <th>Book Title</th>
        <th>Book Author</th>
        <th>Book Public Date</th>
        <th>Book Language</th>
        <th>Category</th>
    </tr>
    <tr>
        <?php while($row = mysqli_fetch_array($SQL))  {?>
            <td><?=$row["book_id"]?></td>
            <td><?=$row["book_title"]?></td>
            <td><?=$row["book_author"]?></td>
            <td><?=$row["book_public_date"]?></td>
            <td><?=$row["book_language"]?></td>
            <td> <button name="book_class" onclick="window.location.href='book_class.php?id=<?=$row['class_id']?>'" id="book_class" class="btn btn-primary">Booking Class</button></td>
    </tr>
 <?php  }?>
 </table>
 </html>
<?php
include_once('db.php');

echo $SQL = "SELECT * FROM category";
$query 	= mysqli_query($conn,$SQL);

if(isset($_POST['submit'])){
	$book_title=$_POST['book_title'];
	$book_name=$_POST['book_name'];
	$book_author=$_POST['book_author'];
    $book_public_date=$_POST['book_public_date'];
    $book_language=$_POST['book_language'];
    $category_id=$_POST['category_id'];

	echo $query="INSERT INTO book (book_title,book_name,book_author,book_public_date,book_language,category_id) VALUES ('$book_title','$book_name','$book_author','$book_public_date','$book_language','$category_id')";
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
    <title>Upload</title>
</head>
<body>
    <div class="container">
        <div class="title">Upload</div>
        <form action="upload.php" method="POST">
            <div class="user-details">
                <div class="input-box">
                    <span class="details">Book Title</span>
                    <input type="text" placeholder="Book Title" name="book_title" required>
                </div>
                <div class="input-box">
                    <label for="myfile">Book Name</label>
                    <input type="file" id="myfile" name="book_name" required>
                </div>
                <div class="input-box">
                    <span class="details">Book Author</span>
                    <input type="text" placeholder="Book Author" name="book_author" required>
                </div>
                <div class="input-box">
                    <span class="details">Book Public Date</span>
                    <input type="date" name="book_public_date" required>
                </div>
                <div class="input-box">
                    <span class="details">Book Language</span>
                    <input type="text" placeholder="Book Language"  name="book_language" required>
                </div>
                <div class="input-box">
                    <label for="category_id">Choose a Category ID</label>
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
                        <input type="submit" value="submit" name="submit">
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
<?php 
include_once("db.php");

$SQL = "SELECT * FROM book";
$query  = mysqli_query($conn,$SQL);

if(isset($_POST['submit']) && isset($_GET['id'])){
  $book_tittle=$_POST['book_title'];
  $book_name=$_POST['book_name'];
  $book_author=$_POST['book_author'];
  $book_public_date=$_POST['book_public_date'];
  $book_language=$_POST['book_language'];

 echo $query = "UPDATE book SET book_title='$book_title',book_name='$book_name',book_author='$book_author',book_public_date='$book_public_date',book_language='$book_language' WHERE book_id='".$_GET['id']."'";

  if($result = mysqli_query($conn,$query)){
    echo "<script>alert('Update Success');
    window.location.href='book.php';
    </script>";
  }else{
    echo "<script>alert('Update Failed');</script>";
  }
}

$qry = "SELECT * FROM book WHERE book_id = '".$_GET['id']."'";
$sql = mysqli_query($conn,$qry);
$row = mysqli_fetch_array($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funda of Web IT</title>
</head>
<body>
                <div class="card mt-5">
                    <div class="card-header">
                        <h4>Edit Book</h4>
                    </div>
                    <div class="card-body">

                        <form action="edit.php?id=<?=$_GET['id']?>" method="post">

                            <div class="form-group mb-3">
                                <label for="">Book Title</label>
                                <input type="text" name="book_title" value="<?=$row['book_title']?>">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Book Name</label>
                                <input type="text" name="book_name" value="<?=$row['book_name']?>">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Book Author</label>
                                <input type="text" name="book_author" value="<?=$row['book_author']?>" >
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Book Public Date</label>
                                <input type="date" name="book_public_date" value="<?=$row['book_public_date']?>" >
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Book Language</label>
                                <input type="text" name="book_language"value="<?=$row['book_language']?>" >
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" name="submit" class="btn btn-primary">Update Data</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
</body>
</html>
<?php 
include_once("db.php");

$query = "SELECT * FROM `user`";
$SQL   = mysqli_query($conn,$query);

?>

<!DOCTYPE html>
<html>
<head>
  <title>DIGITAL LIBRARY</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="fe.css">
</head>
<body>
  <div class="topnav2">
    <div class="toptext">
      <span><a class="firstT" href="index_admin.php">DIGITAL</a></span>
      <span><a class="firstT2" href="index_admin.php">LIBRARY</a></span>
      <span class="firstT3">USER</span>
    </div>
    <div class="search-container">
      <form action="index_admin.php">
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

  <div class="idamt">
    <div class="booksearch">
      <input type="text" placeholder="What book are you looking for..." class="searchbook" name="">
    </div>
    <div class="tableshow2">
      <table class="table"> 
        <tr class="trh">
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Password</th>
          <th>Contact</th>
          <th>Status</th>
          <th></th>
        </tr>
        <?php while ($row = mysqli_fetch_array($SQL)) { ?>
          <tr class="tdhv">
            <td><?= $row["user_id"] ?></td>
            <td><?= $row["user_name"] ?></td>
            <td><?= $row["user_email"] ?></td>
            <td><?= $row["user_password"] ?></td>
            <td><?= $row["user_contact"] ?></td>
            <td><?= $row["user_status"] ?></td>
            <td>
              <a href="edit_u.php?id=<?= $row['user_id'] ?>" class="edt"><i class="fa fa-pencil"></i></a>
            </td>
          </tr>
        <?php } ?>
      </table>
    </div>
  </div>
</body>
</html>
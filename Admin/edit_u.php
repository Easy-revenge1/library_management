<?php
// Include the database connection file
include_once("db.php");

// Check if the form is submitted and the "id" parameter is set
if(isset($_POST['submit']) && isset($_GET['id'])) {
  // Retrieve user input from the form
  $u_name = $_POST['user_name'];
  $u_email = $_POST['user_email'];
  $u_password = $_POST['user_password'];
  $u_contact = $_POST['user_contact'];
  $u_status = $_POST['user_status'];

  // Prepare the SQL query with placeholders
  $query = "UPDATE user SET user_name = ?, user_email = ?, user_password = ?, user_contact = ?, user_status = ? WHERE user_id = ?";

  // Create a prepared statement
  $stmt = mysqli_prepare($conn, $query);

  // Bind the parameters to the prepared statement
  mysqli_stmt_bind_param($stmt, "sssssi", $u_name, $u_email, $u_password, $u_contact, $u_status, $_GET['id']);

  // Execute the prepared statement
  if(mysqli_stmt_execute($stmt)) {
    // If the update is successful, redirect to the user.php page
    header('Location: user.php');
    exit();
  } else {
    // If the update fails, display an error message
    $error_message = "Update Failed: " . mysqli_stmt_error($stmt);
  }

  // Close the prepared statement
  mysqli_stmt_close($stmt);
}

// Retrieve the user data based on the "id" parameter
$qry = "SELECT * FROM user WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $qry);
mysqli_stmt_bind_param($stmt, "i", $_GET['id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_array($result);

// Close the prepared statement
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DIGITAL LIBRARY</title>
  <link rel="stylesheet" href="/css/main.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  <div class="topnav2">
    <div class="toptext">
      <span><a class="firstT" href="index_admin.php">DIGITAL</a></span>
      <span><a class="firstT2" href="index_admin.php">LIBRARY</a></span>
      <span class="firstT3">USER</span>
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
    <form action="edit_u.php?id=<?=$_GET['id']?>" method="POST">
      <button type="button" onclick="window.location.href='user.php'" class="bck"><i class="fa fa-arrow-left"></i></button>
      <div class="user-details">
        <div class="input-box">
          <label class="details" for="">Name :</label>
          <input class="ipt" type="text" name="user_name" value="<?=$row['user_name']?>">
        </div>
        <div class="input-box">
          <label class="details" for="">Email :</label>
          <input class="ipt" type="text" name="user_email" value="<?=$row['user_email']?>">
        </div>
        <div class="input-box">
          <label class="details" for="">Password :</label>
          <input class="ipt" type="text" name="user_password" value="<?=$row['user_password']?>" >
        </div>
        <div class="input-box">
          <label class="details" for="">Contact :</label>
          <input class="ipt" type="text" name="user_contact" value="<?=$row['user_contact']?>" >
        </div>
        <div class="input-box">
        <label class="details" for="">Status :</label>
        <select class="ipt" name="user_status">
          <option value="Online" <?php if ($row['user_status'] === 'Online') echo 'selected'; ?>>Online</option>
          <option value="Blacklisted" <?php if ($row['user_status'] === 'Blacklisted') echo 'selected'; ?>>Blacklisted</option>
        </select>
      </div>
      <div class="button">
        <button type="submit" value="submit" name="submit" class="smb">DONE</button>
      </div>
      </div>
      <div class="uppic-user">
        <img src="pic/fscat.jpg" alt="" id="pic" onclick="togglePicSize()">
      </div>
    </form>
  </div>

  <script>
    function togglePicSize() {
      var pic = document.getElementById('pic');
      pic.classList.toggle('clicked');
    }
  </script>
</body>
</html>

<style>
.uploadfc{
  background-color:#0d0d0d;
  border:4px solid #0d0d0d;
  border-radius:10px;
  transition:0.4s;
  height:450px;
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
  margin:10px 35px;
  font-size:17px;
  font-weight:normal;
  letter-spacing: 1px;
}
.user-details{
    position:fixed;
    width:38%;
    margin:40px 0px;
}
.details{
  letter-spacing:2px;
  color:#fff;
}
.input-box label{
    color: #fff;
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
    border-radius:4px;
    border:2px solid #333;
    transition:0.4s;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    color: #fff;
}
/* .ipt option {
  color: #000;
} */
.uploadfc .ipt:hover{
    border:2px solid #66ff66;
}
.input-box{
    margin:17px 35px;
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
.uppic{
    background-color:#000;
    height:500px;
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
.uppic-user{
    height:500px;
    width:60%;
    border-radius:6px;
    float:right;
    margin-left:5px;
    display:block;
}
.uppic-user img{
    height:300px;
    width:300px;
    border:4px solid #0d0d0d;
    margin:75px 190px;
    border-radius:50%;
    background-size: auto;
     transition:0.4s;
}
#pic.clicked {
    height:400px; 
    width:400px;
    margin:18px 140px;
    border-radius:6px;
}
</style>
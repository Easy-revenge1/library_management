<?php
include_once('../db.php');
include_once('NavigationBar.php');

if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id']; // Update to get user_id from the form
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_contact = $_POST['user_contact'];

    $query = "UPDATE `user` SET `user_name` = ?, `user_email` = ?, `user_contact` = ? WHERE `user_id` = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "sssi", $user_name, $user_email, $user_contact, $user_id);
        if (mysqli_stmt_execute($stmt)) {
            // echo '<div class="ui success message">User information updated successfully</div>';
        } else {
            echo "Error updating user information: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt); // Close the statement here
    } else {
        echo "Error preparing the statement: " . mysqli_error($conn);
    }
}

$user_id = $_GET['user_id'];

$UserProfile = "SELECT * FROM `user` WHERE `user_id` = ?";

$stmt = mysqli_prepare($conn, $UserProfile);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt); // Close the statement here
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/semantic.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Edit Profile</title>
</head>

<body>
    <div class="edit-box" id="">
    <div class="user-image">
    <button type="button" class="hidden-button">Change Background</button>   <!-- change background -->
    <img src="../pic/pyh.jpg" class="user-background" alt="">
</div>
        <div class="user-edit-box">
            <div class="user-pic-box">
            <button class="change-icon"><img src="../pic/plus2.png" alt=""></button>  <!-- change profile pic -->
            <img src="../pic/fscat.jpg" class="user-pic" alt="">
            </div>
          <div class="edit-form">
          <h1 class="ui header">Edit Your Profile</h1>
        <form class="" action="EditProfile.php?user_id=<?php echo $user_id?>" method="POST">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

            <div class="lboxcss">
            <input type="text" class="lbox-input" name="user_name" id="user_name" value="<?php echo $row['user_name']; ?>" autocomplete="off" required >
              <label for="text" class="label-name">
              <span class="content-name">
                Username
              </span>
              </label>
            </div>

            <div class="lboxcss">
            <input type="email" class="lbox-input" name="user_email" id="user_email" value="<?php echo $row['user_email']; ?>" autocomplete="off" required >
              <label for="text" class="label-name">
              <span class="content-name">
                E-mail
              </span>
              </label>
            </div>

            <div class="lboxcss">
            <input type="text" class="lbox-input" name="user_contact" id="user_contact" value="<?php echo $row['user_contact']; ?>" autocomplete="off" required >
              <label for="text" class="label-name">
              <span class="content-name">
              Contact
              </span>
              </label>
            </div>
             
           <div class="button-box">
           <button class="ui button" type="submit" name="submit" id="updateProfileButton" disabled>Update Profile</button>

           <a class="ui red button" id="change-pass-button" href="ChangePassword.php?user_id=<?php echo $user_id; ?>">Change Password</a>
           </div>


        </form>
          </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwa d6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>

<script src="../Fomantic-ui/dist/semantic.min.js"></script>
<script>
    // Select the input fields
    var userNameInput = document.getElementById('user_name');
    var userEmailInput = document.getElementById('user_email');
    var userContactInput = document.getElementById('user_contact');
    
    // Select the "Update Profile" button
    var updateProfileButton = document.getElementById('updateProfileButton');

    // Function to enable the button when any input field changes
    function enableUpdateProfileButton() {
        updateProfileButton.removeAttribute('disabled');
    }

    // Add event listeners to the input fields
    userNameInput.addEventListener('input', enableUpdateProfileButton);
    userEmailInput.addEventListener('input', enableUpdateProfileButton);
    userContactInput.addEventListener('input', enableUpdateProfileButton);
</script>

<style>
.edit-box{
  background:#FFFBF5;
  border:4px solid #000;
  border-radius:20px;
  width:90%;
  margin: 90px auto; 
  overflow:hidden;
}
.user-edit-box{
    width:100%;
    display:flex;
}
.user-image {
    position: relative;
    height: 250px;
    border-bottom: 4px solid #000;
}

.user-background {
    width: 100%;
    height: 100%;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    object-fit: cover;
    z-index: 1;
    transition: all 0.4s;
    overflow: hidden;
    z-index: 1;
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

.user-image:hover .hidden-button {
    opacity: 1; /* 鼠标悬停时显示按钮 */
    display: inline;
}

.user-image:hover .user-background {
    filter: brightness(50%);
}
.hidden-button:hover{
    background:#fff;
    color:#000;
}
.edit-form{
    width:65%;
    padding:40px 40px;
    float:right;
}
.user-pic-box{
    padding:60px 60px;
}
.user-pic{
    background:#fff;
    height:300px;
    width:300px;
    border:6px solid #000;
    border-radius:50%;  
    /* margin:50px 100px; */
}

.lboxcss {
              width: 100%;
              position: relative;
              height: 60px;
              overflow: hidden;
              margin: 10px 0px;
          }

          .lboxcss .lbox-input {
              width: 100%;
              height: 100%;
              color: #000;
              padding-top: 20px;
              border: none;
              background: transparent;
          }

          .lboxcss .lbox-input-wrapper {
              display: flex;
          }

          .lboxcss .lbox-input-wrapper .icon {
              margin-left: 5px;
          }

          .lboxcss label {
              position: absolute;
              bottom: 0px;
              left: 0px;
              width: 100%;
              height: 100%;
              pointer-events: none;
              border-bottom: 1px solid grey;
          }

          .lboxcss label::after {
              content: "";
              position: absolute;
              bottom: -1px;
              left: 0px;
              width: 100%;
              height: 100%;
              border-bottom: 3px solid #000;
              transform: translateX(-100%);
              transition: all 0.3s ease;
          }

          .content-name {
              position: absolute;
              bottom: 0px;
              left: 0px;
              padding-bottom: 5px;
              transition: all 0.3s ease;
          }

          .lboxcss .lbox-input:focus {
              outline: none;
          }

          .lboxcss .lbox-input:focus + .label-name .content-name,
          .lboxcss .lbox-input:valid + .label-name .content-name {
              transform: translateY(-150%);
              font-size: 14px;
              left: 0px;
              color: #000;
          }

          .lboxcss .lbox-input:focus + .label-name::after,
          .lboxcss .lbox-input:valid + .label-name::after {
              transform: translateX(0%);
          }
          #showPasswordButton{
            background:transparent;
            border:0px;
            margin:35px 0px;
            position: absolute;
            right:0;
          }


.lboxcss .lbox-input-wrapper .lbox-input {
    flex: 1; /* Take up remaining space */
}

.lboxcss .lbox-input-wrapper .icon {
    margin-left: 5px;
}
.button-box{
    
}
#updateProfileButton{
   width:100%;
   margin:13px 0px;
}
#change-pass-button{
   width:100%;
}
.change-icon{
    border:0;
    background:transparent;    
    margin:30px 200px;
    position: absolute;
    bottom:0;
}
.change-icon img{
    height:55px;
    width:55px;
}
</style>

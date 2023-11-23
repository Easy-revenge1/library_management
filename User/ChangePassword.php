<?php
include_once('../db.php');
include_once('NavigationBar.php');

$userId = $_SESSION['user_id'];

if (isset($_POST['change'])) {
    $user_id = $_SESSION['id'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $password_query = "SELECT user_password FROM `user` WHERE `user_id` = ?";
    $stmt = mysqli_prepare($conn, $password_query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    // Verify the old password
    if (password_verify($old_password, $row['user_password'])) {
        // Old password is correct
        if ($new_password === $confirm_password) {
            // New and confirm passwords match, proceed to update
            $hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);
            $update_query = "UPDATE `user` SET user_password = ? WHERE `user_id` = ?";
            $update_stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($update_stmt, "si", $hashed_new_password, $user_id);

            // Execute the update query
            if (mysqli_stmt_execute($update_stmt)) {
                // Password updated successfully
                echo '';
            } else {
                // Error updating the password
                echo '<div class="ui error message">Error on updating password</div>';
            }
        } else {
            // New and confirm passwords don't match
            echo '<div class="ui error message">New and Confirm Password don\'t match</div>';
        }
    } else {
        // Old password doesn't match
        echo '<div class="ui error message">Old password don\'t match</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/semantic.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="change-pass-box">
        <div class="change-pass-form">
        <h1 class="ui header" id="change-password">Change Password</h1>
        <form class="" action="ChangePassword.php" method="POST" novalidate>

        <div class="lboxcss">
            <input type="password" class="lbox-input" name="old_password" id="old_password" autocomplete="off" required >
              <label for="text" class="label-name">
              <span class="content-name">
                Old Password
              </span>
              </label>
            </div>

            <div class="lboxcss q-mt-md">
            <input type="password" class="lbox-input" name="new_password" id="new_password" autocomplete="off" required >
              <label for="text" class="label-name">
              <span class="content-name">
                New Password
              </span>
              </label>
            </div>

            <div class="lboxcss q-mt-md">
            <input type="password" class="lbox-input" name="confirm_password" id="confirm_password" autocomplete="off" required >
              <label for="text" class="label-name">
              <span class="content-name">
                Confirm Password
              </span>
              </label>
            </div>       
            
            <div class="empty" style="height:130px;"></div>

             <div class="cp-button-box">
             <button class="ui black button" id="change-pass-button" type="submit" name="change">Change Password</button>
            <!-- <button class="ui black button" onclick="window.location.href='EditProfile.php?user_id=' + $userId" id="back-profile-button">Back to Profile</button> -->
             </div> 
        </form>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwa d6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </div>
        </div>
</body>

</html>

<script src="../Fomantic-ui/dist/semantic.min.js"></script>

<style>
.change-pass-box{
    background:#FFFBF5;
    width:40%;
    position: absolute;
    top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    border:4px solid #000;
    border-radius:20px;
    overflow:hidden;
}
.change-password{
    font-weight:900;
}
.change-pass-form{
    padding:30px 30px;
}
#change-pass-button{
   width:100%;
   margin:10px 0px;
}
#back-profile-button{
    width:100%;
}
.lboxcss {
              width: 100%;
              position: relative;
              height: 60px;
              overflow: hidden;
              margin: 20px 0px;
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
</style>

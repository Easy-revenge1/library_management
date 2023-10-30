<?php
include_once('../db.php');

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
                echo '<div class="ui success message">Password updated successfully</div>';
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
<h1 class="ui header">Change Password</h1>
        <form class="ui form" action="ChangePassword.php" method="POST" novalidate>
            <div class="field">
                <label for="old_password">Old Password</label>
                <input type="password" name="old_password" id="old_password" required>
            </div>
            <div class="field">
                <label for="new_password">New Password</label>
                <input type="password" name="new_password" id="new_password" required>
            </div>
            <div class="field">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
            </div>
            <button class="ui button" type="submit" name="change">Change Password</button>
        </form>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwa d6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>

<script src="../Fomantic-ui/dist/semantic.min.js"></script>

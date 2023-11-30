<?php
ob_start();
include_once('../db.php');
include_once('NavigationBar.php');

$userId = $_SESSION['user_id'];


if (!isset($_SESSION['operation_status'])) {
    $_SESSION['operation_status'] = null;

}

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
                $_SESSION['operation_status'] = true;
            } else {
                // Error updating the password
                $_SESSION['operation_status'] = false;
            }
        } else {
            // New and confirm passwords don't match
            $_SESSION['operation_status'] = "NewOldDontMatch";
        }
    } else {
        // Old password doesn't match
        $_SESSION['operation_status'] = "OldDontMatch";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/semantic.min.css">
    <title>Change Password</title>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="Assets/plugins/sweetalert2/sweetalert2.all.js"></script>
    <script src="Assets/plugins/toastr/toastr.min.js"></script>
    <script src="Assets/js/SweetAlert.js"></script>
</head>

<body>
    <?php
    if (isset($_SESSION["operation_status"]) && $_SESSION["operation_status"] === true) {
            echo '<script>successToast(' . json_encode("Password Changed, Redirecting...") . ')</script>';
            header("Refresh: 1; url=Userprofile.php");
            $_SESSION['operation_status'] = null;
            exit();
        } elseif ($_SESSION["operation_status"] === false) {
            echo '<script>failToast(' . json_encode("Password change failed. Please try again.") . ')</script>';
        } elseif ($_SESSION["operation_status"] === "NewOldDontMatch") {
            echo '<script>failToast(' . json_encode("New and Confirm Password don't match") . ')</script>';
        } elseif ($_SESSION["operation_status"] === "OldDontMatch") {
            echo '<script>failToast(' . json_encode("Old password don't match") . ')</script>';
        }
    ?>


    <div class="change-pass-box">
        <div class="change-pass-form">
            <h1 class="ui header" id="change-password">Change Password</h1>
            <form action="ChangePassword.php" method="POST" novalidate>

                <div class="lboxcss">
                    <input type="password" class="lbox-input" name="old_password" id="old_password" autocomplete="off"
                        required>
                    <label for="text" class="label-name">
                        <span class="content-name">
                            Old Password
                        </span>
                    </label>
                </div>

                <div class="lboxcss q-mt-md">
                    <input type="password" class="lbox-input" name="new_password" id="new_password" autocomplete="off"
                        required>
                    <label for="text" class="label-name">
                        <span class="content-name">
                            New Password
                        </span>
                    </label>
                </div>

                <div class="lboxcss q-mt-md">
                    <input type="password" class="lbox-input" name="confirm_password" id="confirm_password"
                        autocomplete="off" required>
                    <label for="text" class="label-name">
                        <span class="content-name">
                            Confirm Password
                        </span>
                    </label>
                </div>

                <div class="empty" style="height:130px;"></div>

                <div class="cp-button-box">
                    <button class="ui black button" id="change-pass-button" type="submit" name="change">Change
                        Password</button>
                    <!-- <button class="ui black button" onclick="window.location.href='EditProfile.php?user_id=' + $userId" id="back-profile-button">Back to Profile</button> -->
                </div>
            </form>
        </div>
    </div>
</body>

</html>

<script src="../Fomantic-ui/dist/semantic.min.js"></script>

<style>
        .title{
        color:#000 !important;
    }
.navHref{
    color:#000 !important;
}   
    .change-pass-box {
        background: #FFFBF5;
        width: 40%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border: 4px solid #000;
        border-radius: 20px;
        overflow: hidden;
    }

    .change-password {
        font-weight: 900;
    }

    .change-pass-form {
        padding: 30px 30px;
    }

    #change-pass-button {
        width: 100%;
        margin: 10px 0px;
    }

    #back-profile-button {
        width: 100%;
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

    .lboxcss .lbox-input:focus+.label-name .content-name,
    .lboxcss .lbox-input:valid+.label-name .content-name {
        transform: translateY(-150%);
        font-size: 14px;
        left: 0px;
        color: #000;
    }

    .lboxcss .lbox-input:focus+.label-name::after,
    .lboxcss .lbox-input:valid+.label-name::after {
        transform: translateX(0%);
    }

    #showPasswordButton {
        background: transparent;
        border: 0px;
        margin: 35px 0px;
        position: absolute;
        right: 0;
    }


    .lboxcss .lbox-input-wrapper .lbox-input {
        flex: 1;
        /* Take up remaining space */
    }

    .lboxcss .lbox-input-wrapper .icon {
        margin-left: 5px;
    }
</style>
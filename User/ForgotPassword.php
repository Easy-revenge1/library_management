<?php
include_once('../db.php');
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['submit'])) {
    // Validate and sanitize the user's email input
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

    $User = "SELECT * FROM `user` WHERE `user_email` = ?";
    $stmt = $conn->prepare($User);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate a unique reset token
        $resetToken = bin2hex(random_bytes(32));

        // Set the expiration time (e.g., 1 hour from now)
        $resetTokenExpiration = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Update the user's record in the user table with the reset token and expiration
        $updateSql = "UPDATE `user` SET reset_token = ?, reset_token_expiration = ? WHERE user_email = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("sss", $resetToken, $resetTokenExpiration, $email);
        if ($updateStmt->execute()) {
            $_SESSION['reset_email'] = $email;
            // Send the password reset email
            $resetLink = "http://localhost/library_management/User/ResetPassword.php?token=$resetToken";
            $subject = "Password Reset";
            $message = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Password Reset</title>
            </head>
            <body>
                <p>Dear User,</p>
                <p>You have requested to reset your password. To proceed, please click the following link:</p>
                <p><a href="' . $resetLink . '">Reset Password</a></p>
                <p>If you did not request a password reset, please ignore this email. Your account remains secure.</p>
                <p>Thank you for using our service.</p>
            </body>
            </html>
            ';
            $mail = new PHPMailer(true); // Enable exceptions
            try {
                $mail->isSMTP();
                $mail->SMTPDebug = SMTP::DEBUG_OFF;
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 465;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->SMTPAuth = true;
                $mail->Username = 'chiewhaoer@gmail.com';
                $mail->Password = 'fhuv vtte zgts ylyw';
                $mail->setFrom('chiewhaoer@gmail.com', 'Chiew Hao Er');
                $mail->addReplyTo('chiewhaoer@gmail.com', 'Chiew Hao Er');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $message;

                $mail->send();
                echo '<div class="ui success message">Password reset email sent successfully.</div>';
            } catch (Exception $e) {
                echo '<div class="ui error message">Error sending the password reset email: ' . $mail->ErrorInfo . '</div>';
            }
        } else {
            echo '<div class="ui error message">Failed to update the user\'s record.</div>';
        }
    } else {
        echo '<div class="ui error message">Email not found in our records. Please try again.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/semantic.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Forgot Password</title>
</head>

<body>
    <div class="fpBox">
        <button class="backButton" onclick="window.location.href='UserLogin.php'"><i class="arrow left icon"></i></button>
        <h2 class="ui header">Forgot Password</h2>
        <p>Enter your email address below to request a password reset.</p>
        <form class="" action="ForgotPassword.php" method="post">
   
        <div class="lboxcss">
                        <input type="email" class="lbox-input" name="email" id="email" autocomplete="off" required>
                        <label for="text" class="label-name">
                            <span class="content-name">
                            Email
                            </span>
                        </label>
                    </div>
            <button class="ui black button" id="request" style="width:100%;" type="submit" name="submit">Request Reset</button>

        </form>
    </div>
</body>

</html>

<style>
 body{
    background:#eee;
 }
.fpBox{
    background: #FFFBF5;
    border:4px solid #000;
    border-radius:10px;
    /* margin:260px auto; */
    padding:30px;
    width:40%;
    position: absolute;
    top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
}

.backButton{
    background: transparent; 
    border:0px;
    font-size:20px;
    cursor: pointer;
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
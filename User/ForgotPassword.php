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
    <title>Document</title>
</head>

<body>
    <div class="ui container">
        <h2 class="ui header">Forgot Password</h2>
        <p>Enter your email address below to request a password reset.</p>
        <form class="ui form" action="ForgotPassword.php" method="post">
            <div class="field">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <button class="ui primary button" type="submit" name="submit">Request Reset</button>
        </form>
    </div>
</body>

</html>
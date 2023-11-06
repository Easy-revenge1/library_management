<?php
include_once("../db.php");

$resetToken = $_GET['token'];

if (isset($_POST["submit"])) {
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];
    $password_hash = '';

    // Debug lines
    echo "Debug: email = " . $_SESSION['reset_email'] . "<br>";
    echo "Debug: reset_token = " . $_GET['token'] . "<br>";

    if ($new_password === $confirm_password) {
        // Passwords match, proceed with the reset
        if (isset($_SESSION['reset_email'])) {
            $resetEmail = $_SESSION['reset_email'];
            $resetToken = $_GET['token'];

            // Check if the reset token is still valid (not expired)
            $checkTokenExpiration = "SELECT reset_token_expiration FROM `user` WHERE user_email = ? AND reset_token = ?";
            $stmtExpiration = $conn->prepare($checkTokenExpiration);
            $stmtExpiration->bind_param("ss", $resetEmail, $resetToken);
            $stmtExpiration->execute();
            $resultExpiration = $stmtExpiration->get_result();
            if ($resultExpiration->num_rows > 0) {
                $expirationData = $resultExpiration->fetch_assoc();
                $resetTokenExpiration = strtotime($expirationData['reset_token_expiration']);
                $currentTimestamp = strtotime("now");

                if ($resetTokenExpiration >= $currentTimestamp) {
                    // Token is still valid, proceed with the reset
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    // Update the user's password in the database
                    $UpdatePassword = "UPDATE `user` SET `user_password` = ? WHERE user_email = ? AND `reset_token` = ?";
                    $stmt = $conn->prepare($UpdatePassword);
                    $stmt->bind_param("sss", $password_hash, $resetEmail, $resetToken);

                    if ($stmt->execute()) {
                        // Password updated successfully
                        // Now reset the 'reset_token' and 'reset_token_expiration' to NULL
                        $ResetTokenToNull = "UPDATE `user` SET `reset_token` = NULL, `reset_token_expiration` = NULL WHERE user_email = ?";
                        $resetTokenNullStmt = $conn->prepare($ResetTokenToNull);
                        $resetTokenNullStmt->bind_param("s", $resetEmail);
                        $resetTokenNullStmt->execute();

                        header("Location: UserLogin.php");
                        exit();
                    } else {
                        echo '<div class="ui error message">Failed to update the password. Please try again.</div>';
                    }
                } else {
                    echo '<div class="ui error message">The reset link has expired. Please request a new one.</div>';
                }
            } else {
                echo '<div class="ui error message">Invalid reset token or email. Please try again.</div>';
            }
        } else {
            echo '<div class="ui error message">Invalid reset token or email. Please try again.</div>';
        }
    } else {
        echo '<div class="ui error message">Passwords do not match. Please try again.</div>';
    }
}
?>



<!DOCTYPE html>
<html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/reset.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/site.css">

    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/container.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/grid.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/header.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/image.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/menu.css">

    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/divider.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/segment.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/form.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/input.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/button.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/list.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/message.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/icon.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/semantic.min.css">
</head>

<body>
    <div class="ui container">
        <h2>Reset Password</h2>
        <form class="ui form" method="post" action="ResetPassword.php?token=<?php echo $resetToken; ?>">
            <input type="hidden" name="reset_token" value="<?php echo $resetToken; ?>">
            <div class="field">
                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" id="new_password" required>
            </div>
            <div class="field">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
            </div>
            <button class="ui primary button" type="submit" name="submit">Reset Password</button>
        </form>
    </div>
    
    <script src="../Fomantic-ui/dist/semantic.min.js"></script>
    <script src="../Fomantic-ui/dist/components/form.js"></script>
    <script src="../Fomantic-ui/dist/components/transition.js"></script>

</body>
</html>

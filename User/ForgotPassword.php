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
                $mail->Username = 'onelibraryofficial@gmail.com';
                $mail->Password = 'xvzq rxjl ehjp gasi';
                $mail->addReplyTo('onelibraryofficial@gmail.com', 'One Library');
                $mail->setFrom('onelibraryofficial@gmail.com', 'One Library');
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
    <link rel="icon" href="../logo/favicon.ico" type="image/x-icon">
    <title>Forgot Password</title>
</head>

<body>
    <div class="fpBox">
       <span><button class="backButton" onclick="window.location.href='UserLogin.php'"><i class="arrow left icon"></i></button></span>
       <span class="ui header" id="fpText"><p>FORGOT PASSWORD</p></span>
        <p class="EnterPassword">Enter your email address below to request a password reset.</p>
        <form class="" action="ForgotPassword.php" method="post">
   
        <div class="lboxcss">
                        <input type="email" class="lbox-input" name="email" id="email" autocomplete="off" required>
                        <label for="text" class="label-name">
                            <span class="content-name">
                            Email
                            </span>
                        </label>
                    </div>
            <button class="ui black button requestButton" id="request" type="submit" name="submit">Request Reset</button>

        </form>
    </div>


    <div class="mountain">
      <div class="mountain-top">
        <div class="mountain-cap-1"></div>
        <div class="mountain-cap-2"></div>
        <div class="mountain-cap-3"></div>
      </div>
    </div>
    <div class="mountain-two">
      <div class="mountain-top">
        <div class="mountain-cap-1"></div>
        <div class="mountain-cap-2"></div>
        <div class="mountain-cap-3"></div>
      </div>
    </div>
    <div class="mountain-three">
      <div class="mountain-top">
        <div class="mountain-cap-1"></div>
        <div class="mountain-cap-2"></div>
        <div class="mountain-cap-3"></div>
      </div>
    </div>
    <!-- <div class="cloud"></div> -->


    <div style="position:absolute; bottom:0; width:100%;">
      <svg id="" preserveAspectRatio="xMidYMax meet" class="svg-separator sep1" viewBox="0 0 1600 160"
        style="z-index:7; background:transparent;" data-height="100">
        <path class="animated-path" style="opacity: 1;fill: #ddd;" d="M1040,56c0.5,0,1,0,1.6,0c-16.6-8.9-36.4-15.7-66.4-15.7c-56,0-76.8,23.7-106.9,41C881.1,89.3,895.6,96,920,96
C979.5,96,980,56,1040,56z"></path>
        <path class="animated-path" style="opacity: 1;" d="M1699.8,96l0,10H1946l-0.3-6.9c0,0,0,0-88,0s-88.6-58.8-176.5-58.8c-51.4,0-73,20.1-99.6,36.8
c14.5,9.6,29.6,18.9,58.4,18.9C1699.8,96,1699.8,96,1699.8,96z"></path>
        <path class="animated-path" style="opacity: 1;" d="M1400,96c19.5,0,32.7-4.3,43.7-10c-35.2-17.3-54.1-45.7-115.5-45.7c-32.3,0-52.8,7.9-70.2,17.8
c6.4-1.3,13.6-2.1,22-2.1C1340.1,56,1340.3,96,1400,96z"></path>
        <path class="animated-path" style="opacity: 1;" d="M320,56c6.6,0,12.4,0.5,17.7,1.3c-17-9.6-37.3-17-68.5-17c-60.4,0-79.5,27.8-114,45.2
c11.2,6,24.6,10.5,44.8,10.5C260,96,259.9,56,320,56z"></path>
        <path class="animated-path" style="opacity: 1;" d="M680,96c23.7,0,38.1-6.3,50.5-13.9C699.6,64.8,679,40.3,622.2,40.3c-30,0-49.8,6.8-66.3,15.8
c1.3,0,2.7-0.1,4.1-0.1C619.7,56,620.2,96,680,96z"></path>
        <path class="animated-path" style="opacity: 1;" d="M-40,95.6c28.3,0,43.3-8.7,57.4-18C-9.6,60.8-31,40.2-83.2,40.2c-14.3,0-26.3,1.6-36.8,4.2V106h60V96L-40,95.6
z"></path>
        <path class="animated-path" style="opacity: 1;" d="M504,73.4c-2.6-0.8-5.7-1.4-9.6-1.4c-19.4,0-19.6,13-39,13c-19.4,0-19.5-13-39-13c-14,0-18,6.7-26.3,10.4
C402.4,89.9,416.7,96,440,96C472.5,96,487.5,84.2,504,73.4z"></path>
        <path class="animated-path" style="opacity: 1;" d="M1205.4,85c-0.2,0-0.4,0-0.6,0c-19.5,0-19.5-13-39-13s-19.4,12.9-39,12.9c0,0-5.9,0-12.3,0.1
c11.4,6.3,24.9,11,45.5,11C1180.6,96,1194.1,91.2,1205.4,85z"></path>
        <path class="animated-path" style="opacity: 1;" d="M1447.4,83.9c-2.4,0.7-5.2,1.1-8.6,1.1c-19.3,0-19.6-13-39-13s-19.6,13-39,13c-3,0-5.5-0.3-7.7-0.8
c11.6,6.6,25.4,11.8,46.9,11.8C1421.8,96,1435.7,90.7,1447.4,83.9z"></path>
        <path class="animated-path" style="opacity: 1;" d="M985.8,72c-17.6,0.8-18.3,13-37,13c-19.4,0-19.5-13-39-13c-18.2,0-19.6,11.4-35.5,12.8
c11.4,6.3,25,11.2,45.7,11.2C953.7,96,968.5,83.2,985.8,72z"></path>
        <path class="animated-path" style="opacity: 1;" d="M743.8,73.5c-10.3,3.4-13.6,11.5-29,11.5c-19.4,0-19.5-13-39-13s-19.5,13-39,13c-0.9,0-1.7,0-2.5-0.1
c11.4,6.3,25,11.1,45.7,11.1C712.4,96,727.3,84.2,743.8,73.5z"></path>
        <path class="animated-path" style="opacity: 1;" d="M265.5,72.3c-1.5-0.2-3.2-0.3-5.1-0.3c-19.4,0-19.6,13-39,13c-19.4,0-19.6-13-39-13
c-15.9,0-18.9,8.7-30.1,11.9C164.1,90.6,178,96,200,96C233.7,96,248.4,83.4,265.5,72.3z"></path>
        <path class="animated-path" style="opacity: 1;" d="M1692.3,96V85c0,0,0,0-19.5,0s-19.6-13-39-13s-19.6,13-39,13c-0.1,0-0.2,0-0.4,0c11.4,6.2,24.9,11,45.6,11
C1669.9,96,1684.8,96,1692.3,96z"></path>
        <path class="animated-path" style="opacity: 1;"
          d="M25.5,72C6,72,6.1,84.9-13.5,84.9L-20,85v8.9C0.7,90.1,12.6,80.6,25.9,72C25.8,72,25.7,72,25.5,72z"></path>
        <path class="animated-path" style="" d="M-40,95.6C20.3,95.6,20.1,56,80,56s60,40,120,40s59.9-40,120-40s60.3,40,120,40s60.3-40,120-40
s60.2,40,120,40s60.1-40,120-40s60.5,40,120,40s60-40,120-40s60.4,40,120,40s59.9-40,120-40s60.3,40,120,40s60.2-40,120-40
s60.2,40,120,40s59.8,0,59.8,0l0.2,143H-60V96L-40,95.6z"></path>

        <animate attributeName="d" dur="3s" repeatCount="indefinite"
          values="M10 80 Q 95 10 180 80; M10 80 Q 180 150 320 80; M10 80 Q 95 10 180 80" />
      </svg>

</body>

</html>

<style>
    /* ................................................................................................................ */
    /* no need add to mian css */
    @keyframes move {
    0% {
      transform: translateX(0);
    }

    50% {
      transform: translateX(-90px);
    }

    100% {
      transform: translateX(0);
    }
  }

  .animated-path {
    animation: move 16s ease-in-out infinite;
  }


  .svg-separator {
    display: block;
    background: 0 0;
    position: relative;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 20;
    -webkit-transform: translateY(0%) translateY(2px);
    transform: translateY(0%) translateY(2px);
    width: 100%;
    filter: unset;
  }

  .svg-separator path {
    fill: #F5F7F8 !important;
  }

  .svg-separator.bottom {
    top: auto;
    bottom: 0;
  }

  .sep1 {
    transform: translateY(0%) translateY(0px) scale(1, 1);
    transform-origin: top;
  }



  .mountain, .mountain-two, .mountain-three {
    position: absolute;
    bottom: 0;
    border-left: 270px solid transparent;
    border-right: 270px solid transparent;
    border-bottom: 300px solid #2b9cd4;
    z-index: 1;
}
.mountain-two { 
    left: 80px;
    bottom: 0px;
    opacity: .3;
    z-index: 0;
}
.mountain-three {
    left: -60px;
    bottom:0px;
    opacity: .5;
    z-index: 0;
}
.mountain-top {
    position: absolute;
    right: -65px;
    border-left: 65px solid transparent;
    border-right: 65px solid transparent;
    border-bottom: 77px solid #ceeaf6;
    z-index: 2;
}
.mountain-cap-1, .mountain-cap-2, .mountain-cap-3 {
    position: absolute;
    top: 70px;
    border-left: 25px solid transparent;
    border-right: 25px solid transparent;
    border-top: 25px solid #ceeaf6;
}
.mountain-cap-1 { left: -55px; }
.mountain-cap-2 { left: -25px; }
.mountain-cap-3 { left: 5px; }
.cloud, .cloud:before, .cloud:after {
  position: absolute;
  width: 150px;
	height: 100px;
	background: #fff;
	-webkit-border-radius: 100px / 50px;
	border-radius: 100px / 50px;
}
.cloud { 
  bottom: 100px;
  -webkit-animation: cloud 50s infinite linear;
          animation: cloud 50s infinite linear;
}
@-webkit-keyframes cloud {
    0%   { left: -100px; }
    100% { left: 1000px; } 
}
@keyframes cloud {
   
    0%   { left: -100px; }
    100% { left: 1000px; } 
}
.cloud:before {
  content: '';
  left: 50px;
}
.cloud:after {
  content: '';
  left: 25px;
  top: -10px;
}
/* ................................................................................................................ */



 body{
    background: radial-gradient(ellipse at bottom, #F6F4EB 0%, #91C8E4 100%);
 }
.fpBox{
    background: #FFFBF5;
    border:4px solid #000;
    border-radius:10px;
    /* margin:260px auto; */
    padding:30px;
    width:30%;
    height:300px;
    position: relative;
    top: 45%;
        left: 50%;
        transform: translate(-50%, -50%);
}
.fpBox #fpText{
    text-align:center;
}
.fpBox .EnterPassword {
    font-weight: bold;
    padding: 10px 0px; /* 增加一点 padding 以便留出下方的空间 */
    position: relative;
    transform: translateY(15px); /* 向下移动 3px，可以根据需要进行微调 */
}

.backButton{
    background: transparent; 
    border:0px;
    font-size:20px;
    cursor: pointer;
    position:absolute;
}
.requestButton{
    position:absolute;
    bottom:20px;
    width: calc(100% - 55px);
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
<?php
include_once('../db.php');

if (!isset($_SESSION['operation_status'])) {
  $_SESSION['operation_status'] = null;
}

if (isset($_POST['submit'])) {
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];

    // Add password validation
    $password = $_POST['user_password'];
    $confirm_password = $_POST['confirm_password'];

    if (strlen($password) < 8 || $password !== $confirm_password) {
        $_SESSION['operation_status'] = 'InvalidPassword';
    } else {
        // Password meets the minimum length requirement and matches the confirm password
        $user_password = password_hash($password, PASSWORD_DEFAULT);

        // Your existing code for database insertion
        $user_contact = $_POST['user_contact'];
        $user_signupdate = date("Y-m-d");
        $user_status = 'Active';

        $SignUp = "INSERT INTO user (`user_name`, `user_email`, `user_password`, `user_contact`, `user_signupdate`, `user_status`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $SignUp);

        if ($stmt === false) {
            die("mysqli_prepare failed: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "ssssss", $user_name, $user_email, $user_password, $user_contact, $user_signupdate, $user_status);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['operation_status'] = true;
        } else {
            $_SESSION['operation_status'] = 'error';
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/semantic.min.css">
  <link rel="icon" href="../logo/favicon.ico" type="image/x-icon">
  <title>Digital Library</title>
  <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
  <script src="Assets/plugins/sweetalert2/sweetalert2.all.js"></script>
    <script src="Assets/plugins/toastr/toastr.min.js"></script>
    <script src="Assets/js/SweetAlert.js"></script>
</head>

<body>

<?php
if (isset($_SESSION["operation_status"]) && $_SESSION["operation_status"] === true) {
  echo '<script>successToast(' . json_encode("Sign Up Success, Redirecting...") . ')</script>';
  header("Refresh: 1; url=UserLogin.php");
  $_SESSION['operation_status'] = null;
  exit();
} elseif (isset($_SESSION["operation_status"]) && $_SESSION["operation_status"] === 'InvalidPassword') {
  echo '<script>failToast(' . json_encode("Password must be at least 8 characters long and match Confirm Password.") . ')</script>';
} elseif (isset($_SESSION["operation_status"]) && $_SESSION["operation_status"] === 'error') {
  echo '<script>failToast(' . json_encode("An error occurred during sign up.") . ')</script>';
}


// Reset session variable
$_SESSION['operation_status'] = null;
?>

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


  <div class="ui login-box">
    <a href="UserLogin.php" style="position:absolute; top:20px; color:#000; font-size:20px;"><i
        class="arrow left icon"></i></a>
    <div class="login-form">
      <form action="SignUp.php" method="POST" class="ui">
        <h1 class="ui header" id="header">SIGN UP</h1>

        <div class="lboxcss">
          <input type="text" class="lbox-input" name="user_name" autocomplete="off" required>
          <label for="text" class="label-name">
            <span class="content-name">
              Username
            </span>
          </label>
        </div>


        <div class="lboxcss" style="margin-top: 20px;">
          <input type="text" class="lbox-input" name="user_email" autocomplete="off" required>
          <label for="text" class="label-name">
            <span class="content-name">
              E-mail
            </span>
          </label>
        </div>

        <div class="lboxcss" style="margin-top: 20px;">
          <button id="showPasswordButton" type="button">
            <i id="showPasswordIcon" class="eye icon"></i>
          </button>
          <input type="password" id="passwordInput" class="lbox-input" name="user_password" autocomplete="off" required>
          <label for="passwordInput" class="label-name">
            <span class="content-name">
              Password
            </span>
          </label>
        </div>

        <div class="lboxcss" style="margin-top: 20px;">
          <button id="showPasswordButton2" type="button">
            <i id="showPasswordIcon2" class="eye icon"></i>
          </button>
          <input type="password" id="passwordInput2" class="lbox-input" name="confirm_password" autocomplete="off"
            required>
          <label for="passwordInput2" class="label-name">
            <span class="content-name">
              Confirm Password
            </span>
          </label>
        </div>

        <div class="lboxcss">
          <input type="number" class="lbox-input" name="user_contact" pattern="(\+60|0)[0-9]{9}" autocomplete="off"
            required>
          <label for="text" class="label-name">
            <span class="content-name">
              Contact
            </span>
          </label>
        </div>

        <input type="hidden" name="user_status" value="Active">
        <button type="submit" name="submit" class="ui black button" id="signup-button">Sign Up</button>

      </form>
    </div>

  </div>

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
<script src="../Fomantic-ui/dist/semantic.min.js"></script>
<script src="Assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="Assets/plugins/toastr/toastr.min.js"></script>

<script>
  const passwordInput = document.getElementById("passwordInput");
  const showPasswordButton = document.getElementById("showPasswordButton");
  const showPasswordIcon = document.getElementById("showPasswordIcon");

  const passwordInput2 = document.getElementById("passwordInput2");
  const showPasswordButton2 = document.getElementById("showPasswordButton2");
  const showPasswordIcon2 = document.getElementById("showPasswordIcon2");

  showPasswordButton.addEventListener("click", function () {
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      showPasswordIcon.className = "eye slash icon";
    } else {
      passwordInput.type = "password";
      showPasswordIcon.className = "eye icon";
    }
  });

  showPasswordButton2.addEventListener("click", function () {
    if (passwordInput2.type === "password") {
      passwordInput2.type = "text";
      showPasswordIcon2.className = "eye slash icon";
    } else {
      passwordInput2.type = "password";
      showPasswordIcon2.className = "eye icon";
    }
  });
</script>
<style type="text/css">
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

  .mountain,
  .mountain-two,
  .mountain-three {
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
    bottom: 0px;
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

  .mountain-cap-1,
  .mountain-cap-2,
  .mountain-cap-3 {
    position: absolute;
    top: 70px;
    border-left: 25px solid transparent;
    border-right: 25px solid transparent;
    border-top: 25px solid #ceeaf6;
  }

  .mountain-cap-1 {
    left: -55px;
  }

  .mountain-cap-2 {
    left: -25px;
  }

  .mountain-cap-3 {
    left: 5px;
  }

  .cloud,
  .cloud:before,
  .cloud:after {
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
    0% {
      left: -100px;
    }

    100% {
      left: 1000px;
    }
  }

  @keyframes cloud {

    0% {
      left: -100px;
    }

    100% {
      left: 1000px;
    }
  }

  .cloud:before {
    content: '';
    left: 50px;
  }

    .login-form{
      width:100%;
      padding:20px 20px;
    }
  .cloud:after {
    content: '';
    left: 25px;
    top: -10px;
  }

  /* ............................................................................................... */
  body {
    background: radial-gradient(ellipse at bottom, #F6F4EB 0%, #91C8E4 100%);
    /* background: radial-gradient(ellipse at bottom, #6499E9 0%, #071952 100%); */
  }

  body>.grid {
    height: 100%;
  }

  .login-box {
    background: #FFFBF5;
    height: 570px;
    width: 500px;
    padding: 15px;
    position: absolute;
    top: 45%;
    left: 50%;
    transform: translate(-50%, -50%);
    border: 4px solid #000;
    border-radius: 20px;
    display: flex;
  }

  .login-bg {
    background-image: url('../pic/pyh.jpg');
    background-size: cover;
    background-position: center;
    width: 50%;
    border-radius: 16px;
    border: 4px solid #000;
  }

  .login-form {
    width: 100%;
    padding: 20px 50px;
  }

  .login-form #header {
    text-align: center;
    letter-spacing: 10px;
  }

  .login-text {
    width: 90%;
    margin: auto;
    padding: 20px 0px;
  }

  .login-text .forgot-password {
    float: right;
    font-weight: 900;
  }

  .login-text .forgot-password:hover {
    text-decoration: underline;
  }

  .login-text .signup {
    font-weight: 900;
  }

  .login-text .signup:hover {
    text-decoration: underline;
  }

  .logo {
    text-align: center;
  }

  .logo p {
    font-size: 30px;
    font-weight: 900;
    letter-spacing: 10px;
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

  #showPasswordButton2 {
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


  #signup-button {
    width: 100%;
    transition: 0.4s;
    margin: 35px 0px;
  }
</style>
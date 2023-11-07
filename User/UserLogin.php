  <?php
  include_once('../db.php');

  if (isset($_POST['submit'])) {
    if (!empty($_POST['user_name']) && !empty($_POST['user_pass'])) {
      $user_name = $_POST['user_name'];
      $user_pass = $_POST['user_pass'];

      $query = "SELECT * FROM `user` WHERE `user_name`=?";

      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "s", $user_name);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);

        if (password_verify($user_pass, $row['user_password'])) {
          $_SESSION['id'] = $row['user_id'];
          $_SESSION['user_id'] = $row['user_id'];
          $_SESSION['user_name'] = $row['user_name'];
          $_SESSION['user_email'] = $row['user_email'];
          $_SESSION['user_contact'] = $row['user_contact'];

          header("Location: UserIndex.php");
          exit();
        } else {
          echo "<script>alert('Wrong Password, Please try again');</script>";
        }
      } else {
        echo "<script>alert('User does not exist, Please try again');</script>";
      }

      mysqli_stmt_close($stmt);
    } else {
      echo "<script>alert('Please Insert Username and Password');</script>";
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
    <!-- <link rel="stylesheet" type="text/css" href="Main.css"> -->
    <!-- <link rel="stylesheet" href="Utility.css"> -->
    <title>Digital Library</title>
  </head>

  <body>
  
  <div class="ui login-box">
      <div class="login-bg">
        <img src="" alt="">
      </div>
      <div class="login-form">
      <form class="" action="UserLogin.php" method="POST">
        <div class="login-text">

        <div class="logo">
          <p>LOGIN</p>
        </div>

            <div class="lboxcss">
            <input type="text" class="lbox-input" name="user_name" autocomplete="off" required >
              <label for="text" class="label-name">
              <span class="content-name">
                Username
              </span>
              </label>
            </div>

            <div class="lboxcss" style="margin-top: 20px;">
            <button id="showPasswordButton" type="button">
            <i id="showPasswordIcon" class="eye icon"></i>
        </button>
        <input type="password" id="passwordInput" class="lbox-input" name="user_pass" autocomplete="off" required>
    <label for="passwordInput" class="label-name">
        <span class="content-name">
            Password
        </span>
    </label>
</div>
            
            <a class="forgot-password" href="ForgotPassword.php">Forgotten Password</a>

            <div class="login-function">
            <button type='submit' name='submit' value='submit' class="ui black button" id="login-button">Login</button>
            <div class="ui horizontal divider">
            Or
            </div>
            <span>New to us? <a class="signup" href="SignUp.php">Sign Up</a></span>
            </div>

          <!-- <div class="ui error message"></div> -->
        </div>
      </form>
      </div>
  </div>

  </body>

  </html>
  <script>
        const passwordInput = document.getElementById("passwordInput");
      const showPasswordButton = document.getElementById("showPasswordButton");
      const showPasswordIcon = document.getElementById("showPasswordIcon");

      showPasswordButton.addEventListener("click", function () {
          if (passwordInput.type === "password") {
              passwordInput.type = "text"; // Show the password
              showPasswordIcon.className = "eye slash icon"; // Change the icon class
          } else {
              passwordInput.type = "password"; // Hide the password
              showPasswordIcon.className = "eye icon"; // Change the icon class
          }
      });
  </script>
  <style type="text/css">
    body {
      background-color: #eeeeee;
    }

    body>.grid {
      height: 100%;
    }

    .login-box{
      background:#FFFBF5;
      height:570px;
      width:1200px;
      padding:15px;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      border:4px solid #000;
      border-radius:20px;
      display:flex;
    }
    .login-bg{
      background-image:url('../pic/pyh.jpg');
      background-size:cover;
      background-position:center;
      width:50%;
      border-radius:16px;
      border:4px solid #000;
    }
    .login-form{
      width:50%;
    }
    .login-text{
      width:90%;
      margin:auto;
      padding:20px 0px;
    }
    .login-text .forgot-password{
      float:right;
      font-weight:900;
    }
    .login-text .forgot-password:hover{
      text-decoration: underline;
    }
    .login-text .signup{
      font-weight:900;
    }
    .login-text .signup:hover{
      text-decoration: underline; 
    }
    .logo{
      text-align:center;
    }
    .logo p{
      font-size:30px;
      font-weight:900;
      letter-spacing:10px;
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


  .login-function{
      position:absolute;
      width:44%;
      text-align:center;
      margin:200px 0px;
    }
  .login-function #login-button{
      width:100%;
      transition:0.4s;
      margin:4px 0px;
    }

  
  </style>

  <script src="../Fomantic-ui/dist/semantic.min.js"></script>
  <!-- <script src="assets/library/jquery.min.js"></script> -->
  <script src="../Fomantic-ui/dist/components/form.js"></script>
  <script src="../Formantic-ui/dist/components/transition.js"></script>
<?php
include_once('../db.php');

if (isset($_POST['submit'])) {
    $errors = array();

    if (empty($_POST['user_name'])) {
        $errors['user_name'] = "Username is required.";
    }
    if (empty($_POST['user_email'])) {
        $errors['user_email'] = "Your Email is required.";
    }
    if (empty($_POST['user_password'])) {
        $errors['user_password'] = "Password is required.";
    }
    if ($_POST['user_password'] !== $_POST['confirm_password']) {
        $errors['confirm_password'] = "Confirm Password and Password didn't match.";
    }
    if (empty($_POST['user_contact'])) {
        $errors['user_contact'] = "Your Contact is required.";
    }
    //  elseif (!preg_match('/^(\+?60|0)(\d{9})$/', $_POST['user_contact'])) {
    //     $errors['user_contact'] = 'Invalid Malaysian phone number format. Please use the format +60xxxxxxxxx or 0xxxxxxxxx.';
    // }
    

    if (empty($errors)) {
        $user_name = $_POST['user_name'];
        $user_email = $_POST['user_email'];
        $user_password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
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
            header('location: UserLogin.php');
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
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
      <div class="login-form">
      <form action="SignUp.php" method="POST" class="ui">
        <h1 class="ui header" id="header">SIGN UP</h1>

        <div class="lboxcss">
            <input type="text" class="lbox-input" name="user_name" autocomplete="off" required >
              <label for="text" class="label-name">
              <span class="content-name">
                Username
              </span>
              </label>
              <?php if (isset($errors['user_name'])) { ?>
                <div class="ui pointing red basic label"><?php echo $errors['user_name']; ?></div>
            <?php } ?>
            </div>


            <div class="lboxcss" style="margin-top: 20px;">
            <input type="text" class="lbox-input" name="user_email" autocomplete="off" required >
              <label for="text" class="label-name">
              <span class="content-name">
                E-mail
              </span>
              </label>
              <?php if (isset($errors['user_email'])) { ?>
                <div class="ui pointing red basic label"><?php echo $errors['user_email']; ?></div>
            <?php } ?>
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
               <?php if (isset($errors['user_password'])) { ?>
                <div class="ui pointing red basic label"><?php echo $errors['user_password']; ?></div>
               <?php } ?>
           </div>

           <div class="lboxcss" style="margin-top: 20px;">
             <button id="showPasswordButton2" type="button">
             <i id="showPasswordIcon2" class="eye icon"></i>
             </button>
               <input type="password" id="passwordInput2" class="lbox-input" name="confirm_password" autocomplete="off" required>
                <label for="passwordInput2" class="label-name">
                   <span class="content-name">
                      Confrim Password
                   </span>
                </label>
              <?php if (isset($errors['confirm_password'])) { ?>
               <div class="ui pointing red basic label"><?php echo $errors['confirm_password'] ?? ''; ?></div>
              <?php } ?>
          </div>

       <div class="lboxcss">
            <input type="number" class="lbox-input" name="user_contact" pattern="(\+60|0)[0-9]{9}" autocomplete="off" required >
              <label for="text" class="label-name">
              <span class="content-name">
              Contact
              </span>
              </label>
              <?php if (isset($errors['user_contact'])) { ?>
                <div class="ui pointing red basic label"><?php echo $errors['user_contact']; ?></div>
            <?php } ?>
            </div>
           
             <input type="hidden" name="user_status" value="Active">
        <button type="submit" name="submit" class="ui black button" id="signup-button">Sign Up</button>
            
    </form>
      </div>
      <div class="login-bg">
        <img src="" alt="">
      </div>
  </div>

  </body>

  </html>
  <script>
        const passwordInput = document.getElementById("passwordInput");
      const showPasswordButton = document.getElementById("showPasswordButton");
      const showPasswordIcon = document.getElementById("showPasswordIcon");

      const passwordInput2 = document.getElementById("passwordInput2");
      const showPasswordButton2 = document.getElementById("showPasswordButton2");
      const showPasswordIcon2 = document.getElementById("showPasswordIcon2");

      showPasswordButton.addEventListener("click", function () {
          if (passwordInput.type === "password") {
              passwordInput.type = "text"; // Show the password
              showPasswordIcon.className = "eye slash icon"; // Change the icon class
          } else {
              passwordInput.type = "password"; // Hide the password
              showPasswordIcon.className = "eye icon"; // Change the icon class
          }
      });

      showPasswordButton2.addEventListener("click", function () {
          if (passwordInput2.type === "password") {
              passwordInput2.type = "text"; // Show the password
              showPasswordIcon2.className = "eye slash icon"; // Change the icon class
          } else {
              passwordInput2.type = "password"; // Hide the password
              showPasswordIcon2.className = "eye icon"; // Change the icon class
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
      padding:30px 50px;
    }

    .login-form #header{
      text-align:center;
      letter-spacing:10px;
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

          #showPasswordButton2{
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


  #signup-button{
      width:100%;
      transition:0.4s;
      margin:35px 0px;
    }

  
  </style>

  <script src="../Fomantic-ui/dist/semantic.min.js"></script>
  <!-- <script src="assets/library/jquery.min.js"></script> -->
  <script src="../Fomantic-ui/dist/components/form.js"></script>
  <script src="../Fomantic-ui/dist/components/transition.js"></script>
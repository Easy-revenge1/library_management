<?php
include_once('../db.php');

if (isset($_POST['submit'])) {
    $errors = array();

    if (empty($_POST['user_name'])) {
        $errors['user_name'] = 'Username is required.';
    }
    if (empty($_POST['user_email'])) {
        $errors['user_email'] = 'Your Email is required.';
    }
    if (empty($_POST['user_password'])) {
        $errors['user_password'] = 'Password is required.';
    }
    if ($_POST['user_password'] !== $_POST['confirm_password']) {
        $errors['confirm_password'] = 'Confirm Password and Password didnt match.';
    }
    if (empty($_POST['user_contact'])) {
        $errors['user_contact'] = 'Your Contact is required.';
    }

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
            // echo "Thanks for using our services, Now heading you to Login Page";
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
    <title>Document</title>
</head>

<body>
    <form action="SignUp.php" method="POST" class="ui form">
        <h1 class="ui header">Sign Up</h1>
        <div class="field">
            <label>Username</label>
            <input type="text" name="user_name" placeholder="Username">
            <?php if (isset($errors['user_name'])) { ?>
                <div class="ui pointing red basic label"><?php echo $errors['user_name']; ?></div>
            <?php } ?>
        </div>
        <div class="field">
            <label>Email</label>
            <input type="email" name="user_email" placeholder="Email">
            <?php if (isset($errors['user_email'])) { ?>
                <div class="ui pointing red basic label"><?php echo $errors['user_email']; ?></div>
            <?php } ?>
        </div>
        <div class="field">
            <label>Password</label>
            <input type="password" name="user_password" placeholder="Password">
            <?php if (isset($errors['user_password'])) { ?>
                <div class="ui pointing red basic label"><?php echo $errors['user_password']; ?></div>
            <?php } ?>
        </div>
        <div class="field">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" placeholder="Confirm Password">
            <?php if (isset($errors['confirm_password'])) { ?>
                <div class="ui pointing red basic label"><?php echo $errors['confirm_password'] ?? ''; ?></div>
            <?php } ?>
        </div>
        <div class="field">
            <label>Contact</label>
            <input type="number" name="user_contact" placeholder="Contact">
            <?php if (isset($errors['user_contact'])) { ?>
                <div class="ui pointing red basic label"><?php echo $errors['user_contact']; ?></div>
            <?php } ?>
        </div>
        <input type="hidden" name="user_status" value="Active">
        <button type="submit" name="submit" class="ui primary button">Sign Up</button>
    </form>

</body>

</html>

<script src="../Fomantic-ui/dist/semantic.min.js"></script>
<!-- <script src="assets/library/jquery.min.js"></script> -->
<script src="../Fomantic-ui/dist/components/form.js"></script>
<script src="../Formantic-ui/dist/components/transition.js"></script>
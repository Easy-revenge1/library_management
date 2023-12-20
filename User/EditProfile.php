<?php
include_once('../db.php');
// include_once('NavigationBar.php');

if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
    header("Location: UserLogin.php");
    exit();
}

$user_id = $_GET['user_id'];

if (isset($_SESSION['operation_success'])) {
    $_SESSION['operation_success'] = null;
}


$UserProfile = "SELECT * FROM `user` WHERE `user_id` = ?";

$stmt = mysqli_prepare($conn, $UserProfile);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);


if (isset($_POST['submit'])) {
    $user_id = $_GET['user_id'];
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_contact = $_POST['user_contact'];

    $backgroundPicUpload = $row['user_profilebackground'];
    if (isset($_FILES['background_picture']) && $_FILES['background_picture']['error'] === UPLOAD_ERR_OK) {
        $uploadPath = '../BackgroundPic/';
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $maxFileSize = 5 * 1024 * 1024;

        if (!in_array($_FILES['background_picture']['type'], $allowedTypes) || $_FILES['background_picture']['size'] > $maxFileSize) {
            echo "Invalid file. Please upload a valid image file (JPEG, PNG, JPG) with a maximum size of 5 MB.";
        } else {
            $backgroundPicUpload = $uploadPath . $user_id . '_' . uniqid() . '_' . basename($_FILES['background_picture']['name']);
            if (move_uploaded_file($_FILES['background_picture']['tmp_name'], $backgroundPicUpload)) {
                // echo "Background file uploaded successfully.";
            } else {
                echo "Failed to move the uploaded background file.";
            }
        }
    }

    $profilePicUpload = $row['user_profilepicture'];
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../ProfilePic/';
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $maxFileSize = 5 * 1024 * 1024;

        if (!in_array($_FILES['profile_picture']['type'], $allowedTypes) || $_FILES['profile_picture']['size'] > $maxFileSize) {
            echo "Invalid file. Please upload a valid image file (JPEG, PNG, JPG) with a maximum size of 5 MB.";
        } else {
            $profilePicUpload = $uploadDir . $user_id . '_' . uniqid() . '_' . basename($_FILES['profile_picture']['name']);
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profilePicUpload)) {
                // echo "Profile file uploaded successfully. Path: $profilePicUpload";
            } else {
                // echo "Failed to move the uploaded profile file.";
            }
        }
    }

    $query = "UPDATE `user` SET `user_name` = ?, `user_email` = ?, `user_contact` = ?, `user_profilepicture` = ?, `user_profilebackground` = ? WHERE `user_id` = ?";

    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "sssssi", $user_name, $user_email, $user_contact, $profilePicUpload, $backgroundPicUpload, $user_id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['operation_success'] = true;
        } else {
            $_SESSION['operation_success'] = "error";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing the statement: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/semantic.min.css">
    <link rel="icon" href="../logo/favicon.ico" type="image/x-icon">
    <title>Edit Profile</title>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="Assets/plugins/sweetalert2/sweetalert2.all.js"></script>
    <script src="Assets/plugins/toastr/toastr.min.js"></script>
    <script src="Assets/js/SweetAlert.js"></script>
</head>

<body>

    <?php

    if (isset($_SESSION["operation_success"]) && $_SESSION["operation_success"] === true) {
        echo '<script>successToast(' . json_encode("Profile Edited, Redirecting...") . ')</script>';
        header("Refresh: 1; url=Userprofile.php");
        exit();
    }

    ?>

    <!-- <div style="height:25px;"></div> -->
    <a href="userProfile.php" class="backButton"><i class="arrow left icon"></i></a>

    <form action="EditProfile.php?user_id=<?php echo $user_id ?>" method="POST" enctype="multipart/form-data">

        <div class="edit-box">
            <div class="user-image">
                <input type="file" name="background_picture" id="backgroundPicInput" accept="image/*"
                    style="display: none;">
                <button type="button" class="hidden-button">Change Background</button>
                <img src="<?php echo $row['user_profilebackground'] ? $row['user_profilebackground'] : '../BackgroundPic/pyh.jpg'; ?>"
                    id="userBG" class="user-background" alt="background">

                <div style="position:absolute; bottom:0; width:100%;">
                    <svg id="" preserveAspectRatio="xMidYMax meet" class="svg-separator sep1" viewBox="0 0 1600 160"
                        style="z-index:7; background:transparent;" data-height="100">
                        <path style="opacity: 1;fill: #ddd;" d="M1040,56c0.5,0,1,0,1.6,0c-16.6-8.9-36.4-15.7-66.4-15.7c-56,0-76.8,23.7-106.9,41C881.1,89.3,895.6,96,920,96
C979.5,96,980,56,1040,56z"></path>
                        <path style="opacity: 1;" d="M1699.8,96l0,10H1946l-0.3-6.9c0,0,0,0-88,0s-88.6-58.8-176.5-58.8c-51.4,0-73,20.1-99.6,36.8
c14.5,9.6,29.6,18.9,58.4,18.9C1699.8,96,1699.8,96,1699.8,96z"></path>
                        <path style="opacity: 1;" d="M1400,96c19.5,0,32.7-4.3,43.7-10c-35.2-17.3-54.1-45.7-115.5-45.7c-32.3,0-52.8,7.9-70.2,17.8
c6.4-1.3,13.6-2.1,22-2.1C1340.1,56,1340.3,96,1400,96z"></path>
                        <path style="opacity: 1;" d="M320,56c6.6,0,12.4,0.5,17.7,1.3c-17-9.6-37.3-17-68.5-17c-60.4,0-79.5,27.8-114,45.2
c11.2,6,24.6,10.5,44.8,10.5C260,96,259.9,56,320,56z"></path>
                        <path style="opacity: 1;" d="M680,96c23.7,0,38.1-6.3,50.5-13.9C699.6,64.8,679,40.3,622.2,40.3c-30,0-49.8,6.8-66.3,15.8
c1.3,0,2.7-0.1,4.1-0.1C619.7,56,620.2,96,680,96z"></path>
                        <path class="" style="opacity: 1;" d="M-40,95.6c28.3,0,43.3-8.7,57.4-18C-9.6,60.8-31,40.2-83.2,40.2c-14.3,0-26.3,1.6-36.8,4.2V106h60V96L-40,95.6
z"></path>
                        <path style="opacity: 1;" d="M504,73.4c-2.6-0.8-5.7-1.4-9.6-1.4c-19.4,0-19.6,13-39,13c-19.4,0-19.5-13-39-13c-14,0-18,6.7-26.3,10.4
C402.4,89.9,416.7,96,440,96C472.5,96,487.5,84.2,504,73.4z"></path>
                        <path style="opacity: 1;" d="M1205.4,85c-0.2,0-0.4,0-0.6,0c-19.5,0-19.5-13-39-13s-19.4,12.9-39,12.9c0,0-5.9,0-12.3,0.1
c11.4,6.3,24.9,11,45.5,11C1180.6,96,1194.1,91.2,1205.4,85z"></path>
                        <path style="opacity: 1;" d="M1447.4,83.9c-2.4,0.7-5.2,1.1-8.6,1.1c-19.3,0-19.6-13-39-13s-19.6,13-39,13c-3,0-5.5-0.3-7.7-0.8
c11.6,6.6,25.4,11.8,46.9,11.8C1421.8,96,1435.7,90.7,1447.4,83.9z"></path>
                        <path style="opacity: 1;" d="M985.8,72c-17.6,0.8-18.3,13-37,13c-19.4,0-19.5-13-39-13c-18.2,0-19.6,11.4-35.5,12.8
c11.4,6.3,25,11.2,45.7,11.2C953.7,96,968.5,83.2,985.8,72z"></path>
                        <path style="opacity: 1;" d="M743.8,73.5c-10.3,3.4-13.6,11.5-29,11.5c-19.4,0-19.5-13-39-13s-19.5,13-39,13c-0.9,0-1.7,0-2.5-0.1
c11.4,6.3,25,11.1,45.7,11.1C712.4,96,727.3,84.2,743.8,73.5z"></path>
                        <path style="opacity: 1;" d="M265.5,72.3c-1.5-0.2-3.2-0.3-5.1-0.3c-19.4,0-19.6,13-39,13c-19.4,0-19.6-13-39-13
c-15.9,0-18.9,8.7-30.1,11.9C164.1,90.6,178,96,200,96C233.7,96,248.4,83.4,265.5,72.3z"></path>
                        <path style="opacity: 1;" d="M1692.3,96V85c0,0,0,0-19.5,0s-19.6-13-39-13s-19.6,13-39,13c-0.1,0-0.2,0-0.4,0c11.4,6.2,24.9,11,45.6,11
C1669.9,96,1684.8,96,1692.3,96z"></path>
                        <path style="opacity: 1;"
                            d="M25.5,72C6,72,6.1,84.9-13.5,84.9L-20,85v8.9C0.7,90.1,12.6,80.6,25.9,72C25.8,72,25.7,72,25.5,72z">
                        </path>
                        <path style="" d="M-40,95.6C20.3,95.6,20.1,56,80,56s60,40,120,40s59.9-40,120-40s60.3,40,120,40s60.3-40,120-40
s60.2,40,120,40s60.1-40,120-40s60.5,40,120,40s60-40,120-40s60.4,40,120,40s59.9-40,120-40s60.3,40,120,40s60.2-40,120-40
s60.2,40,120,40s59.8,0,59.8,0l0.2,143H-60V96L-40,95.6z"></path>

                        <!-- <animate attributeName="d" dur="3s" repeatCount="indefinite"
                            values="M10 80 Q 95 10 180 80; M10 80 Q 180 150 320 80; M10 80 Q 95 10 180 80" /> -->
                    </svg>

                </div>

            </div>


            <div class="user-edit-box">
                <div class="user-pic-box">
                    <input type="file" name="profile_picture" id="profilePictureInput" accept="image/*"
                        style="display: none;">
                    <button type="button" class="hidden-button2" id="addImageButton">Change Avatar</button>
                    <img src="<?php echo $row['user_profilepicture'] ? $row['user_profilepicture'] : '../ProfilePic/tom.jpg'; ?>"
                        class="user-pic" alt="">
                </div>


                <div class="edit-form">

                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                    <div class="lboxcss">
                        <input type="text" class="lbox-input" name="user_name" id="user_name"
                            value="<?php echo $row['user_name']; ?>" autocomplete="off" required>
                        <label for="text" class="label-name">
                            <span class="content-name">
                                Username
                            </span>
                        </label>
                    </div>

                    <div class="lboxcss">
                        <input type="email" class="lbox-input" name="user_email" id="user_email"
                            value="<?php echo $row['user_email']; ?>" autocomplete="off" required>
                        <label for="text" class="label-name">
                            <span class="content-name">
                                Email
                            </span>
                        </label>
                    </div>

                    <div class="lboxcss">
                        <input type="text" class="lbox-input" name="user_contact" id="user_contact"
                            value="<?php echo $row['user_contact']; ?>" autocomplete="off" required>
                        <label for="text" class="label-name">
                            <span class="content-name">
                                Contact
                            </span>
                        </label>
                    </div>

                    <div class="button-box">
                        <button class="ui button" type="submit" name="submit" id="updateProfileButton" disabled>Update
                            Profile</button>

                    </div>
                </div>
            </div>
        </div>
    </form>
    <div style="height:5px;"></div>
</body>

</html>

<script src="../Fomantic-ui/dist/semantic.min.js"></script>
<script src="Assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="Assets/plugins/toastr/toastr.min.js"></script>

<script>
    let userBackground = document.getElementById('userBG');

    window.addEventListener('scroll', function () {
        let value = window.scrollY;
        userBackground.style.top = value * 0.50 + 'px';
    })




    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1000
    });

    document.addEventListener('DOMContentLoaded', function () {
        var backgroundPicInput = document.getElementById('backgroundPicInput');
        var changeBackgroundButton = document.querySelector('button[type="button"]');
        var userBackground = document.querySelector('.user-background');

        changeBackgroundButton.addEventListener('click', function () {
            backgroundPicInput.click();
        });

        backgroundPicInput.addEventListener('change', function () {
            var input = this;

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    console.log('Background image loaded');
                    userBackground.src = e.target.result;
                };

                reader.readAsDataURL(input.files[0]);
            }
        });
    });



    document.addEventListener('DOMContentLoaded', function () {
        var avatarPicInput = document.getElementById('profilePictureInput');
        var addImageButton = document.getElementById('addImageButton');
        var userAvatar = document.querySelector('.user-pic');

        addImageButton.addEventListener('click', function () {
            avatarPicInput.click();
        });

        avatarPicInput.addEventListener('change', function () {
            var input = this;

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    console.log('Background image loaded');
                    userAvatar.src = e.target.result;
                };

                reader.readAsDataURL(input.files[0]);
            }
        });
    });

    var userNameInput = document.getElementById('user_name');
    var userEmailInput = document.getElementById('user_email');
    var userContactInput = document.getElementById('user_contact');
    var profilePictureInput = document.getElementById('profilePictureInput')
    var backgroundPicInput = document.getElementById('backgroundPicInput')


    var updateProfileButton = document.getElementById('updateProfileButton');

    function enableUpdateProfileButton() {
        updateProfileButton.removeAttribute('disabled');
    }

    userNameInput.addEventListener('input', enableUpdateProfileButton);
    userEmailInput.addEventListener('input', enableUpdateProfileButton);
    userContactInput.addEventListener('input', enableUpdateProfileButton);
    profilePictureInput.addEventListener('input', enableUpdateProfileButton);
    backgroundPicInput.addEventListener('input', enableUpdateProfileButton)
</script>

<style>
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

    /* ........................................................................................................ */
    .backButton {
        background: #fff;
        border-radius: 50%;
        padding: 10px;
        position: fixed;
        z-index: 30;
        margin: 20px;
        text-align: center;
    }

    .backButton i {
        color: #000;

    }

    .edit-box {
        background: #F5F7F8;
        /* border: 4px solid #000; */
        /* border-radius: 20px; */
        width: 100%;
        margin: auto;
        overflow: hidden;
    }

    .user-edit-box {
        width: 100%;
        /* display: flex; */
    }

    .user-image {
        height: 600px;
        overflow: hidden;
        position: relative;
    }

    .user-background {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        object-fit: cover;
        z-index: 1;
        transition: all 0.4s;
        overflow: hidden;
        filter: brightness(50%);
        z-index: 1;
    }

    .hidden-button {
        background: transparent;
        padding: 10px 30px;
        position: absolute;
        border: 3px solid #fff;
        color: #fff;
        border-radius: 10px;
        top: 33%;
        /* 垂直居中 */
        left: 50%;
        /* 水平居中 */
        transform: translate(-50%, -50%);
        /* 用于水平和垂直居中 */
        z-index: 2;
        transition: 0.4s;
        opacity: 0;
        /* 初始化时隐藏按钮 */
    }

    .hidden-button2 {
        background: transparent;
        padding: 10px 30px;
        position: absolute;
        border: 3px solid #fff;
        color: #fff;
        border-radius: 10px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 2;
        transition: 0.4s;
        opacity: 0;
    }

    .user-image:hover .hidden-button {
        opacity: 1;
        /* 鼠标悬停时显示按钮 */
        display: inline;
    }

    .user-image:hover .user-background {
        filter: brightness(20%);
    }



    .user-pic-box:hover .hidden-button2 {
        opacity: 1;
        /* 鼠标悬停时显示按钮 */
        display: inline;
    }

    .user-pic-box:hover .user-pic {
        filter: brightness(50%);
    }

    .hidden-button:hover {
        background: #fff;
        color: #000;
    }

    .hidden-button2:hover {
        background: #fff;
        color: #000;
    }

    .edit-form {
        width: 70%;
        margin: 100px auto;
        /* padding: 20px 40px; */
        /* float: right; */
    }

    .user-pic-box {
        background: transparent;
        position: absolute;
        bottom: -50px;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 30;
        object-fit: cover;
    }

    .user-pic {
        display: block;
        width: 330px;
        /* 调整头像的宽度，这里使用了一个示例值 */
        height: 330px;
        /* 调整头像的高度，这里使用了一个示例值 */
        object-fit: cover;
        border-radius: 50%;
        /* 使图像为圆形 */
        transition: filter 0.4s;
        border: 4px solid #000;
        /* position: absolute;
        margin: -220px 30px; */
        z-index: 2;
        /* margin:50px 100px; */
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

    .button-box {}

    #updateProfileButton {
        width: 100%;
        margin: 20px 0px;
    }

    #back-button {
        width: 100%;
    }

    .change-icon {
        background: transparent;
        /* border: 0;
        margin: 30px 200px;
        position: absolute;
        bottom: 0; */
    }

    .change-icon img {
        height: 55px;
        width: 55px;
    }
</style>
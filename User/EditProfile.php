<?php
include_once('../db.php');
// include_once('NavigationBar.php');

$user_id = $_GET['user_id'];

if (isset($_SESSION['operation_success'])) {
    // unset($_SESSION['operation_success']);
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
        $maxFileSize = 5 * 1024 * 1024;  // 5 MB

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

    <div style="height:25px;"></div>

    <form action="EditProfile.php?user_id=<?php echo $user_id ?>" method="POST" enctype="multipart/form-data">

        <div class="edit-box">
            <div class="user-image">
                <input type="file" name="background_picture" id="backgroundPicInput" accept="image/*"
                    style="display: none;">
                <button type="button" class="hidden-button">Change Background</button>
                <img src="<?php echo $row['user_profilebackground'] ? $row['user_profilebackground'] : '../BackgroundPic/pyh.jpg'; ?>"
                    class="user-background" alt="">

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
                                E-mail
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

                        <a class="ui black button" href="UserProfile.php" id="back-button">Back</a>
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
    .edit-box {
        background: #FFFBF5;
        border: 4px solid #000;
        border-radius: 20px;
        width: 90%;
        margin: auto;
        overflow: hidden;
    }

    .user-edit-box {
        width: 100%;
        display: flex;
    }

    .user-image {
        position: relative;
        height: 350px;
        border-bottom: 4px solid #000;
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
        z-index: 1;
    }

    .hidden-button {
        background: transparent;
        padding: 10px 30px;
        position: absolute;
        border: 3px solid #fff;
        color: #fff;
        border-radius: 10px;
        top: 50%;
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
        filter: brightness(50%);
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
        width: 65%;
        padding: 20px 40px;
        float: right;
    }

    .user-pic-box {
        /* position: absolute; */
        margin: 20px 60px;
        border-radius: 50%;
        position: relative;
        display: inline-block;
    }

    .user-pic {
        display: block;
        width: 320px;
        /* 调整头像的宽度，这里使用了一个示例值 */
        height: 320px;
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
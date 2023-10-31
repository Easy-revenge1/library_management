<?php
include_once('../db.php');

if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id']; // Update to get user_id from the form
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_contact = $_POST['user_contact'];

    $query = "UPDATE `user` SET `user_name` = ?, `user_email` = ?, `user_contact` = ? WHERE `user_id` = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "sssi", $user_name, $user_email, $user_contact, $user_id);
        if (mysqli_stmt_execute($stmt)) {
            echo '<div class="ui success message">User information updated successfully</div>';
        } else {
            echo "Error updating user information: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt); // Close the statement here
    } else {
        echo "Error preparing the statement: " . mysqli_error($conn);
    }
}

$user_id = $_GET['user_id'];

$UserProfile = "SELECT * FROM `user` WHERE `user_id` = ?";

$stmt = mysqli_prepare($conn, $UserProfile);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt); // Close the statement here
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/semantic.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="ui container">
        <h1 class="ui header">Edit Your Profile</h1>
        <form class="ui form" action="EditProfile.php?user_id=<?php echo $user_id?>" method="POST">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <div class="field">
                <label for="user_name">Username</label>
                <input type="text" name="user_name" id="user_name" value="<?php echo $row['user_name']; ?>">
            </div>
            <div class="field">
                <label for="user_email">Email</label>
                <input type="email" name="user_email" id="user_email" value="<?php echo $row['user_email']; ?>">
            </div>
            <div class="field">
                <label for="user_contact">Contact</label>
                <input type="text" name="user_contact" id="user_contact" value="<?php echo $row['user_contact']; ?>">
            </div>

            <button class="ui button" type="submit" name="submit" id="updateProfileButton" disabled>Update Profile</button>

            <a class="ui button" href="ChangePassword.php?user_id=<?php echo $user_id; ?>">Change Password</a>

        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwa d6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>

<script src="../Fomantic-ui/dist/semantic.min.js"></script>
<script>
    // Select the input fields
    var userNameInput = document.getElementById('user_name');
    var userEmailInput = document.getElementById('user_email');
    var userContactInput = document.getElementById('user_contact');
    
    // Select the "Update Profile" button
    var updateProfileButton = document.getElementById('updateProfileButton');

    // Function to enable the button when any input field changes
    function enableUpdateProfileButton() {
        updateProfileButton.removeAttribute('disabled');
    }

    // Add event listeners to the input fields
    userNameInput.addEventListener('input', enableUpdateProfileButton);
    userEmailInput.addEventListener('input', enableUpdateProfileButton);
    userContactInput.addEventListener('input', enableUpdateProfileButton);
</script>

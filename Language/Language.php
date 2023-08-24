<?php
include_once('../db.php');
$available_langs = array('en', 'ms', 'zh-hans', 'zh-hant');

// Set default language session
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

// Change language if requested
if (isset($_GET['lang']) && in_array($_GET['lang'], $available_langs)) {
    $_SESSION['lang'] = $_GET['lang'];

    // Update language in the database
    $newLang = $_GET['lang'];
    // $adminId = $_SESSION['admin_id'];
    $updateQuery = "UPDATE `admin` SET language = '$newLang' WHERE admin_id = 1";
    $updateResult = mysqli_query($conn, $updateQuery);
    if (!$updateResult) {
        die("Database update error: " . mysqli_error($conn));
    } else {
        echo "<script>window.location.href='../Admin/AdminIndex.php';</script>";
    }
}

// Include active language
include('../Language/' . $_SESSION['lang'] . '/lang.' . $_SESSION['lang'] . '.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Language Change Page</title>
    <link rel="stylesheet" href="../Admin/Assets/dist/css/adminlte.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Change Language</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="get">
                            <div class="form-group">
                                <label for="lang">Select Language:</label>
                                <select class="form-control" id="lang" name="lang">
                                    <?php foreach ($available_langs as $lang) {
                                        echo '<option value="' . $lang . '"';
                                        if ($_SESSION['lang'] == $lang) {
                                            echo ' selected';
                                        }
                                        echo '>' . ucfirst($lang) . '</option>';
                                    } ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Change Language</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include AdminLTE JS and other required resources -->
    <script src="../Admin/Assets/plugins/jquery/jquery.min.js"></script>
    <script src="../Admin/Assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../Admin/Assets/dist/js/adminlte.min.js"></script>
</body>

</html>
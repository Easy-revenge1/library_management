<?php
include_once("../db.php");
include_once("../Include/Header.php");
include_once("../Include/TopNavbar.php");
include_once("../Include/Sidebar.php");
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$feedbackId = $_GET['id'];

$query = "SELECT * FROM contact WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $feedbackId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {

    $updateStatusSql = "UPDATE contact SET status = 2 WHERE id = ?";
    $updateStatusStmt = mysqli_prepare($conn, $updateStatusSql);
    mysqli_stmt_bind_param($updateStatusStmt, 'i', $feedbackId);

    if (!mysqli_stmt_execute($updateStatusStmt)) {
        echo '<div>Failed to update feedback status.</div>';
    } else {
        $userEmail = $row['email'];
        $subject = "Feedback Handling Notice";

        $message = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Feedback Notice</title>
        </head>
        <body>
            <p>Dear User,</p>
            <p>We want to inform you that we have received your feedback. Our team has noticed it, and we appreciate your input.</p>
            <p>If you have any further questions or concerns, feel free to reach out to us. Your feedback is valuable to us as we strive to improve our service.</p>
            <p>Thank you for taking the time to share your thoughts with us.</p>
            <p>Thank you for using our service.</p>
        </body>
        </html>
        ';


        $mail = new PHPMailer(true);
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
            $mail->addAddress($userEmail);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();

            $_SESSION['feedback_message'] = [
                'type' => 'success',
                'text' => 'Feedback marked as handled and email sent successfully.'
            ];
        } catch (Exception $e) {
            $_SESSION['feedback_message'] = [
                'type' => 'error',
                'text' => 'Error sending the handling update email: ' . $mail->ErrorInfo
            ];
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="Assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="Assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="Assets/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="Assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="Assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <link rel="stylesheet" href="Assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="Assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="Assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="Assets/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="Assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="Assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <link rel="stylesheet" href="Assets/plugins/bs-stepper/css/bs-stepper.min.css">
    <link rel="stylesheet" href="Assets/plugins/dropzone/min/dropzone.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Book Maintenance</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Book Maintenance</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Form</h3>
                            </div>
                            <form action="FeedbackManagement.php?id=<?= $feedbackId ?>" method="POST"
                                enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="inputName">Title</label>
                                        <input type="text" id="title" name="title" class="form-control"
                                            value="<?= htmlspecialchars($row['title']) ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="inputName">Email</label>
                                        <input type="text" id="email" name="email" class="form-control"
                                            value="<?= htmlspecialchars($row['email']) ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="inputAuthor">Content</label>
                                        <input type="text" id="content" name="content" class="form-control"
                                            value="<?= htmlspecialchars($row['content']) ?>"></input>
                                    </div>

                                </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a href="Feedback.php" class="btn btn-secondary">Cancel</a>
                        <input type="submit" name="submit" value="Handle" class="btn btn-success float-right">
                    </div>
                </div>
                </form>
            </section>
        </div>
    </div>
</body>

</html>

<script src="Assets/plugins/jquery/jquery.min.js"></script>
<script src="Assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="Assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<script src="Assets/plugins/moment/moment.min.js"></script>
<script src="Assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="Assets/plugins/toastr/toastr.min.js"></script>
<script src="Assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="Assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="Assets/dist/js/adminlte.min.js"></script>
<script>
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    document.addEventListener('DOMContentLoaded', function() {
        var feedbackMessage = <?php echo json_encode($_SESSION['feedback_message'] ?? null); ?>;
        if (feedbackMessage) {
            Toast.fire({
                icon: feedbackMessage.type,
                title: feedbackMessage.text
            });
            <?php unset($_SESSION['feedback_message']); ?>
        }
    });
</script>
<style>
    .col-md-6 {
        padding: 15px;
        /* Add padding to space out the content */
    }

    .uppic {
        height: 100%;
        /* Set the height of the div */
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f0f0f0;
        /* Add a background color for the div */
    }

    .uppic img {
        max-width: 100%;
        max-height: 100%;
    }
</style>
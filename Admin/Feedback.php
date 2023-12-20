<?php
include_once("../db.php");
include_once("../Include/Header.php");
include_once("../Include/TopNavbar.php");
include_once("../Include/Sidebar.php");

$query = "SELECT * FROM `contact`";
$SQL = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>

<head>
    <title>DIGITAL LIBRARY</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="Assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="Assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="Assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="Assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="Assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="Assets/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="Assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="AdminIndex.php">Home</a></li>
                                <li class="breadcrumb-item active">Feedback Table</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <div class="card">
                                <div class="card-header bg-gradient-primary">
                                    <h3 class="card-title">Feedback List</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="FeedbackList" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Email</th>
                                                <th>Content</th>
                                                <th>Date</th>
                                                <th>Handle</th>
                                                <th>Manage</th>
                                            </tr>
                                        </thead>
                                        <tbody id="user-table-body">
                                            <?php while ($row = mysqli_fetch_array($SQL)) { ?>
                                                <tr class="tdhv">
                                                    <td>
                                                        <?= $row["id"] ?>
                                                    </td>
                                                    <td>
                                                        <?= $row["title"] ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <?= $row["email"] ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <?= $row["content"] ?>
                                                    </td>
                                                    <td>
                                                        <?= $row["date"] ?>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-primary btn-sm"
                                                            href="FeedbackManagement.php?id=<?= $row['id'] ?>">
                                                            <i class="fas fa-edit">
                                                            </i>
                                                            Handle
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-danger btn-sm" href="Feedback.php"
                                                            onclick="handleDeleteClick(event, <?= $row['id'] ?>)">
                                                            <i class="fas fa-trash"></i>
                                                            Delete
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="modal fade" id="deleteFeedbackModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteFeedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteFeedbackModalLabel">Delete Feedback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this feedback?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Yes</button>
                </div>
            </div>
        </div>
    </div>


    <script src="Assets/plugins/jquery/jquery.min.js"></script>
    <script src="Assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="Assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="Assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="Assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="Assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="Assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="Assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="Assets/plugins/jszip/jszip.min.js"></script>
    <script src="Assets/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="Assets/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="Assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="Assets/plugins/toastr/toastr.min.js"></script>
    <script src="Assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="Assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="Assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="Assets/dist/js/adminlte.min.js"></script>
    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        function handleDeleteClick(event, feedbackId) {
            event.preventDefault();
            $('#deleteFeedbackModal').modal('show');

            $(document).off('click', '#confirmDelete').on('click', '#confirmDelete', function () {
                $.ajax({
                    url: `Ajax/DeleteFeedback.php?id=${feedbackId}&action=delete`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response && response.success) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Successfully deleted feedback.'
                            });

                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else {
                            toastr.error('Failed to delete the feedback. Check the console for more details.');
                        }
                    },
                    error: function (xhr, status, error) {
                        toastr.error('Failed to delete the feedback. Check the console for more details.');
                    },
                    complete: function () {
                        $('#deleteFeedbackModal').modal('hide');
                    }
                });
            });
        }

        $(function () {
            $("#FeedbackList").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": [
                    {
                        extend: 'copy',
                        text: 'Copy',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        text: 'Column Visibility',
                        columns: ':gt(0)'
                    }
                ]
            }).buttons().container().appendTo('#FeedbackList_wrapper .col-md-6:eq(0)');
        });
    </script>

</body>

</html>
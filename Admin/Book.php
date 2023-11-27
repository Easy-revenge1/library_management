<?php
include_once("../db.php");
include_once("../Include/Header.php");
include_once("../Include/TopNavbar.php");
include_once("../Include/Sidebar.php");

// Start Of Queries
$query = "SELECT book.*, category.category_name, language.language_name, bookstatus.BookStatus
          FROM book
          INNER JOIN category ON book.category_id = category.category_id
          INNER JOIN language ON book.language_id = language.language_id
          INNER JOIN bookstatus ON book.Status = bookstatus.BookStatusId";
$SQL = mysqli_query($conn, $query);

$categorySearch = "SELECT * FROM category";
$categoryResult = mysqli_query($conn, $categorySearch);

$languageSearch = "SELECT * FROM language";
$languageResult = mysqli_query($conn, $languageSearch);

// Category Row Function
if (mysqli_num_rows($categoryResult) > 0) {
  // Generate options for the category select element
  $categoryOptions = '<option value="">Select a category</option>';
  while ($row = mysqli_fetch_assoc($categoryResult)) {
    $categoryOptions .= '<option value="' . $row["category_id"] . '|' . $row["category_name"] . '">' . $row["category_name"] . '</option>';
  }
} else {
  // Handle the case when no categories exist
  $categoryOptions = '<option value="">No categories found</option>';
}

// Language Row Function
if (mysqli_num_rows($languageResult) > 0) {
  // Generate options for the language select element
  $languageOptions = '<option value="">Select a language</option>';
  while ($row = mysqli_fetch_assoc($languageResult)) {
    $languageOptions .= '<option value="' . $row["language_id"] . '|' . $row["language_name"] . '">' . $row["language_name"] . '</option>';
  }
} else {
  // Handle the case when no languages exist
  $languageOptions = '<option value="">No languages found</option>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
                <li class="breadcrumb-item active">Book List</li>
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
                  <h3 class="card-title">Book List</h3>
                  <div class="col-12 text-right">
                    <div><a href="NewBook.php" class="text-white"><i class="fas fa-plus">Add New</i></a></div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="BookList" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Public Date</th>
                        <th>Language</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <tbody id="book-table-body">
                      <?php while ($row = mysqli_fetch_array($SQL)) { ?>
                        <tr class="tdhv">
                          <td>
                            <?= $row["book_id"] ?>
                          </td>
                          <td>
                            <?= $row["book_title"] ?>
                          </td>
                          <td>
                            <?= $row["book_author"] ?>
                          </td>
                          <td>
                            <?= $row["book_public_date"] ?>
                          </td>
                          <td>
                            <?= $row["language_name"] ?>
                          </td>
                          <td>
                            <?= $row["category_name"] ?>
                          </td>
                          <td>
                            <?= $row["BookStatus"] ?>
                          </td>
                          <td>
                            <a class="btn btn-primary btn-sm" href="BookMaintenance.php?id=<?= $row['book_id'] ?>">
                              <i class="fas fa-edit">
                              </i>
                              Manage
                            </a>
                          </td>
                          <td>
                            <a class="btn btn-danger btn-sm" href="Book.php"
                              onclick="handleDeleteClick(event, <?= $row['book_id'] ?>)">
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

  <div class="modal fade" id="deleteBookModal" tabindex="-1" role="dialog" aria-labelledby="deleteBookModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteBookModalLabel">Delete Book</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this book?
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

    function handleDeleteClick(event, bookId) {
      event.preventDefault();
      $('#deleteBookModal').modal('show');

      $(document).off('click', '#confirmDelete').on('click', '#confirmDelete', function () {
        $.ajax({
          url: `Ajax/DeleteBook.php?id=${bookId}&action=delete`,
          type: 'GET',
          dataType: 'json',
          success: function (response) {
            if (response && response.success) {
              Toast.fire({
                icon: 'success',
                title: 'Successfully deleted book.'
              });

              // Introduce a delay before reloading the page
              setTimeout(function () {
                location.reload();
              }, 2000);  // Adjust the delay time (in milliseconds) as needed
            } else {
              toastr.error('Failed to delete the book. Check the console for more details.');
            }
          },
          error: function (xhr, status, error) {
            toastr.error('Failed to delete the book. Check the console for more details.');
          },
          complete: function () {
            $('#deleteBookModal').modal('hide');
          }
        });
      });
    }

    $(function () {
      $("#BookList").DataTable({
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
            columns: ':gt(0)' // Exclude the first column (checkbox column)
          }
        ]
      }).buttons().container().appendTo('#BookList_wrapper .col-md-6:eq(0)');
    });
  </script>
</body>
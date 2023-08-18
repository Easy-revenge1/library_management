<?php
include_once("../db.php");
include_once("../Include/Header.php");
include_once("../Include/TopNavbar.php");
include_once("../Include/Sidebar.php");

$bookId = $_GET['id'];

if (isset($_POST['submit'])) {
  $book_title = mysqli_real_escape_string($conn, $_POST['book_title']);
  $book_author = mysqli_real_escape_string($conn, $_POST['book_author']);
  $book_public_date = $_POST['book_public_date'];
  $book_language = mysqli_real_escape_string($conn, $_POST['book_language']);
  $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
  $book_status = mysqli_real_escape_string($conn, $_POST['book_status']);

  // Handle uploaded book content
  if (!empty($_FILES['book_content']['tmp_name'])) {
    $book_content = $_FILES['book_content']['tmp_name'];
    $book_content_path = "content/" . $_FILES['book_content']['name'];
    if (!move_uploaded_file($book_content, $book_content_path)) {
      die('Failed to move uploaded content');
    }
  } else {
    // Retrieve existing book content path if no new content is uploaded
    $contentQuery = "SELECT book_content FROM book WHERE book_id = ?";
    $contentStmt = mysqli_prepare($conn, $contentQuery);
    if ($contentStmt === false) {
      die('mysqli_prepare failed: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($contentStmt, 'i', $bookId);
    mysqli_stmt_execute($contentStmt);
    mysqli_stmt_store_result($contentStmt);
    mysqli_stmt_bind_result($contentStmt, $existingContentPath);
    mysqli_stmt_fetch($contentStmt);
    mysqli_stmt_free_result($contentStmt);
    $book_content_path = $existingContentPath;
  }

  // Handle uploaded book cover
  if (!empty($_FILES['book_cover']['tmp_name'])) {
    $book_cover = $_FILES['book_cover']['tmp_name'];
    $book_cover_path = "cover/" . $_FILES['book_cover']['name'];
    move_uploaded_file($book_cover, $book_cover_path);
  } else {
    // Retrieve existing book cover if no new cover is uploaded
    $coverQuery = "SELECT book_cover FROM book WHERE book_id = ?";
    $coverStmt = mysqli_prepare($conn, $coverQuery);
    if ($coverStmt === false) {
      die('mysqli_prepare failed: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($coverStmt, 'i', $bookId);
    mysqli_stmt_execute($coverStmt);
    mysqli_stmt_store_result($coverStmt);
    mysqli_stmt_bind_result($coverStmt, $existingCover);
    mysqli_stmt_fetch($coverStmt);
    mysqli_stmt_free_result($coverStmt);
    $book_cover_path = $existingCover;
  }

  echo $Update = "UPDATE book SET book_title=?, book_content=?, book_author=?, book_public_date=?, book_language=?, category_id=?, book_cover=?, Status=? WHERE book_id=?";
  $stmt = mysqli_prepare($conn, $Update);
  if ($stmt === false) {
    die('mysqli_prepare failed: ' . mysqli_error($conn));
  }
  mysqli_stmt_bind_param($stmt, 'sssssssis', $book_title, $book_content_path, $book_author, $book_public_date, $book_language, $category_id, $book_cover_path, $book_status, $bookId);
  mysqli_stmt_execute($stmt);
    if (mysqli_stmt_execute($stmt)) {
      echo "<script>window.location.href='book.php';</script>";
      exit;
    } else {
      echo "<script>alert('Update Failed');</script>";
    }
  }

  $query = "SELECT book.*, category.category_name, language.language_name, bookstatus.BookStatus
            FROM book
            INNER JOIN category ON book.category_id = category.category_id
            INNER JOIN language ON book.book_language = language.language_id
            INNER JOIN bookstatus ON book.Status = bookstatus.BookStatusId
            WHERE book.book_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $bookId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

$categoryQuery = "SELECT *FROM category";
$categoryResult = mysqli_query($conn, $categoryQuery);

$languageQuery = "SELECT * FROM language";
$languageResult = mysqli_query($conn, $languageQuery);

$statusQuery = "SELECT * FROM bookstatus";
$statusResult = mysqli_query($conn, $statusQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="Assets/plugins/fontawesome-free/css/all.min.css">
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
            <h1>Project Edit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Project Edit</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">General</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Project Name</label>
                <input type="text" id="inputName" class="form-control" value="AdminLTE">
              </div>
              <div class="form-group">
                <label for="inputDescription">Project Description</label>
                <textarea id="inputDescription" class="form-control" rows="4">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terr.</textarea>
              </div>
              <div class="form-group">
                <label for="inputStatus">Status</label>
                <select id="inputStatus" class="form-control custom-select">
                  <option disabled>Select one</option>
                  <option>On Hold</option>
                  <option>Canceled</option>
                  <option selected>Success</option>
                </select>
              </div>
              <div class="form-group">
                <label for="inputClientCompany">Client Company</label>
                <input type="text" id="inputClientCompany" class="form-control" value="Deveint Inc">
              </div>
              <div class="form-group">
                <label for="inputProjectLeader">Project Leader</label>
                <input type="text" id="inputProjectLeader" class="form-control" value="Tony Chicken">
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <a href="#" class="btn btn-secondary">Cancel</a>
          <input type="submit" value="Save Changes" class="btn btn-success float-right">
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  </div>
  <!-- ./wrapper -->

</body>
</html>

<!-- jQuery -->
<script src="Assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="Assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="Assets/dist/js/adminlte.min.js"></script>

<?php 
include_once("../Include/Footer.php");
?>
<?php
include_once("../db.php");
include_once("../Include/Header.php");
include_once("../Include/TopNavbar.php");
include_once("../Include/Sidebar.php");

$bookId = $_GET['id'];

if (isset($_POST['submit'])) {
  $book_title = mysqli_real_escape_string($conn, $_POST['book_title']);
  $book_description = mysqli_real_escape_string($conn, $_POST['book_description']);
  $book_author = mysqli_real_escape_string($conn, $_POST['book_author']);
  $book_public_date = $_POST['book_public_date'];
  $book_language = mysqli_real_escape_string($conn, $_POST['book_language']);
  $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
  $book_status = mysqli_real_escape_string($conn, $_POST['book_status']);

  // Handle uploaded book content
  if (!empty($_FILES['book_content']['tmp_name'])) {
    $book_content = $_FILES['book_content']['tmp_name'];
    $book_content_path = "../" . "content/" . $_FILES['book_content']['name'];
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
    if (!move_uploaded_file($book_cover, "../" . $book_cover_path)) {
      die('Failed to move uploaded cover image');
    }
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

  echo $Update = "UPDATE book SET book_title=?, book_description=?,book_content=?, book_author=?, book_public_date=?, book_language=?, category_id=?, book_cover=?, Status=? WHERE book_id=?";
  $stmt = mysqli_prepare($conn, $Update);
  if ($stmt === false) {
    die('mysqli_prepare failed: ' . mysqli_error($conn));
  }
  mysqli_stmt_bind_param($stmt, 'ssssssssis', $book_title, $book_description, $book_content_path, $book_author, $book_public_date, $book_language, $category_id, $book_cover_path, $book_status, $bookId);
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
  <link rel="stylesheet" href="Assets/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="Assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="Assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="Assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="Assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="Assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="Assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <link rel="stylesheet" href="Assets/plugins/bs-stepper/css/bs-stepper.min.css">
  <link rel="stylesheet" href="Assets/plugins/dropzone/min/dropzone.min.css">
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
              <h1>Book Maintenance</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Book Maintenance</li>
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
                <h3 class="card-title">Form</h3>
              </div>
              <form action="BookMaintenance.php?id=<?= $bookId ?>" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="inputName">Title</label>
                    <input type="text" id="inputName" name="book_title" class="form-control" value="<?= htmlspecialchars($row['book_title']) ?>">
                  </div>

                  <div class="form-group">
                    <label for="inputAuthor">Book Author</label>
                    <input type="text" id="inputDescription" name="book_author" class="form-control" value="<?= htmlspecialchars($row['book_author']) ?>"></input>
                  </div>

                  <div class="form-group">
                    <label for="inputDescription">Book Description</label>
                    <textarea id="book_description" name="book_description" class="form-control"><?= htmlspecialchars($row['book_description']) ?></textarea>
                  </div>

                  <label for="inputCover">Book Cover</label>
                  <div class="custom-file">
                    <input type="file" name="book_cover" class="custom-file-input" id="customFile" value="<?= $row['book_cover'] ?>">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                  </div>

                  <label for="inputCover">Book Content :</label>
                  <div class="custom-file">
                    <input type="file" name="book_content" class="custom-file-input" id="customFile2" value="<?= $row['book_content'] ?>">
                    <label class="custom-file-label" for="customFile2">Choose file</label>
                  </div>

                  <div class="form-group">
                    <label class="inputLanguage">Book Language :</label>
                    <select class="form-control custom-select" name="book_language">
                      <?php while ($languageRow = mysqli_fetch_assoc($languageResult)) { ?>
                        <option value="<?= $languageRow['language_id'] ?>" <?= ($languageRow['language_id'] == $row['book_language']) ? 'selected' : '' ?>>
                          <?= $languageRow['language_name'] ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label class="inputCategory">Category :</label><br>
                    <select class="form-control custom-select" name="category_id">
                      <?php while ($categoryRow = mysqli_fetch_assoc($categoryResult)) { ?>
                        <option value="<?= $categoryRow['category_id'] ?>" <?= ($categoryRow['category_id'] == $row['category_id']) ? 'selected' : '' ?>>
                          <?= $categoryRow['category_name'] ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Public Date :</label>
                    <div class="input-group date" id="book_public_date" data-target-input="nearest">
                      <input type="text" name="book_public_date" class="form-control datetimepicker-input" data-target="#book_public_date" value="<?= $row['book_public_date'] ?>" />
                      <div class="input-group-append" data-target="#book_public_date" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputStatus">Status</label>
                    <select id="inputStatus" name="book_status" class="form-control custom-select">
                      <?php while ($statusRow = mysqli_fetch_assoc($statusResult)) { ?>
                        <option value="<?= $statusRow['BookStatusId'] ?>" <?= ($statusRow['BookStatusId'] == $row['Status']) ? 'selected' : '' ?>>
                          <?= $statusRow['BookStatus'] ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>

                </div>

                <!-- /.card-body -->
            </div>

            <!-- /.card -->
          </div>
          <div class="col-md-6">
            <div class="uppic" id="selectedBanner">
              <?php
              $book_cover_path = $row['book_cover'];
              echo '<img src="../Cover/' . $book_cover_path . '" alt="Book Cover">';
              

              ?>
            </div>

          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <a href="Book.php" class="btn btn-secondary">Cancel</a>
            <input type="submit" name="submit" value="Save Changes" class="btn btn-success float-right">
          </div>
        </div>
        </form>
      </section>
      <!-- /.content -->
    </div>
  </div>
  <!-- ./wrapper -->
</body>

</html>

<script src="Assets/plugins/jquery/jquery.min.js"></script>
<script src="Assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="Assets/plugins/select2/js/select2.full.min.js"></script>
<script src="Assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<script src="Assets/plugins/moment/moment.min.js"></script>
<script src="Assets/plugins/inputmask/jquery.inputmask.min.js"></script>
<script src="Assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="Assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="Assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="Assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="Assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<script src="Assets/plugins/dropzone/min/dropzone.min.js"></script>
<script src="Assets/dist/js/adminlte.min.js"></script>
<script src="Assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>



<script>
  // console.log('Image source:', selDiv.find('img').attr('src'));

  //Date picker
  $('#book_public_date').datetimepicker({
    format: 'L'
  });
  $(function() {
    bsCustomFileInput.init();
  });

  var selDiv = "";
  var storedFiles = [];
  $(document).ready(function() {
    selDiv = $("#selectedBanner");
    handleFileSelect();
  });

  function handleFileSelect() {
    var bookCover = "<?= $row['book_cover'] ?>";

    if (bookCover) {
      var imgHtml = '<img src="' + bookCover + '" alt="Book Cover">';
      selDiv.html(imgHtml);
    }
  }
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
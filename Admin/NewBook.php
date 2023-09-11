<?php
include_once('../db.php');
include_once("../Include/Header.php");
include_once("../Include/TopNavbar.php");
include_once("../Include/Sidebar.php");

$query1 = "SELECT * FROM category";
$result1 = mysqli_query($conn, $query1);

$query2 = "SELECT * FROM language";
$result2 = mysqli_query($conn, $query2);

$today = date("m.d.y");

if (isset($_POST['submit'])) {

  if (isset($_FILES["book_cover"]) && isset($_FILES["PDF"])) {
    $tmpFilePath1 = $_FILES["book_cover"]["tmp_name"];
    $newFilePath1 = "../" . "cover/" . $_FILES["book_cover"]["name"];

    $tmpFilePath2 = $_FILES["PDF"]["tmp_name"];
    $newFilePath2 = "../" . "content/" . $_FILES["PDF"]["name"];

    $book_title = $_POST['book_title'];
    $book_author = $_POST['book_author'];
    $book_public_date = $_POST['book_public_date'];
    $book_language = $_POST['book_language'];
    $category_id = $_POST['category_id'];
    $date = date("Y/m/d");

    if (move_uploaded_file($tmpFilePath2, $newFilePath2) && move_uploaded_file($tmpFilePath1, $newFilePath1)) {
      // Sanitize the input values before inserting into the database
      $book_title = mysqli_real_escape_string($conn, $book_title);
      $book_author = mysqli_real_escape_string($conn, $book_author);
      $book_public_date = mysqli_real_escape_string($conn, $book_public_date);
      $book_language = mysqli_real_escape_string($conn, $book_language);
      $category_id = mysqli_real_escape_string($conn, $category_id);

      $query = "INSERT INTO `book` (book_title, book_cover, book_content, book_author, book_public_date, book_language, category_id, upload_date, Status) 
              VALUES ('$book_title', '$newFilePath1', '$newFilePath2', '$book_author', '$book_public_date', '$book_language', '$category_id', '$date', '1')";

      if (mysqli_query($conn, $query)) {
        echo "<script>window.location.href='book.php';</script>";
      } else {
        $error = mysqli_error($conn);
        echo "<script>alert('Failed to Upload, please try again $error');</script>";
      }
    } else {
      echo "<script>alert('Failed to Upload, please try again');</script>";
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
              <h1>User Maintenance</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">User Maintenance</li>
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
              <form action="NewBook.php" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="inputTitle">Book Title :</label>
                    <input type="text" id="inputTitle" name="book_title" class="form-control" required>
                  </div>

                  <label for="inputCover">Book Cover</label>
                  <div class="custom-file">
                    <input type="file" name="book_cover" class="custom-file-input" id="book_cover" required>
                    <label class="custom-file-label" for="customFile">Choose file</label>
                  </div>

                  <label for="inputContent">Book Content :</label>
                  <div class="custom-file">
                    <input type="file" name="PDF" class="custom-file-input" id="customFile" required>
                    <label class="custom-file-label" for="customFile">Choose file</label>
                  </div>

                  <div class="form-group">
                    <label for="inputAuthor">Book Author :</label>
                    <input type="text" id="inputAuthor" name="book_author" class="form-control" required></input>
                  </div>

                  <div class="form-group">
                    <label>Public Date :</label>
                    <div class="input-group date" id="book_public_date" data-target-input="nearest">
                      <input type="text" name="book_public_date" class="form-control datetimepicker-input" data-target="#book_public_date" required/>
                      <div class="input-group-append" data-target="#book_public_date" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="details" for="">Book Language :</label>
                    <select class="form-control custom-select" name="book_language" required>
                    <option value="" selected disabled>Select Language</option>
                      <?php while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)) { ?>
                        <option value="<?php echo $row["language_id"]; ?>">
                          <?php echo $row["language_name"]; ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label class="details" for="">Book Category</label>
                    <select class="form-control custom-select" name="category_id" required>
                    <option value="" selected disabled>Select Category</option>
                      <?php while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)) { ?>
                        <option value="<?php echo $row["category_id"]; ?>">
                          <?php echo $row["category_name"]; ?>
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
            <div class="uppic" id="selectedBanner"><span>Image Preview</span></div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <a href="Book.php" class="btn btn-secondary">Cancel</a>
            <input type="submit" name="submit" value="Save Changes" class="btn btn-success float-right">
            </form>
          </div>
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
  var selDiv = "";
  var storedFiles = [];
  $(document).ready(function() {
    $("#book_cover").on("change", handleFileSelect);
    selDiv = $("#selectedBanner");
  });

  function handleFileSelect(e) {
    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    filesArr.forEach(function(f) {
      if (!f.type.match("image.*")) {
        return;
      }
      storedFiles.push(f);

      var reader = new FileReader();
      reader.onload = function(e) {
        var html =
          '<img src="' +
          e.target.result +
          "\" data-file='" +
          f.name +
          "alt='Category Image'>";
        selDiv.html(html);
      };
      reader.readAsDataURL(f);
    });
  }

  $('#book_public_date').datetimepicker({
    format: 'L'
  });
  $(function() {
    bsCustomFileInput.init();
  });
</script>

<style>
  .col-md-6 {
  padding: 15px; /* Add padding to space out the content */
}

.uppic {
  height: 100%; /* Set the height of the div */
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #f0f0f0; /* Add a background color for the div */
}

.uppic img {
  max-width: 100%;
  max-height: 100%;
}

</style>
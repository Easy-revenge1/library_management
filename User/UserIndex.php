<?php
include_once("../db.php");

// Define a base URL for your images
$baseURL = "http://localhost/library_management/";

$mostViewBook = "SELECT * FROM `book` ORDER BY `view` DESC";
$BookView = mysqli_query($conn, $mostViewBook);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/semantic.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="Css/Main.css">
  <link rel="stylesheet" href="Sidebar.php">
  <title>HomePage</title>
</head>

<body style="background-color: lightblue;">

  <div class="ui grid padded">
    <div class="sixteen wide column">
      <h1>Most View</h1>

      <div class="ui bookshelf slider">
        <?php while ($row = mysqli_fetch_assoc($BookView)) { ?>
          <div class="ui book">
            <div class="bookDetail">
              <?php
              $bookCoverPath = str_replace('..', '', $row["book_cover"]);
              $bookCoverUrl = $baseURL . $bookCoverPath;
              ?>
              <img src="<?= $bookCoverUrl ?>" alt="Book Cover" class="bookCover">
              <h3><?= $row["book_title"] ?></h3>
            </div>
          </div>
        <?php } ?>
      </div>

      <h1>Most Related To You</h1>

      <div class="ui bookshelf slider">
        <?php while ($row = mysqli_fetch_assoc($BookView)) { ?>
          <div class="ui book">
            <div class="bookDetail">
              <?php
              $bookCoverPath = str_replace('..', '', $row["book_cover"]);
              $bookCoverUrl = $baseURL . $bookCoverPath;
              ?>
              <img src="<?= $bookCoverUrl ?>" alt="Book Cover" class="bookCover">
              <h3><?= $row["book_title"] ?></h3>
            </div>
          </div>
        <?php } ?>
      </div>
      
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>

<script src="../Fomantic-ui/dist/semantic.min.js"></script>

<script>
  $('.slider').slick({
    slidesToShow: 6,
    slidesToScroll: 5,
    autoplay: true,
    arrows: true,
    autoplaySpeed: 1500,
    responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
  });
</script>

<style>
  .slick-prev {
    margin-left: 40px;
  }

  .slick-next {
    margin-right: 40px;

  }
</style>
<?php
include_once("../db.php");

$baseURL = "http://localhost/library_management/";

$mostViewBook = "SELECT * FROM `book` ORDER BY `view` DESC";
$BookView = mysqli_query($conn, $mostViewBook);

$newUpdateBook = "SELECT * FROM `book` ORDER BY `upload_date` DESC";
$NewestBook = mysqli_query($conn, $newUpdateBook);

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
  <title>Dashboard</title>
</head>

<body style="background-color: lightblue;">

  <div class="ui grid padded">
    <div class="sixteen wide column">


      <div class="ui secondary menu">
        <a class="active item" href="UserIndex.php">
          Home
        </a>
        <a class="item">
          Messages
        </a>
        <a class="item">
          Friends
        </a>
        <div class="right menu">
          <div class="item">
          <div class="ui icon input">
            <input type="text" placeholder="Search..." fdprocessedid="brlzed">
              <i class="search link icon"></i>
            </div>
          </div>
          <a class="ui item" href="">
            Settings
          </a>
          <a class="ui item" href="UserProfile.php">
            Profile
          </a>
          <a class="ui item" href="Logout.php">
            Logout
          </a>
        </div>
      </div>



      <h2 class="ui header">Most View</h2>

      <div class="ui bookshelf slider lastdiv">
        <?php while ($row = mysqli_fetch_assoc($BookView)) { ?>
          <div class="ui book">
            <div class="bookDetail">
              <?php
              $bookCoverPath = str_replace('..', '', $row["book_cover"]);
              $bookCoverUrl = $baseURL . $bookCoverPath;
              ?>
              <div class="blurring dimmable image">
                <div class="ui dimmer">
                  <div class="center">
                    <div class="ui inverted button">Watch Detail</div>
                  </div>
                </div>
                <img src="<?= $bookCoverUrl ?>" alt="Book Cover" class="bookCover">
              </div>
              <h3><?= $row["book_title"] ?></h3>
            </div>
          </div>
        <?php } ?>
      </div>

      <h2 class="ui header">Newest Update</h2>

      <div class="ui bookshelf slider">
        <?php while ($row = mysqli_fetch_assoc($NewestBook)) { ?>
          <div class="ui book">
            <div class="bookDetail">
              <?php
              $bookCoverPath = str_replace('..', '', $row["book_cover"]);
              $bookCoverUrl = $baseURL . $bookCoverPath;
              ?>
              <div class="blurring dimmable image">
                <div class="ui dimmer">
                  <div class="center">
                    <div class="ui inverted button">Watch Detail</div>
                  </div>
                </div>
                <img src="<?= $bookCoverUrl ?>" alt="Book Cover" class="bookCover">
              </div>
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
  $('.bookshelf .image').dimmer({
    on: 'ontouchstart' in document.documentElement ? 'click' : 'hover'
  });
  $('.slider').slick({
    slidesToShow: 4,
    slidesToScroll: 4,
    autoplay: true,
    arrows: true,
    autoplaySpeed: 3000,
    responsive: [{
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
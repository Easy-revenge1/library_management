<?php
include_once("../db.php");
include_once("NavigationBar.php");

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
  <title>Home</title>
</head>

<body>

<div class="intro">
   <div class="intro-text">
     <span class="text1">ONE LIBRARY</span><br>
     <span class="text2">Online Digital Book</span>
   </div>
   <div class="intro-design">
     <div class="intro-elm">
       <div class="elm1"></div>
       <!-- <div class="elm2"></div> -->
     </div>
   </div>
</div>

  <div class="ui grid padded" id="bookshelf">
    <div class="sixteen wide column">

      <h2 class="ui header" id="content-title">Most View</h2>

      <div class="ui bookshelf slider lastdiv">
        <?php while ($row = mysqli_fetch_assoc($BookView)) { ?>
          <div class="ui book">
            <div class="bookDetail">
              <?php
              // $bookCoverPath = str_replace('..', '', $row["book_cover"]);
              // $bookCoverUrl = $baseURL . $bookCoverPath;
              $bookCoverPath = $row["book_cover"];
              $bookCoverUrl = $baseURL . $bookCoverPath;
              ?>
              <div class="blurring dimmable image">
                <div class="ui dimmer">
                  <div class="center">
                    <a class="ui inverted button" href="BookDetail.php?id=<?= $row['book_id'] ?>&page=1">Watch Details</a>
                  </div>
                </div>
                <img src="<?= $bookCoverUrl ?>" alt="Book Cover" class="bookCover">
              </div>
              <h3><?= $row["book_title"] ?></h3>
            </div>
          </div>
        <?php } ?>
      </div>

      <h2 class="ui header" id="content-title">Newest Update</h2>

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
                  <a class="ui inverted button" href="BookDetail.php?id=<?= $row['book_id'] ?>&page=1">Watch Details</a>
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
  

  <div class="collection"></div>
  <!-- <div class="footer" id="footer">

  </div> -->

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

<style>

.intro{
  height:500px;
  width:100%;
  display: flex;
  margin:150px 0px;
  
}
.intro-text{
  height:100%;
  width:100%;
  padding:220px 100px;
}
.intro-text .text1{
   font-size:60px;
   font-weight: 900;
   font-family: 'Jost', sans-serif;
   letter-spacing:10px;
}
.intro-text .text2{
  font-family: 'Jost', sans-serif;
  font-size:20px;
}
.intro-design{
  height:100%;
  width:100%;
}
.intro-elm{
  /* background:#888; */
  height:100%;
  width:100%;
  margin:auto;
}
.intro-elm .elm1{
  background:#333;
  height:500px;
  width:500px;
  border-radius:10px;
  margin:auto;
}
/* .intro-elm .elm2{
  background:#1a1a1a;
  height:300px;
  width:300px;
  border-radius:10px;
  position:absolute;
  margin:200px 10px;
} */
#content-title{
  font-size:30px;
}
#bookshelf{
  width:95%;
  margin:auto;
}
.collection{
  background:#FFFBF5;
  height:200px;
  width:100%;
}

</style>
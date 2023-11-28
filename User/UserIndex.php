<?php
include_once("../db.php");
include_once("NavigationBar.php");

// if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
//   echo  "Please Login First To Access This Content";
//   header("Location: UserLogin.php");
//   exit();
// }

$baseURL = "http://localhost/library_management/";

$mostViewBook = "SELECT b.*, COALESCE(COUNT(wr.book_id), 0) AS total_views
FROM `book` b
LEFT JOIN `watch_record` wr ON b.`book_id` = wr.`book_id`
GROUP BY b.`book_id`
ORDER BY total_views DESC;";
$BookView = mysqli_query($conn, $mostViewBook);


$newUpdateBook = "SELECT * FROM `book` ORDER BY `upload_date` DESC";
$NewestBook = mysqli_query($conn, $newUpdateBook);


$categoryBox = "SELECT * FROM category";
$categoryRow = mysqli_query($conn, $categoryBox);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"
    integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"
    integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Home</title>
</head>

<body>

<div class="intro">
  <div class="firstIntroBox">
  <div class="intro-text">
     <span class="text1">ONE LIBRARY</span><br>
     <span class="text2">Online Digital Book</span>
   </div>
  </div>
   <div class="intro-design">
     <div class="intro-elm">
       <div class="elm1">
        <img src="../pic/bookstore.png" alt="">
       </div>
       
     </div>
   </div>
   <!-- <div class="blueCircleBox">
  <div class="blueCircle"></div>
  </div> -->
</div>


  <div class="ui grid padded" id="bookshelf">
    <div class="sixteen wide column" style="background:#ddd; border-bottom: 3px solid #45474B;">
    
    <div class="bookRowTable">
    <h2 class="ui header" id="content-title">Most View</h2>

    <div class="slider mostView" id="bookList">
<?php while ($row = mysqli_fetch_assoc($BookView)) { ?>
  <?php
        $bookCoverPath = str_replace('..', '', $row["book_cover"]);
        $bookCoverUrl = $baseURL . $bookCoverPath;
        // $bookCoverPath = $row["book_cover"];
        // $bookCoverUrl = $baseURL . $bookCoverPath;
        ?>
  <div class="book-cover">
    <div class="linear-bg"></div>
     <p class="book-title"><?= $row["book_title"] ?></p>
     <button class="hidden-button" onclick="redirectToBookDetails(<?= $row['book_id'] ?>)">View Detail</button>
     <img src="<?= $bookCoverUrl ?>" alt="Book Cover" class="book-image">
  </div>
  <?php } ?>
</div>



<h2 class="ui header" id="content-title">Newest Update</h2>

<div class="slider" id="bookList">
<?php while ($row = mysqli_fetch_assoc($NewestBook)) { ?>
  <?php
        $bookCoverPath = str_replace('..', '', $row["book_cover"]);
        $bookCoverUrl = $baseURL . $bookCoverPath;
        ?>
  <div class="book-cover">
    <div class="linear-bg"></div>
     <p class="book-title"><?= $row["book_title"] ?></p>
     <button class="hidden-button" onclick="redirectToBookDetails(<?= $row['book_id'] ?>)">View Detail</button>
     <img src="<?= $bookCoverUrl ?>" alt="Book Cover" class="book-image">
  </div>
  <?php } ?>
</div>


    </div>

<div class="collection">
<h2 class="ui header" id="content-title" style="padding:0px 40px;">Collection</h2>
<div class="categoryBox">
  <?php 
  $counter = 1;
  while ($row = mysqli_fetch_assoc($categoryRow)) { ?>
    <div class="categoryCover <?php if ($counter % 3 == 0) echo 'fullWidth'; ?>">
    <div class="categoryLinear"></div>
      <p class="categoryTitle"><?= $row["category_name"] ?></p>
      <img src="../pic/pyh.jpg" alt="Book Cover" class="categoryImage">
    </div>
    <?php $counter++;
  } ?>
</div>
</div>
    </div>
  </div>

  <div style="height:300px; width:100%; z-index:1;"></div>

  <div class="footer" id="footer">
   <div class="contentFooter">
    <div class="footerTitle">
    <h1 class="">ONE LIBRARY</h1>
    <a href=""><i class="facebook icon"></i></a>
    <a href=""><i class="instagram icon"></i></a>
    <a href=""><i class="twitter icon"></i></a>
    </div>
    <!-- <div>
    <a href=""><i class="facebook icon"></i></a>
    </div> -->
    <div class="footerLink">
      <div class="link1">
      <p>ABOUT</p>
      <ul class="a">
       <li><a href="">TEST</a></li>
       <li><a href="">TEST</a></li>
       <li><a href="">TEST</a></li>
      </ul>
      </div>

      <div class="link2">
      <p>CONTACT US</p>
      <ul class="a">
      <li><a href="">TEST</a></li>
      <li><a href="">TEST</a></li>
      <li><a href="">TEST</a></li>
      </ul>
      </div>
    </div>
   </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>

<script src="../Fomantic-ui/dist/semantic.min.js"></script>

<script>
  // JavaScript
function redirectToBookDetails(bookId) {
  window.location.href = 'BookDetail.php?id=' + bookId + '&page=1';
}


// var footer = document.getElementsByClassName('contentFooter')[0];

// footer.style.opacity = "0";

// window.onscroll = function (event) {
//     var scroll2 = window.pageYOffset;

//     if (scroll2 >3450) {
//       footer.style.opacity = "1";
//     } else {
//       footer.style.opacity = "0";
//     }
//   };
</script>

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
#bookList {
        width: 100%;
        height:100%;
        /* margin-left: 430px; */
        display: flex;
        flex-wrap: wrap;
        /* justify-content: space-around; */
        margin: auto;
        margin-bottom:100px;
        border-radius: 20px;
    }
    .book-cover {
        height: 400px;
        width: 300px;
        margin: 15px 15px;
        /* border: 5px solid #000; */
        border-radius: 20px;
        overflow: hidden;
        position: relative;
    }
    .linear-bg {
        background: linear-gradient(to top, black, transparent);
        position: absolute;
        height: 230px;
        width: 100%;
        border-radius: 10px;
        bottom: 0%;
        transition: 0.4s;
        /* z-index:2; */
    }
    .book-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        background-repeat: no-repeat;
        background-position: center;
        transition: 0.4s;
        /* z-index:1; */
    }

    .book-title {
        color: #fff;
        position: absolute;
        bottom: 0%;
        left: 50%;
        transform: translate(-50%, -50%);
        transition: 0.4s;
        opacity: 1;
        font-weight: 900;
    }
    .hidden-button {
        background: transparent;
        padding: 10px 30px;
        position: absolute;
        border: 3px solid #fff;
        color: #fff;
        border-radius: 10px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 2;
        transition: 0.4s;
        opacity: 0;
        cursor: pointer;
    }

    .book-cover:hover{
      filter: grayscale(0%);
    }

    .book-cover:hover .hidden-button {
        opacity: 1;
        display: inline;
    }

    .book-cover:hover .linear-bg {
        /* filter: brightness(50%); */
        height: 500px;
    }

    .book-cover:hover .book-title {
        opacity: 0;
    }

    .hidden-button:hover {
        background: #fff;
        color: #000;
    }

/* ............................................................................ */
.collection{
  /* background:#FFFBF5; */
  /* height:100%; */
        /* justify-content: space-around; */
        margin: auto;
        border-radius: 20px;
  width:95%; 
}

/* CSS */
.categoryBox {
  width: 95%;
  margin: auto;
  display: flex;
  flex-wrap: wrap;
}
.categoryLinear{
  background: linear-gradient(to top, black, transparent);
        position: absolute;
        height: 0%;
        width: 100%;
        border-radius: 10px;
        bottom: 0%;
        transition: 0.4s;
        z-index:2;
}
.categoryTitle{
  color: #fff;
  font-size: 30px;
        position: absolute;
        bottom: 30%;
        left: 50%;
        transform: translate(-50%, -50%);
        transition: 0.4s;
        opacity: 0;
        font-weight: 900;
        z-index:3;
        transition:0.4s;
}
.categoryCover {
  background: #ddd;
  height: 350px;
  width: calc(50% - 30px); /* Adjusted width for 2 items in a row */
  margin: 15px;
  border-radius: 20px;
  overflow: hidden;
  position: relative;
  cursor: pointer;
}

.categoryImage{
  width: 100%;
        height: 100%;
        object-fit: cover;
        background-repeat: no-repeat;
        background-position: center;
        transition: 0.4s;
        z-index:1;
        filter: brightness(80%);
}

.categoryCover:hover .categoryImage{
  transform: scale(1.2);
  filter: brightness(40%);
}

/* .categoryCover:hover .categoryLinear{
  height:60%;
} */

.categoryCover:hover .categoryTitle{
  opacity:1;
}

/* .categoryImage:hover {
  transform: scale(1.2); 
} */

.fullWidth {
  width: 100%;
  margin: 20px 15px; /* Adjust margin for full width */
}

/* ....................................................................................... */
/* much put it back in main css */
/* .slick-next{
  margin-right: 0px ;
}
.slick-{
  margin-right: 0px ;
} */
.slick-next:before {
  font-size:20px;
  color:#000 !important;
  margin-right: 0px ;
}

.slick-prev:before {
  font-size:20px;
  color:#000 !important;
  margin-right: 0px ;
}

/* ............................................................................. */
.firstIntroBox{
  /* background:rgba(221, 221, 221, 0.5);
  backdrop-filter: blur(70px); */
  height:100vh;
  width:100%;
  z-index:6;
}
.intro{
  background: rgba(221, 221, 221);
  /* background-image:url('../pic/library.webp'); */
  background-repeat: no-repeat;
    background-size: cover;
    background-position: top;
    background-attachment: fixed;
    position: relative;
    display: flex;
    height: 100vh;
    /* filter: brightness(60%); */
    /* backdrop-filter: blur(70px); */
    z-index:3;
  /* display: flex; */
  /* margin:150px 0px; */
  
}
.intro-text{
  height:100vh;
  /* text-align:center;
  padding:350px; */
  padding:380px 130px;
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
  height:100vh;
  width:100%;
}
.intro-elm{
  /* background:#888; */
  height:100%;
  width:100%;
  margin:auto;
}
.intro-elm .elm1{
  /* background-image:url('../pic/classroom_library.png'); */
  border-radius:10px;
  margin:auto;
  margin-top:100px;
}
.intro-elm .elm1 img{
  height:600px;
  width:600px;
  border-radius:10%;
  border:5px solid #000;
  /* filter: brightness(60%); */
  object-fit: cover;
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
  background:#dddddd;
  width:100%;
  margin:auto;
  position: relative;
  z-index:4;
}
.blueCircleBox{
  position: absolute;
  top:0px;
  right:-300px;
  z-index:1;
}
.blueCircle{
  background:blue; 
  height:650px; 
  width:650px; 
  /* transform: rotate(100deg) skew(0deg); */
  border-radius:50%;
  z-index:1;
  /* animation: circleBlue 20s infinite; */
}
@keyframes circleBlue{
  0%{
    transform: rotate(250deg) skew(0deg);
  }
  50%{
    transform: rotate(70deg) skew(0deg);
  }
  100%{
    transform: rotate(250deg) skew(0deg);
  }
}
.bookRowTable{
  width:90%;
  margin:auto;
}

.footer{
  position:fixed;
  bottom:0;
  z-index:1;
  background:#FFFBF5;
  width:100%;
  height:300px;
  /* padding:40px 40px; */
}
.contentFooter{
  /* background:#ddd; */
  /* bottom:130px; */
  width:80%;
  margin:auto;
  display:flex;
  transition:0.6s;
}

.footerTitle h1{
  /* color:#fff; */
  font-size:35px;
  font-weight:100;
  letter-spacing: 10px;
  margin:100px 0px 0px 0px;
}
.footerTitle i{
  font-size:23px;
  color:#000;
  padding:20px 40px 0px 0px;
}
.footerLink{
  margin-left: auto;
  display:flex;
  padding:80px 0px;
}
.footerLink p{
  font-size:27px;
  font-weight:900;
  letter-spacing:10px;
}
.footerLink a{
  color:#000;
  text-decoration: none;
  transition:0.4s;
}
.footerLink a:hover{
  color:#B4B4B3;
  text-decoration:none;
}
.footerLink .link1{
  padding:0px 40px;
}
.footerLink .link2{
  border-left:3px solid #D0D4CA;
  padding:0px 40px;
  /* margin-left:100px; */
}
</style>
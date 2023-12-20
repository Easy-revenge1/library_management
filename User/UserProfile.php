<?php
ob_start();
include_once('../db.php');
include_once('NavigationBar.php');

if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
  header("Location: UserLogin.php");
  exit();
}

$user_id = $_SESSION['user_id'];

$username = $_SESSION['user_name'];
$email = $_SESSION['user_email'];
$contact = $_SESSION['user_contact'];

$favoriteList = "SELECT f.*, b.*
FROM favourites AS f
INNER JOIN book AS b ON f.book_id = b.book_id
WHERE f.user_id = ? LIMIT 4;";
$favoritestmt = mysqli_prepare($conn, $favoriteList);
mysqli_stmt_bind_param($favoritestmt, "i", $user_id);
mysqli_stmt_execute($favoritestmt);
$favoriteresult = mysqli_stmt_get_result($favoritestmt);



$watchRecord = "SELECT w.*, b.*
FROM watch_record AS w
INNER JOIN book AS b ON w.book_id = b.book_id
WHERE w.user_id = ? LIMIT 4;";
$recordStmt = mysqli_prepare($conn, $watchRecord);
mysqli_stmt_bind_param($recordStmt, "i", $user_id);
mysqli_stmt_execute($recordStmt);
$recordResult = mysqli_stmt_get_result($recordStmt);



$UserProfile = "SELECT * FROM `user` WHERE `user_id` = ?";
$stmt = mysqli_prepare($conn, $UserProfile);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
  die("Error: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);
mysqli_close($conn);



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/semantic.min.css">
  <title>
    <?php echo $row['user_name'] ?> Profile
  </title>

</head>

<body>
  <div class="empty"></div>


  <div class="user-profile">

    <div class="user-info-box">

      <div class="user-image">

        <img
          src="<?php echo $row['user_profilebackground'] ? $row['user_profilebackground'] : '../BackgroundPic/pyh.jpg'; ?>"
          class="user-background" id="userBG" alt="background">



        <div style="position:absolute; bottom:0; width:100%;">
          <svg id="" preserveAspectRatio="xMidYMax meet" class="svg-separator sep1" viewBox="0 0 1600 160"
            style="z-index:7; background:transparent;" data-height="100">
            <path style="opacity: 1;fill: #ddd;" d="M1040,56c0.5,0,1,0,1.6,0c-16.6-8.9-36.4-15.7-66.4-15.7c-56,0-76.8,23.7-106.9,41C881.1,89.3,895.6,96,920,96
C979.5,96,980,56,1040,56z"></path>
            <path style="opacity: 1;" d="M1699.8,96l0,10H1946l-0.3-6.9c0,0,0,0-88,0s-88.6-58.8-176.5-58.8c-51.4,0-73,20.1-99.6,36.8
c14.5,9.6,29.6,18.9,58.4,18.9C1699.8,96,1699.8,96,1699.8,96z"></path>
            <path style="opacity: 1;" d="M1400,96c19.5,0,32.7-4.3,43.7-10c-35.2-17.3-54.1-45.7-115.5-45.7c-32.3,0-52.8,7.9-70.2,17.8
c6.4-1.3,13.6-2.1,22-2.1C1340.1,56,1340.3,96,1400,96z"></path>
            <path style="opacity: 1;" d="M320,56c6.6,0,12.4,0.5,17.7,1.3c-17-9.6-37.3-17-68.5-17c-60.4,0-79.5,27.8-114,45.2
c11.2,6,24.6,10.5,44.8,10.5C260,96,259.9,56,320,56z"></path>
            <path style="opacity: 1;" d="M680,96c23.7,0,38.1-6.3,50.5-13.9C699.6,64.8,679,40.3,622.2,40.3c-30,0-49.8,6.8-66.3,15.8
c1.3,0,2.7-0.1,4.1-0.1C619.7,56,620.2,96,680,96z"></path>
            <path class="" style="opacity: 1;" d="M-40,95.6c28.3,0,43.3-8.7,57.4-18C-9.6,60.8-31,40.2-83.2,40.2c-14.3,0-26.3,1.6-36.8,4.2V106h60V96L-40,95.6
z"></path>
            <path style="opacity: 1;" d="M504,73.4c-2.6-0.8-5.7-1.4-9.6-1.4c-19.4,0-19.6,13-39,13c-19.4,0-19.5-13-39-13c-14,0-18,6.7-26.3,10.4
C402.4,89.9,416.7,96,440,96C472.5,96,487.5,84.2,504,73.4z"></path>
            <path style="opacity: 1;" d="M1205.4,85c-0.2,0-0.4,0-0.6,0c-19.5,0-19.5-13-39-13s-19.4,12.9-39,12.9c0,0-5.9,0-12.3,0.1
c11.4,6.3,24.9,11,45.5,11C1180.6,96,1194.1,91.2,1205.4,85z"></path>
            <path style="opacity: 1;" d="M1447.4,83.9c-2.4,0.7-5.2,1.1-8.6,1.1c-19.3,0-19.6-13-39-13s-19.6,13-39,13c-3,0-5.5-0.3-7.7-0.8
c11.6,6.6,25.4,11.8,46.9,11.8C1421.8,96,1435.7,90.7,1447.4,83.9z"></path>
            <path style="opacity: 1;" d="M985.8,72c-17.6,0.8-18.3,13-37,13c-19.4,0-19.5-13-39-13c-18.2,0-19.6,11.4-35.5,12.8
c11.4,6.3,25,11.2,45.7,11.2C953.7,96,968.5,83.2,985.8,72z"></path>
            <path style="opacity: 1;" d="M743.8,73.5c-10.3,3.4-13.6,11.5-29,11.5c-19.4,0-19.5-13-39-13s-19.5,13-39,13c-0.9,0-1.7,0-2.5-0.1
c11.4,6.3,25,11.1,45.7,11.1C712.4,96,727.3,84.2,743.8,73.5z"></path>
            <path style="opacity: 1;" d="M265.5,72.3c-1.5-0.2-3.2-0.3-5.1-0.3c-19.4,0-19.6,13-39,13c-19.4,0-19.6-13-39-13
c-15.9,0-18.9,8.7-30.1,11.9C164.1,90.6,178,96,200,96C233.7,96,248.4,83.4,265.5,72.3z"></path>
            <path style="opacity: 1;" d="M1692.3,96V85c0,0,0,0-19.5,0s-19.6-13-39-13s-19.6,13-39,13c-0.1,0-0.2,0-0.4,0c11.4,6.2,24.9,11,45.6,11
C1669.9,96,1684.8,96,1692.3,96z"></path>
            <path style="opacity: 1;"
              d="M25.5,72C6,72,6.1,84.9-13.5,84.9L-20,85v8.9C0.7,90.1,12.6,80.6,25.9,72C25.8,72,25.7,72,25.5,72z">
            </path>
            <path style="" d="M-40,95.6C20.3,95.6,20.1,56,80,56s60,40,120,40s59.9-40,120-40s60.3,40,120,40s60.3-40,120-40
s60.2,40,120,40s60.1-40,120-40s60.5,40,120,40s60-40,120-40s60.4,40,120,40s59.9-40,120-40s60.3,40,120,40s60.2-40,120-40
s60.2,40,120,40s59.8,0,59.8,0l0.2,143H-60V96L-40,95.6z"></path>

            <!-- <animate attributeName="d" dur="3s" repeatCount="indefinite"
                            values="M10 80 Q 95 10 180 80; M10 80 Q 180 150 320 80; M10 80 Q 95 10 180 80" /> -->
          </svg>

        </div>


      </div>

      <div style="position: relative;">

        <div class="empty2">
          <img src="<?php echo $row['user_profilepicture'] ? $row['user_profilepicture'] : '../ProfilePic/tom.jpg'; ?>"
            class="user-pic" alt="profilepic">
          <p>
            <?php echo $row['user_name']; ?>
          </p>
        </div>

        <div class="user-info">
          <p>Email:
            <span>
              <?php echo $row['user_email']; ?>
            </span>
          </p>
          <p>Contact:
            <span>
              <?php echo $row['user_contact']; ?>
            </span>
          </p>
          <p>Join date:
            <span>
              <?php echo $row['user_signupdate']; ?>
            </span>
          </p>


          <div class="profileButtonBox">
            <form action="EditProfile.php" method="get" style="margin-bottom:10px;">
              <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
              <button type="submit" class="manage-profile ui black button">Manage your profile</button><br>
            </form>


            <form action="ChangePassword.php" method="GET">
              <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
              <button class="change-pass ui red button" type="submit" style="text-decoration: none; border: none;">
                Change Password
              </button>
            </form>
          </div>
        </div>

      </div>


      <!-- <div style="height:200px width:100%;"></div> -->


      <div class="user-book-info">
        <div class="favorite">
          <span class="ui favorite-title horizontal divider">FAVORITE</span>
          <span class="view-more"><a href="Favorites.php" class="view-more">View More</a></span>
          <div class="favorite-book">
            <?php
            if (mysqli_num_rows($favoriteresult) > 0) {
              while ($row = mysqli_fetch_assoc($favoriteresult)) {
                echo '<div class="book-cover">';
                echo '<div class="linear-bg"></div>';
                echo '<p class="book-title">' . $row['book_title'] . '</p>';
                echo '<button type="button" class="hidden-button" onclick="location.href=\'BookDetail.php?id=' . $row['book_id'] . '&page=1\'">View Detail</button>';
                echo '<img class="book-image" src="' . $row['book_cover'] . '" alt="Book Cover">';
                echo '</div>';
                // You can display other columns from the result as well
              }
            } else {
              echo '<div style="text-align: center; width: 100%;">
                    <span class="noBookAvailble">It looks like you don’t have any favorite book yet</span>
                    </div>';
            }
            ?>
            <!-- <button class="viewMore" type="button">MORE <i class="angle right icon"></i></button> -->
          </div>


          <div class="favorite" style="margin-top:100px;">
            <span class="ui favorite-title horizontal divider">WATCH RECORD</span>
            <span class="view-more"><a href="WatchRecord.php" class="view-more">View More</a></span>
            <div class="favorite-book">
              <?php
              if (mysqli_num_rows($recordResult) > 0) {
                while ($row = mysqli_fetch_assoc($recordResult)) {
                  echo '<div class="book-cover">';
                  echo '<div class="linear-bg"></div>';
                  echo '<p class="book-title">' . $row['book_title'] . '</p>';
                  echo '<button type="button" class="hidden-button" onclick="location.href=\'BookDetail.php?id=' . $row['book_id'] . '&page=1\'">View Detail</button>';
                  echo '<img class="book-image" src="' . $row['book_cover'] . '" alt="Book Cover">';
                  echo '</div>';
                  // You can display other columns from the result as well
                }
              } else {
                echo '<div style="text-align: center; width: 100%;">
            <span class="noBookAvailble">It looks like you don’t have any viewing history yet</span>
            </div>';
              }
              ?>
              <!-- You can go to <a href="BookList.php"> this page </a> to watch books -->
            </div>


          </div>
        </div>
      </div>

    </div>


    <!-- <div style="height:50px; width:100%;"></div> -->
    <div style="position:relative; top:0; width:100%; transform: scaleY(-1);">
      <svg id="" preserveAspectRatio="xMidYMax meet" class="svg-separator sep1" viewBox="0 0 1600 160"
        style="z-index:7; background:transparent;" data-height="100">
        <path class="animated-path" style="opacity: 1;fill: #ddd;" d="M1040,56c0.5,0,1,0,1.6,0c-16.6-8.9-36.4-15.7-66.4-15.7c-56,0-76.8,23.7-106.9,41C881.1,89.3,895.6,96,920,96
C979.5,96,980,56,1040,56z"></path>
        <path class="animated-path" style="opacity: 1;" d="M1699.8,96l0,10H1946l-0.3-6.9c0,0,0,0-88,0s-88.6-58.8-176.5-58.8c-51.4,0-73,20.1-99.6,36.8
c14.5,9.6,29.6,18.9,58.4,18.9C1699.8,96,1699.8,96,1699.8,96z"></path>
        <path class="animated-path" style="opacity: 1;" d="M1400,96c19.5,0,32.7-4.3,43.7-10c-35.2-17.3-54.1-45.7-115.5-45.7c-32.3,0-52.8,7.9-70.2,17.8
c6.4-1.3,13.6-2.1,22-2.1C1340.1,56,1340.3,96,1400,96z"></path>
        <path class="animated-path" style="opacity: 1;" d="M320,56c6.6,0,12.4,0.5,17.7,1.3c-17-9.6-37.3-17-68.5-17c-60.4,0-79.5,27.8-114,45.2
c11.2,6,24.6,10.5,44.8,10.5C260,96,259.9,56,320,56z"></path>
        <path class="animated-path" style="opacity: 1;" d="M680,96c23.7,0,38.1-6.3,50.5-13.9C699.6,64.8,679,40.3,622.2,40.3c-30,0-49.8,6.8-66.3,15.8
c1.3,0,2.7-0.1,4.1-0.1C619.7,56,620.2,96,680,96z"></path>
        <path class="animated-path" style="opacity: 1;" d="M-40,95.6c28.3,0,43.3-8.7,57.4-18C-9.6,60.8-31,40.2-83.2,40.2c-14.3,0-26.3,1.6-36.8,4.2V106h60V96L-40,95.6
z"></path>
        <path class="animated-path" style="opacity: 1;" d="M504,73.4c-2.6-0.8-5.7-1.4-9.6-1.4c-19.4,0-19.6,13-39,13c-19.4,0-19.5-13-39-13c-14,0-18,6.7-26.3,10.4
C402.4,89.9,416.7,96,440,96C472.5,96,487.5,84.2,504,73.4z"></path>
        <path class="animated-path" style="opacity: 1;" d="M1205.4,85c-0.2,0-0.4,0-0.6,0c-19.5,0-19.5-13-39-13s-19.4,12.9-39,12.9c0,0-5.9,0-12.3,0.1
c11.4,6.3,24.9,11,45.5,11C1180.6,96,1194.1,91.2,1205.4,85z"></path>
        <path class="animated-path" style="opacity: 1;" d="M1447.4,83.9c-2.4,0.7-5.2,1.1-8.6,1.1c-19.3,0-19.6-13-39-13s-19.6,13-39,13c-3,0-5.5-0.3-7.7-0.8
c11.6,6.6,25.4,11.8,46.9,11.8C1421.8,96,1435.7,90.7,1447.4,83.9z"></path>
        <path class="animated-path" style="opacity: 1;" d="M985.8,72c-17.6,0.8-18.3,13-37,13c-19.4,0-19.5-13-39-13c-18.2,0-19.6,11.4-35.5,12.8
c11.4,6.3,25,11.2,45.7,11.2C953.7,96,968.5,83.2,985.8,72z"></path>
        <path class="animated-path" style="opacity: 1;" d="M743.8,73.5c-10.3,3.4-13.6,11.5-29,11.5c-19.4,0-19.5-13-39-13s-19.5,13-39,13c-0.9,0-1.7,0-2.5-0.1
c11.4,6.3,25,11.1,45.7,11.1C712.4,96,727.3,84.2,743.8,73.5z"></path>
        <path class="animated-path" style="opacity: 1;" d="M265.5,72.3c-1.5-0.2-3.2-0.3-5.1-0.3c-19.4,0-19.6,13-39,13c-19.4,0-19.6-13-39-13
c-15.9,0-18.9,8.7-30.1,11.9C164.1,90.6,178,96,200,96C233.7,96,248.4,83.4,265.5,72.3z"></path>
        <path class="animated-path" style="opacity: 1;" d="M1692.3,96V85c0,0,0,0-19.5,0s-19.6-13-39-13s-19.6,13-39,13c-0.1,0-0.2,0-0.4,0c11.4,6.2,24.9,11,45.6,11
C1669.9,96,1684.8,96,1692.3,96z"></path>
        <path class="animated-path" style="opacity: 1;"
          d="M25.5,72C6,72,6.1,84.9-13.5,84.9L-20,85v8.9C0.7,90.1,12.6,80.6,25.9,72C25.8,72,25.7,72,25.5,72z"></path>
        <path class="animated-path" style="" d="M-40,95.6C20.3,95.6,20.1,56,80,56s60,40,120,40s59.9-40,120-40s60.3,40,120,40s60.3-40,120-40
s60.2,40,120,40s60.1-40,120-40s60.5,40,120,40s60-40,120-40s60.4,40,120,40s59.9-40,120-40s60.3,40,120,40s60.2-40,120-40
s60.2,40,120,40s59.8,0,59.8,0l0.2,143H-60V96L-40,95.6z"></path>

        <animate attributeName="d" dur="3s" repeatCount="indefinite"
          values="M10 80 Q 95 10 180 80; M10 80 Q 180 150 320 80; M10 80 Q 95 10 180 80" />
      </svg>

    </div>

    <div style="height:250px; width:100%; z-index:-50;"></div>

    <div class="footer" id="footer">


      <div class="footer" id="footer">


        <div class="contentFooter">
          <div class="footerTitle">
            <h1 class="">ONE LIBRARY</h1>
            <!-- <a href=""><i class="facebook icon"></i></a>
  <a href=""><i class="instagram icon"></i></a>
  <a href=""><i class="twitter icon"></i></a> -->
          </div>
          <!-- <div>
<a href=""><i class="facebook icon"></i></a>
</div> -->
          <div class="footerLink">

            <div class="link2">
              <p>CONTACT US</p>
              <ul class="a">
                <li><a href=""><i class="envelope outline icon"></i> onelibraryofficial@gmail.com</a></li>
                <li><a href=""><i class="phone alternate icon"></i> 011-2146 9831</a></li>
              </ul>
            </div>
          </div>
        </div>

</body>

</html>
<script>
  let userBackground = document.getElementById('userBG');

  window.addEventListener('scroll', function () {
    let value = window.scrollY;
    userBackground.style.top = value * 0.50 + 'px';
  })
</script>

<script src="../Fomantic-ui/dist/semantic.min.js"></script>

<style>
  .footer {
    position: fixed;
    bottom: 0;
    z-index: -20;
    background: radial-gradient(ellipse at bottom, #1b2735 0%, #081c5e 100%);
    /* background: #FFFBF5; */
    width: 100%;
    height: 400px;

    /* padding:40px 40px; */
  }

  .contentFooter {
    width: 70%;
    position: absolute;
    bottom: 50px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    justify-content: center;
    transition: 0.6s;
  }

  .contentFooter li {
    color: #fff;
  }

  .footerTitle h1 {
    /* color:#fff; */
    color: #fff;
    font-size: 40px;
    font-weight: 100;
    letter-spacing: 10px;
    padding: 35px 0px;
  }

  .footerTitle i {
    color: #fff;
    font-size: 23px;
    padding: 20px 40px 0px 0px;
  }

  .footerLink {
    margin-left: auto;
    display: flex;
    padding: 0px 0px;
  }

  .footerLink p {
    color: #fff;
    font-size: 27px;
    font-weight: 900;
    letter-spacing: 10px;
  }

  .footerLink a {
    color: #fff;
    text-decoration: none;
    transition: 0.4s;
    /* padding-bottom: 50px; */
  }

  .footerLink a:hover {
    color: #B4B4B3;
    text-decoration: none;
  }

  .footerLink .link1 {
    padding: 0px 0px;
  }

  .footerLink .link2 {
    /* border-left: 3px solid #D0D4CA; */
    padding: 0px 0px;
    /* margin-left:100px; */
  }

  .footerLink .link2 li {
    padding-bottom: 15px;
  }




  @keyframes move {
    0% {
      transform: translateX(0);
    }

    50% {
      transform: translateX(-90px);
    }

    100% {
      transform: translateX(0);
    }
  }

  .animated-path {
    animation: move 16s ease-in-out infinite;
  }

  .svg-separator {
    display: block;
    background: 0 0;
    position: relative;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 20;
    -webkit-transform: translateY(0%) translateY(2px);
    transform: translateY(0%) translateY(2px);
    width: 100%;
    filter: unset;
  }

  .svg-separator path {
    fill: #F5F7F8 !important;
  }

  .svg-separator.bottom {
    top: auto;
    bottom: 0;
  }

  .sep1 {
    transform: translateY(0%) translateY(0px) scale(1, 1);
    transform-origin: top;
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
    z-index: 4;
  }

  .book-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    background-repeat: no-repeat;
    background-position: center;
    transition: 0.4s;
    z-index: 1;
  }

  .book-title {
    color: #fff;
    position: absolute;
    bottom: 3%;
    left: 5%;
    /* transform: translate(-50%, -50%); */
    transition: 0.4s;
    opacity: 1;
    font-weight: 900;
    z-index: 5;
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
    z-index: 6;
    transition: 0.4s;
    opacity: 0;
    cursor: pointer;
  }

  .book-cover:hover {
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

  .book-cover:hover .book-image {
    transform: scale(1.2);
  }

  .hidden-button:hover {
    background: #fff;
    color: #000;
  }

  /* .................................................................................................... */
  /* .title{
        color:#fff !important;
    }
.navHref{
    color:#fff !important;
} */
  body {
    background: #F5F7F8 !important;
  }

  .empty {
    height: 0px;
    width: 100%;
  }

  .empty2 {
    height: 0px;
    width: 100%;
    margin: 0px 0px;
    text-align: center;
    position: relative;
    top: -230px;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 30;
  }

  .empty2 p {
    font-weight: 900;
    /* text-align:right; */
    font-size: 50px;
    padding: 0px 0px;
  }

  .user-profile {
    margin: 0px auto;
    width: 100%;

  }

  .user-info-box {
    background: #F5F7F8;
    /* border: 4px solid #000; */
    /* border-radius: 20px; */
    width: 100%;
    padding: 0px 0px;
    margin: 0px 0px;
    overflow: hidden;
    z-index: 40;
    /* height:610px; */
  }

  .user-image {
    height: 550px;
    overflow: hidden;
    position: relative;
    /* border-bottom: 4px solid #000; */
  }

  .user-background {
    width: 100%;
    height: 100%;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    object-fit: cover;
    filter: brightness(50%);
    z-index: 1;
    position: relative;
  }

  .user-pic {
    background: #fff;
    height: 330px;
    width: 330px;
    border: 4px solid #000;
    border-radius: 50%;
    z-index: 30;
    object-fit: cover;
  }

  .user-info {
    /* position:absolute; */
    padding: 20px 30px;
    background: #FFFBF5;
    border: 4px solid #000;
    border-radius: 10px;
    margin: 200px 20px 0px 20px
      /* top:32%;
    width:46%; */
      /* display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        grid-gap: 20px; */
  }

  .user-info p {
    font-size: 25px;
    font-weight: 900;
  }

  .user-info span {
    float: right;
    color: #7D7C7C;
    font-weight: 900;
  }

  .profileButtonBox {
    /* position: absolute; 
        bottom:30px;  */
    width: 100%;
    /* padding: 10px 20px; */
    display: flex;
  }

  .profileButtonBox form {
    width: 100%;
  }

  .profileButtonBox button {
    width: 99%;
  }

  .user-info .manage-profile {
    margin: 0px 0px;
    /* padding: 10px; */
    border-radius: 7px;
    border: 0px;
  }

  .user-info .change-pass {
    border-radius: 7px;
    border: 0px;
    float: right;
  }

  .user-book-info {
    background: #F5F7F8;
    /* border: 4px solid #000;
        border-radius: 20px; */
    width: 100%;
    padding: 0px 20px;
    margin-top: 50px;
    /* position: relative; */
  }

  .user-book-info .favorite-title {
    font-size: 40px;
    letter-spacing: 10px;
    font-family: 'Jost', sans-serif;
    text-align: center;
    font-weight: 100;
  }

  .user-book-info .view-more {
    font-size: 15px;
    float: right;
    font-weight: bold;
  }

  .favorite {
    text-align: center;
  }

  .favorite-book {
    width: 100%;
    height: 400px;
    margin: 20px 0px;
    display: flex;
  }

  .favorite-book .viewMore {
    background: #FFFBF5;
    color: #000;
    height: 100%;
    width: 10%;
    font-size: 20px;
    font-weight: 900;
    margin: 15px 0px;
    border: 3px solid #000;
    border-radius: 20px;
    cursor: pointer;
    transition: 0.4s;
  }

  .favorite-book .viewMore:hover {
    /* transform: scale(1.3); */
    font-size: 23px;
  }

  .favorite-book .noBookAvailble {
    font-family: 'Jost', sans-serif;
    color: #8c8c8c;
    font-size: 25px;
    height: 100%;
    /* 确保容器高度充足 */
    display: flex;
    justify-content: center;
    /* 水平居中 */
    align-items: center;
    /* 垂直居中 */
  }
</style>
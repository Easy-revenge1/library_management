<?php
include_once('../db.php');

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];

  // Fetch user information from the database
  $UserProfile = "SELECT * FROM `user` WHERE `user_id` = ?";
  $stmt = mysqli_prepare($conn, $UserProfile);
  mysqli_stmt_bind_param($stmt, "i", $user_id);
  mysqli_stmt_execute($stmt);
  $userAvatar = mysqli_stmt_get_result($stmt);

  if (!$userAvatar) {
    die("Error: " . mysqli_error($conn));
  }

  $userImage = mysqli_fetch_assoc($userAvatar);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" type="text/css" href="../Fomantic-UI/dist/semantic.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
  <link rel="icon" href="../logo/favicon.ico" type="image/x-icon">
</head>

<body>



  <div class="" id="nav">
    <a class="title" href="UserIndex.php">ONE LIBRARY</a>
    <div class="" id="rightMenu">
      <!-- <div class="item">
          <div class="ui icon input">
            <input class="search-input" type="text" placeholder="Search..." fdprocessedid="brlzed">
              <i class="search link icon"></i>
            </div>
          </div> -->
      <div class="navHrefBox">
        <a class="navHref" id="nav-a" href="BookList.php"><i class="book icon"></i>
          Book
        </a>
        <a class="navHref" id="nav-a" href="Favorites.php"><i class="bookmark icon"></i>
          Favorites
        </a>
        <a class="navHref" id="nav-a" href="AboutUs.php"><i class="users icon"></i>
          About Us
        </a>
        <a class="navHref" id="nav-a" href="ContactUs.php"><i class="phone alternate icon"></i>
          Contact Us
        </a>
      </div>

      <!-- <div class="ui hidden divider"></div> -->

      <div style="position: relative;">
        <div class="profileDropdown" <?php if (!isset($_SESSION['user_id'])) {
          echo 'style="display: none;"';
        } ?>>
          <?php if (isset($_SESSION['user_id'])) { ?>
            <div class="userProfile">
              <img
                src="<?php echo $userImage['user_profilepicture'] ? $userImage['user_profilepicture'] : '../ProfilePic/tom.jpg'; ?>"
                class="navAvatar" alt="profilepic">
              <div class="text" id="dropDownText">
                <?php echo $userImage['user_name']; ?>
              </div>
              <div class="navIconBox"><i class="dropdown icon dropIcon"></i> </div>
            </div>

            <div class="profileOption">
              <a class="" href="UserProfile.php"><i class="user icon"></i> Profile</a><br>
              <hr style="border: 1px solid #e6e6e6;">
              <a class="" href="Logout.php"><i class="log out icon"></i> Logout</a>
            </div>
          <?php } ?>
        </div>

        <!-- Login button -->
        <?php if (!isset($_SESSION['user_id'])) { ?>
          <button onclick="window.location.href='UserLogin.php'" name="login" class="navLoginButton">
            <i class="user icon"></i> LOGIN
          </button>
        <?php } ?>
      </div>

      <!-- <a class="ui item" id="nav-a" href="UserProfile.php">
        Profile
      </a>
      <a class="ui item" id="nav-a" href="Logout.php">
        Logout
      </a> -->
    </div>
  </div>

</body>

</html>
<script src="../Fomantic-UI/dist/semantic.min.js"></script>
<script>
  $('.dropdown')
    .dropdown({
      action: 'hide'
    })
    ; 
</script>
<script>
  var nav = document.getElementById('nav');
  var logo = document.querySelector('.title');
  var navLinks = document.querySelectorAll('.navHref');

  nav.style.background = "transparent";
  nav.style.padding = "30px 20px";
  nav.style.borderBottom = "0px solid #45474B";

  logo.style.color = "#fff";

  navLinks.forEach(function (navLink) {
    navLink.style.color = "#fff";
  });

  window.onscroll = function (event) {
    var scroll = window.pageYOffset;

    if (scroll > 5) {
      nav.style.background = "#FFFBF5";
      nav.style.padding = "20px 20px";
      nav.style.borderBottom = "0px solid #45474B";
      logo.style.color = "#000";

      navLinks.forEach(function (navLink) {
        navLink.style.color = "#000";
      });
    } else {
      nav.style.background = "transparent";
      nav.style.padding = "30px 20px";
      nav.style.borderBottom = "0px solid transparent";
      logo.style.color = "#fff";

      navLinks.forEach(function (navLink) {
        navLink.style.color = "#fff";
      });
    }
  };
</script>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@200&display=swap');
  @import url('https://fonts.googleapis.com/css2?family=Jost&display=swap');
  @import url('https://fonts.googleapis.com/css2?family=Teko:wght@300&display=swap');
  @import url('https://fonts.googleapis.com/css2?family=Arvo&display=swap');
  @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@200&display=swap');


  body {
    background: #dddddd !important;
  }

  #nav {
    width: 100%;
    position: fixed;
    /* padding: 30px 20px; */
    transition: 0.4s;
    z-index: 99;
    top: 0;
    /* backdrop-filter: blur(30px); */
    border-radius: 0px;
  }

  .title {
    font-family: 'Jost', sans-serif;
    font-size: 20px;
    position: absolute;
    padding: 0px 30px;
    letter-spacing: 10px;
    color: #000;
  }

  .title:hover {
    color: #000;
  }

  #nav-a {
    transition: 0.4s;
  }

  #rightMenu {
    display: flex;
    margin: 0px 20px;
    float: right;
    position: relative;
  }

  #rightMenu #nav-a {
    color: #000;
    padding-left: 30px;
  }

  .navHrefBox {
    margin: 0px 140px;
  }

  .dropDownProfile {
    border: 2px solid #000;
    margin: -11px 5px;
    padding: 5px;
    border-radius: 20px;
  }

  #dropDownText {
    width: 100%;
    margin-top: 6px;
    padding: 0px 7px;
    text-overflow: ellipsis;
    overflow: hidden;
  }

  #dropDownList {
    /* margin-top:13px; */
    margin: 16px 47px;
    border-radius: 0px;
  }

  /* #dropDownList a{
    border-radius:20px;
  } */
  .navAvatar {
    height: 30px;
    width: 30px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #000;
  }

  .navLoginButton {
    background: #fff;
    color: #000;
    border: 2px solid #000;
    border-radius: 10px;
    padding: 10px 20px;
    transition: 0.1s;
    margin: -10px 0px;
    cursor: pointer;
    position: fixed;
    right: 35px;
  }

  .navLoginButton:hover {
    background: #000;
    color: #fff;
  }

  .profileDropdown {
    height: 45px;
    width: 135px;
    background: #fff;
    border: 2px solid #000;
    border-radius: 10px;
    margin: -13px 0px;
    cursor: pointer;
    transition: 0.3s;
    overflow: hidden;
    position: fixed;
    right: 20px;
    white-space: nowrap;
    /* 防止文本换行 */
    overflow: hidden;
    /* 显示省略号 */
  }

  .profileDropdown:hover {
    height: 120px;
  }

  .dropIcon {
    transition: 0.4s;
  }

  .profileDropdown:hover .dropIcon {
    transform: rotate(180deg);
  }

  .userProfile {
    display: flex;
    padding: 6px;
    background: #fff;
    z-index: 5;
    position: relative;
  }

  .profileOption {
    width: 100%;
    padding: 10px;
    position: absolute;
    bottom: 0;
    z-index: 2;
  }

  .profileOption a {
    color: #000;
    font-size: 15px;
    padding: 20px 5px;
    transition: 0.2s;
  }

  .profileOption a:hover {
    color: #000;
  }

  .navIconBox {
    padding: 5px 0px;
  }
</style>
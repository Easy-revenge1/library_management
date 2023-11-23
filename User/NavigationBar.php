<?php 
include_once('../db.php');

// if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
//   echo  "Please Login First To Access This Content";
//   header("Location: UserLogin.php");
//   exit();
// }

if(isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];

  // 从数据库中获取用户信息
  $UserProfile = "SELECT * FROM `user` WHERE `user_id` = ?";
  $stmt = mysqli_prepare($conn, $UserProfile);
  mysqli_stmt_bind_param($stmt, "i", $user_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if (!$result) {
      die("Error: " . mysqli_error($conn));
  }

  $row = mysqli_fetch_assoc($result);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/semantic.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"
    integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"
    integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
  <link rel="stylesheet" href="Css/Main.css">
  <link rel="stylesheet" href="Sidebar.php">
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
      <a class="ui item" id="nav-a" href="BookList.php"><i class="book icon"></i>
        Book
      </a>
      <a class="ui item" id="nav-a" href="Favorites.php"><i class="bookmark icon"></i>
        Favorites
      </a>
      <a class="ui item" id="nav-a" href="#"><i class="users icon"></i>
        About Us
      </a>
      <a class="ui item" id="nav-a" href="#"><i class="phone alternate icon"></i>
        Contact Us
      </a>

      <!-- <div class="ui hidden divider"></div> -->
      <div class="ui floating dropdown" style="padding-left:30px;">
  <?php if(isset($_SESSION['user_id'])) { ?>
    <!-- 如果用户已登录，则显示用户信息 -->
    <div style="display:flex; background:#fff;" class="dropDownProfile">
      <img src="<?php echo $row['user_profilepicture'] ? $row['user_profilepicture'] : '../ProfilePic/tom.jpg'; ?>"
           class="navAvatar" alt="profilepic">
      <div class="text" id="dropDownText"> <?php echo $row['user_name']; ?> <i class="dropdown icon"></i></div> 
    </div>
    <div class="menu" id="dropDownList">
      <a class="item" href="UserProfile.php"><i class="user icon"></i> Profile</a>
      <a class="item" href="Logout.php"><i class="log out icon"></i> Logout</a>
    </div>
  <?php } else { ?>
    <!-- 如果用户未登录，则显示登录按钮 -->
    <button onclick="window.location.href='UserLogin.php'" name="login" class="navLoginButton"><i class="user icon"></i> LOGIN</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</html>
<script src="../Fomantic-ui/dist/semantic.min.js"></script>
<script>
$('.dropdown')
  .dropdown({
    action: 'hide'
  })
; 
</script>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@200&display=swap');
  @import url('https://fonts.googleapis.com/css2?family=Jost&display=swap');

  #nav {
    width: 100%;
    position: fixed;
    /* padding: 30px 20px; */
    transition: 0.4s;
    z-index: 3;
    top: 0;
    /* backdrop-filter: blur(30px); */
    border-radius:0px;
  }

  .title {
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
  #rightMenu{
    display:flex;
    margin:0px 20px;
    float:right;
    
  }
  #rightMenu #nav-a{
    color:#000;
    padding-left:30px;
  }
  .dropDownProfile{
    border:2px solid #000;
    margin:-11px 5px;
    padding:5px;
    border-radius:20px;
  }
  #dropDownText{
    margin-top:5px;
    padding:0px 7px;
  }
  #dropDownList{
    margin-top:13px;
    margin-left:190px;
    border-radius:0px;
  }
  /* #dropDownList a{
    border-radius:20px;
  } */
  .navAvatar{
    height:30px;
    width:30px;
    border-radius:50%;
    object-fit: cover;
    border:2px solid #000;
  }
  .navLoginButton{
    background:#fff;
    color:#000;
    border:2px solid #000;
    border-radius:20px;
    padding:10px 20px;
    transition:0.1s;
    margin:-10px 0px;
  }
  .navLoginButton:hover{
    background:#000;
    color:#fff;
  }
</style>
<script>
  var nav = document.getElementById('nav');
  // var navLoginButton = document.getElementsByClassName('navLoginButton')[0];

  nav.style.background = "transparent";
  nav.style.padding = "30px 20px";
  // nav.style.boxShadow = "0px 0px 0px 0px #7D7C7C";

  window.onscroll = function (event) {
    var scroll = window.pageYOffset;

    if (scroll > 5) {
      nav.style.background = "rgba(255, 255, 255)";
      nav.style.padding = "20px 20px";
      // nav.style.boxShadow = "7px 3px 7px 3px #7D7C7C";
    } else {
      nav.style.background = "transparent";
      nav.style.padding = "30px 20px";
      //  nav.style.boxShadow = "0px 0px 0px 0px #7D7C7C";
    }
  };
</script>
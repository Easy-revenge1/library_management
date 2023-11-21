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
      <a class="ui item" id="nav-a" href="UserProfile.php">
        Profile
      </a>
      <a class="ui item" id="nav-a" href="Logout.php">
        Logout
      </a>
    </div>
  </div>

</body>

</html>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@200&display=swap');
  @import url('https://fonts.googleapis.com/css2?family=Jost&display=swap');

  #nav {
    width: 100%;
    position: fixed;
    padding: 30px 20px;
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
    float:right;
  }
  #rightMenu a{
    color:#000;
    padding-left:30px;
  }
</style>
<script>
  var nav = document.getElementById('nav');

  nav.style.background = "transparent";
  // nav.style.boxShadow = "0px 0px 0px 0px #7D7C7C";

  window.onscroll = function (event) {
    var scroll = window.pageYOffset;

    if (scroll > 5) {
      nav.style.background = "rgba(255, 255, 255)";
      // nav.style.boxShadow = "7px 3px 7px 3px #7D7C7C";
    } else {
      nav.style.background = "transparent";
      //  nav.style.boxShadow = "0px 0px 0px 0px #7D7C7C";
    }
  };
</script>
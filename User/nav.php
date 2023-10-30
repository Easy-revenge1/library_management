<!DOCTYPE html>
<html lang="en">
  <head>
     <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/semantic.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="Css/Main.css">
  <link rel="stylesheet" href="Sidebar.php">
  </head>
<body>



    <div class="ui secondary menu" id="nav">
      <p class="title">ONE LIBRARY</p>
        <div class="right menu" id="right-menu">
          <div class="item">
          <div class="ui icon input">
            <input type="text" placeholder="Search..." fdprocessedid="brlzed">
              <i class="search link icon"></i>
            </div>
          </div>
          <a class="item" id="nav-a" href="UserIndex.php">
            Home
          </a>
          <a class="item" id="nav-a">
            Book
          </a>
          <a class="item" id="nav-a">
            About Us
          </a>
          <a class="ui item" href="" id="nav-a">
            Contact Us
          </a>
          <a class="ui item" href="#" id="nav-a">
            Profile
          </a>
          <a class="ui item" id="nav-a">
            Logout
          </a>
          <a class="ui item" id="nav-a">
            Logout
          </a>
        </div>
      </div>

</body>
</html>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@200&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Jost&display=swap');
#nav{
  width:100%;
  position:fixed;
  padding:20px 20px;
  transition:0.4s;
  z-index:3;
  top:0;
}
.title{
  font-size:20px;
  position:absolute;
  padding:5px 30px;
  letter-spacing:10px;
}
#nav-a{
  transition:0.4s;
}

</style>
<script>
var nav = document.getElementById('nav');

nav.style.background = "transparent";
// nav.style.boxShadow = "0px 0px 0px 0px #7D7C7C";

window.onscroll = function (event) {
  var scroll = window.pageYOffset;

  if (scroll > 5) {
    nav.style.background = "#fff";
    // nav.style.boxShadow = "7px 3px 7px 3px #7D7C7C";
  } else {
    nav.style.background = "transparent";
  //  nav.style.boxShadow = "0px 0px 0px 0px #7D7C7C";
  }
};
</script>
<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <!-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="flag-icon flag-icon-us"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right p-0">
        <a href="#" class="dropdown-item active" data-lang="en" onclick="updateLanguage('en');">
            <i class="flag-icon flag-icon-us mr-2"></i> English
          </a>
          <a href="#" class="dropdown-item" data-lang="ms">
            <i class="flag-icon flag-icon-de mr-2"></i> Malay
          </a>
          <a href="#" class="dropdown-item" data-lang="zh-hans">
            <i class="flag-icon flag-icon-fr mr-2"></i> Simplified Chinese
          </a>
          <a href="#" class="dropdown-item" data-lang="zh-hant">
            <i class="flag-icon flag-icon-es mr-2"></i> Traditional Chinese
          </a>
        </div>
      </li> -->

      <li class="nav-item">
        <a class="nav-link" href="Logout.php" role="button">
          <i class='fas fa-sign-out-alt'> Log Out</i>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- <script>
function updateLanguage(selectedLanguage) {
    console.log("Updating language:", selectedLanguage); // Debug statement

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "UpdateLanguage.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log("Response:", xhr.responseText); // Debug statement

                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert("Language updated successfully!");
                } else {
                    alert("Error updating language. Please try again later.");
                }
            } else {
                console.error("Request error:", xhr.status); // Debug statement
            }
        }
    };
    xhr.send("language=" + selectedLanguage);
}
</script> -->

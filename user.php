<?php 
include_once("db.php");

$query = "SELECT * FROM `user`";
$SQL   = mysqli_query($conn,$query);

?>

<!DOCTYPE html>
<html>
<head>
  <title>DIGITAL LIBRARY</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="fe.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</head>

<style>
    .searchbook {
      display: none;
    }
</style>

<body>
  <div class="topnav2">
    <div class="toptext">
      <span><a class="firstT" href="index_admin.php">DIGITAL</a></span>
      <span><a class="firstT2" href="index_admin.php">LIBRARY</a></span>
      <span class="firstT3">User List</span>
    </div>
    <div class="search-container">
      <form action="index_admin.php">
        <a href=""><i class="fa fa-user-circle-o"></i><?php echo $_SESSION["admin_name"]; ?></a>
      </form>
    </div>
  </div>

  <div class="sidebar2">
    <a class="" href="index_admin.php">HOME</a>
    <a href="book.php">BOOK</a>
    <a href="user.php">USER</a>
    <a href="">ABOUT</a>
  </div>

  <div class="idamt">
    <!-- Search Book Function -->
      <div class="booksearch">
        <button class="search-button" id="name-btn">Name</button>
        <button class="search-button" id="status-btn">Status</button>
        <button class="search-button" id="refresh-btn" onclick="clearSearchInputs()">Refresh</button>

        <div id="name-div" class="searchbook">
          <input type="text" class="search-input" placeholder="Enter the Name to search" name="name">
        </div>

        <div id="status-div" class="searchbook">
          <select class="search-input" name="status">
            <option value="">Select a status</option>
            <option value="online">Online</option>
            <option value="blacklisted">Blacklisted</option>
          </select>
        </div>
<!-- End of Search Function -->

    </div>
    </div>
    <div class="tableshow2">
      <table class="table"> 
        <thead class="trh">
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Contact</th>
          <th>Status</th>
          <th></th>
        </thead>
        <tbody id="user-table-body">
        <?php while ($row = mysqli_fetch_array($SQL)) { ?>
          <tr class="tdhv">
            <td><?= $row["user_id"] ?></td>
            <td><?= $row["user_name"] ?></td>
            <td><?= $row["user_email"] ?></td>
            <td><?= $row["user_contact"] ?></td>
            <td><?= $row["user_status"] ?></td>
            <td>
              <a href="edit_u.php?id=<?= $row['user_id'] ?>" class="edt"><i class="fa fa-pencil"></i></a>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
      <div id="no-user" style="display: none; color:red">No books are found</div>
    </div>
  </div>
</body>
</html>

<script>
    function clearSearchInputs() {
    $('.searchbook').hide();
    $('input[name="name"], input[name="name"]').val('');
    $('select[name="status"], select[name="status"]').prop('selectedIndex', 0).change();
    $('#user-table-body tr').show();
}

  function handleSearchButtonClick(inputElementId) {
      clearSearchInputs();
      $(`#${inputElementId}`).show();
  }

    $('#name-btn').on('click', function() {
      handleSearchButtonClick('name-div');
    });

    $('#status-btn').on('click', function() {
      handleSearchButtonClick('status-div');
    });

$(document).ready(function() {

$('input[name="name"], select[name="status"]').on('keyup change', function() {
  var nameSearchValue = $('input[name="name"]').val().toLowerCase();
  var statusSearchValue = $('select[name="status"]').val().toLowerCase();

  $('#user-table-body tr').each(function() {
    var name = $(this).find('td:eq(1)').text().toLowerCase();
    var status = $(this).find('td:eq(5)').text().toLowerCase();

    var nameMatches = name.includes(nameSearchValue);
    var statusMatches = statusSearchValue ? status === statusSearchValue : true; 

    if (nameMatches && statusMatches) {
      $(this).show();
    } else {
      $(this).hide();
    }
  });

  if ($('#user-table-body tr:visible').length === 0) {
    $('#no-user').show();
  } else {
    $('#no-user').hide();
  }
});
});

  </script>
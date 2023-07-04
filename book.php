<?php
include_once("db.php");

// Start Of Queries
$query = "SELECT book.*, category.category_name, language.language_name, bookstatus.BookStatus
          FROM book
          INNER JOIN category ON book.category_id = category.category_id
          INNER JOIN language ON book.book_language = language.language_id
          INNER JOIN bookstatus ON book.Status = bookstatus.BookStatusId";
$SQL = mysqli_query($conn, $query);

$categorySearch = "SELECT * FROM category";
$categoryResult = mysqli_query($conn, $categorySearch);

$languageSearch = "SELECT * FROM language";
$languageResult = mysqli_query($conn, $languageSearch);

// Delete Book
if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'delete') {
  $id = $_GET['id'];
  $Query = "DELETE FROM book WHERE book_id='$id'";
  if ($result = mysqli_query($conn, $Query)) {
    echo "<script>window.location.href = 'book.php'</script>";
  } else {
    echo "<script>alert('Record Fails to Delete')</script>";
  }
}

// Category Row Function
if (mysqli_num_rows($categoryResult) > 0) {
  // Generate options for the category select element
  $categoryOptions = '<option value="">Select a category</option>';
  while ($row = mysqli_fetch_assoc($categoryResult)) {
    $categoryOptions .= '<option value="' . $row["category_id"] . '|' . $row["category_name"] . '">' . $row["category_name"] . '</option>';
  }
} else {
  // Handle the case when no categories exist
  $categoryOptions = '<option value="">No categories found</option>';
}

// Language Row Function
if (mysqli_num_rows($languageResult) > 0) {
  // Generate options for the language select element
  $languageOptions = '<option value="">Select a language</option>';
  while ($row = mysqli_fetch_assoc($languageResult)) {
    $languageOptions .= '<option value="' . $row["language_id"] . '|' . $row["language_name"] . '">' . $row["language_name"] . '</option>';
  }
} else {
  // Handle the case when no languages exist
  $languageOptions = '<option value="">No languages found</option>';
}
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
  a {
    text-decoration: none;
    color: #8c8c8c;
  }
  .sort-link.asc::after {
  content: '\25b2'; /* Up arrow icon */
  margin-left: 5px;
}

.sort-link.desc::after {
  content: '\25bc'; /* Down arrow icon */
  margin-left: 5px;
}
</style>

<body>
  <div class="topnav2">
    <div class="toptext">
      <span><a class="firstT" href="index_admin.php">DIGITAL</a></span>
      <span><a class="firstT2" href="index_admin.php">LIBRARY</a></span>
      <span class="firstT3">BOOK</span>
    </div>
    <div class="search-container">
      <a href=""><i class="fa fa-user-circle-o"></i><?php echo $_SESSION["admin_name"]; ?></a>
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
      <button class="search-button" id="title-btn">Title</button>
      <button class="search-button" id="category-btn">Category</button>
      <button class="search-button" id="public-date-btn">Public Date</button>
      <button class="search-button" id="language-btn">Language</button>
      <button class="search-button" id="author-btn">Author</button>
      <button class="search-button" id="refresh-btn" onclick="clearSearchInputs()">Refresh</button>

      <div id="title-div" class="searchbook">
        <input type="text" class="search-input" placeholder="Enter the title to search" name="title">
      </div>

      <div id="category-div" class="searchbook">
        <select class="search-input" name="category">
          <?php echo $categoryOptions; ?>
        </select>
      </div>

      <div id="public-date-div" class="searchbook">
        <input type="date" id="datepicker" class="search-input" name="public_date">
      </div>

      <div id="language-div" class="searchbook">
        <select class="search-input" name="language">
          <?php echo $languageOptions; ?>
        </select>
      </div>

      <div id="author-div" class="searchbook">
        <input type="text" class="search-input" placeholder="Enter the author name to search" name="author">
      </div>
      <!-- End of Search Function -->
    </div>
  </div>
  <div class="tableshow">
    <table class="table">
      <thead class="trh">
        <th>#</th>
        <th><a href="#" class="sort-link" data-column="1">Title</a></th>
        <th><a href="#" class="sort-link" data-column="2">Author</a></th>
        <th><a href="#" class="sort-link" data-column="3">Public Date</a></th>
        <th><a href="#" class="sort-link" data-column="4">Language</a></th>
        <th><a href="#" class="sort-link" data-column="5">Category</a></th>
        <th>Status</th>
        <th>Edit</th>
        <th>Delete</th>
      </thead>
      <div>
        <tbody id="book-table-body">
          <?php while ($row = mysqli_fetch_array($SQL)) { ?>
            <tr class="tdhv">
              <td><?= $row["book_id"] ?></td>
              <td><?= $row["book_title"] ?></td>
              <td><?= $row["book_author"] ?></td>
              <td><?= $row["book_public_date"] ?></td>
              <td><?= $row["language_name"] ?></td>
              <td><?= $row["category_name"] ?></td>
              <td><?= $row["BookStatus"] ?></td>
              <td>
                <a href="edit.php?id=<?= $row['book_id'] ?>" class="edt"><i class="fa fa-pencil"></i></a>
              </td>
              <td>
                <a href="book.php?id=<?= $row['book_id'] ?>&action=delete" class="dltbtn" onclick="return confirm('Are you sure you want to Delete Book ID <?= $row['book_id'] ?>?');"><i class="fa fa-trash-o"></i></a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </div>
    </table>
    <div id="no-books" style="display: none; color:red">No books are found</div>
    <button class="uplbtn" onclick="window.location.href='upload.php'" style="margin-left: 10px;">
      <i class="fa fa-plus"></i> ADD
    </button>
  </div>
</html>


<script>
  function clearSearchInputs() {
    $('.searchbook').hide();
    $('input[name="title"], input[name="author"]').val('');
    $('select[name="category"], select[name="language"]').prop('selectedIndex', 0).change();
    $('#book-table-body tr').show();
  }

  function handleSearchButtonClick(inputElementId) {
    clearSearchInputs();
    $(`#${inputElementId}`).show();
  }

  $('#title-btn').on('click', function() {
    handleSearchButtonClick('title-div');
  });

  $('#category-btn').on('click', function() {
    handleSearchButtonClick('category-div');
  });

  $('#public-date-btn').on('click', function() {
    handleSearchButtonClick('public-date-div');
  });

  $('#language-btn').on('click', function() {
    handleSearchButtonClick('language-div');
  });

  $('#author-btn').on('click', function() {
    handleSearchButtonClick('author-div');
  });

  // Initialize datepicker
  $("#datepicker").datepicker();

  $(document).ready(function() {

    $('input[name="title"], input[name="author"], select[name="category"], select[name="language"]').on('keyup change', function() {
      var titleSearchValue = $('input[name="title"]').val().toLowerCase();
      var authorSearchValue = $('input[name="author"]').val().toLowerCase();
      var categorySearchValue = $('select[name="category"]').val() ? $('select[name="category"]').val().split('|')[1].toLowerCase() : '';
      var languageSearchValue = $('select[name="language"]').val() ? $('select[name="language"]').val().split('|')[1].toLowerCase() : '';

      $('#book-table-body tr').each(function() {
        var title = $(this).find('td:eq(1)').text().toLowerCase();
        var author = $(this).find('td:eq(2)').text().toLowerCase();
        var category = $(this).find('td:eq(5)').text().toLowerCase();
        var language = $(this).find('td:eq(4)').text().toLowerCase();

        var titleMatches = title.includes(titleSearchValue);
        var authorMatches = author.includes(authorSearchValue);
        var categoryMatches = categorySearchValue ? category === categorySearchValue : true;
        var languageMatches = languageSearchValue ? language === languageSearchValue : true;

        if (titleMatches && authorMatches && categoryMatches && languageMatches) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });

      if ($('#book-table-body tr:visible').length === 0) {
        $('#no-books').show();
      } else {
        $('#no-books').hide();
      }
    });
  });

// Sort Table Function
$('.sort-link').on('click', function(e) {
  e.preventDefault();
  var column = $(this).data('column');
  var order = $(this).hasClass('asc') ? 'desc' : 'asc';
  $('.sort-link').removeClass('asc desc arrow-up arrow-down');
  $(this).addClass(order).addClass(order === 'asc' ? 'arrow-down' : 'arrow-up');
  sortTable(column, order);
});

function sortTable(column, order) {
  var rows = $('#book-table-body tr').get();

  rows.sort(function(a, b) {
    var A = $(a).find('td:eq(' + column + ')').text().toUpperCase();
    var B = $(b).find('td:eq(' + column + ')').text().toUpperCase();

    if (A < B) {
      return order === 'asc' ? -1 : 1;
    }
    if (A > B) {
      return order === 'asc' ? 1 : -1;
    }

    return 0;
  });

  $('#book-table-body').empty(); // Clear table body

  $.each(rows, function(index, row) {
    $('#book-table-body').append(row);
  });
}

$('th:first-child').on('click', function() {
  $('.sort-link').removeClass('asc desc arrow-up arrow-down');
  sortTable(0, 'asc');
});
</script>

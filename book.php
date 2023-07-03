<?php 
include_once("db.php");

$query = "SELECT book.*, category.category_name, language.language_name 
          FROM book
          INNER JOIN category ON book.category_id = category.category_id
          INNER JOIN language ON book.book_language = language.language_id";
$SQL = mysqli_query($conn, $query);

$categorySearch = "SELECT * FROM category";
$categoryResult = mysqli_query($conn, $categorySearch);

$languageSearch = "SELECT * FROM language";
$languageResult = mysqli_query($conn, $languageSearch);

// Category Row Function
if (mysqli_num_rows($categoryResult) > 0) {
    // Generate options for the category select element
    $categoryOptions = "";
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
    $languageOptions = "";
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
        <th>Title</th>
        <th>Author</th>
        <th>Public Date</th>
        <th>Language</th>
        <th>Category</th>
        <th>Edit</th>
        <th>Delete</th>
    </thead>
    <div>
    <tbody id="book-table-body">
        <?php while($row = mysqli_fetch_array($SQL))  {?>
          <tr class="tdhv">
            <td><?=$row["book_id"]?></td>
            <td><?=$row["book_title"]?></td>
            <td><?=$row["book_author"]?></td>
            <td><?=$row["book_public_date"]?></td>
            <td><?=$row["language_name"]?></td>
            <td><?=$row["category_name"]?></td>
            <td>
              <a href="edit.php?id=<?=$row['book_id']?>" class="edt"><i class="fa fa-pencil"></i></a>
            </td>
            <td>
              <button class="dltbtn"><i class="fa fa-trash-o"></i></button>
            </td>
          </tr>
          <div id="no-books" style="display: none; color:red">No books are found</div>
        <?php } ?>
      </tbody>
    </div>
 </table>
 <button class="uplbtn" onclick="window.location.href='upload.php'" style="margin-left: 10px;">
    <i class="fa fa-plus"></i> ADD
  </button>
</div>
 </html>

 
 <script>
    function clearSearchInputs() {
    // hide all search boxes
    $('.searchbook').hide();
    // reset all input fields
    $('input[name="title"], input[name="author"]').val('');
    // set all select fields back to the first option
    $('select[name="category"], select[name="language"]').prop('selectedIndex', 0).change();
    // make all books visible
    $('#book-table-body tr').show();
}

  $(document).ready(function(){
    $('#title-btn').on('click', function() {
      $('.searchbook').hide();
      $('#title-div').show();
    });

    $('#category-btn').on('click', function() {
      $('.searchbook').hide();
      $('#category-div').show();
    });

    $('#public-date-btn').on('click', function() {
      $('.searchbook').hide();
      $('#public-date-div').show();
    });

    $('#language-btn').on('click', function() {
      $('.searchbook').hide();
      $('#language-div').show();
    });

    $('#author-btn').on('click', function() {
      $('.searchbook').hide();
      $('#author-div').show();
    });

    // Initialize datepicker
    $("#datepicker").datepicker();

  // Live search for title, author, category, and language
  $('input[name="title"], input[name="author"], select[name="category"], select[name="language"]').on('change keyup', function() {
    var titleValue = $('input[name="title"]').val().toLowerCase();
    var authorValue = $('input[name="author"]').val().toLowerCase();
    var categoryValue = $('select[name="category"]').val() ? $('select[name="category"]').val().split('|')[1].toLowerCase() : '';
    var languageValue = $('select[name="language"]').val() ? $('select[name="language"]').val().split('|')[1].toLowerCase() : '';
    var visibleRowCount = 0;

    $('#book-table-body tr').each(function() {
      var title = $(this).find('td:eq(1)').text().toLowerCase();
      var author = $(this).find('td:eq(2)').text().toLowerCase();
      var category = $(this).find('td:eq(5)').text().toLowerCase();
      var language = $(this).find('td:eq(4)').text().toLowerCase();

      var isTitleMatch = title.includes(titleValue);
      var isAuthorMatch = author.includes(authorValue);
      var isCategoryMatch = (categoryValue === '') || category === categoryValue;
      var isLanguageMatch = (languageValue === '') || language === languageValue;

      if (isTitleMatch && isAuthorMatch && isCategoryMatch && isLanguageMatch) {
        $(this).show();
        visibleRowCount++;
      } else {
        $(this).hide();
      }
    });

    if (visibleRowCount === 0) {
      $('#no-books').show();
    } else {
      $('#no-books').hide();
    }
  });
});

  </script>
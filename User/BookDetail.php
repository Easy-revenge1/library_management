<?php
include('../db.php');

$bookId = $_GET['id'];

$BookDetail = "SELECT * FROM `book` WHERE book_id = ?";

$stmt = mysqli_prepare($conn, $BookDetail);
mysqli_stmt_bind_param($stmt, 'i', $bookId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/reset.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/site.css">

    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/container.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/grid.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/header.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/image.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/menu.css">

    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/divider.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/segment.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/form.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/input.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/button.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/list.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/message.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/icon.css">
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/semantic.min.css">
</head>

<body>
    <div class="ui container">
        <div class="ui grid">
            <div class="four wide column">
                <img src="<?php echo !empty($row['book_cover']) ? $row['book_cover'] : 'book_cover.jpg'; ?>" alt="Item Image" class="ui fluid image">
            </div>
            <div class="twelve wide column">
                <h1 class="ui header">Item Name</h1>
                <p>Description of the item goes here.</p>
                <div class="ui label">$19.99</div>
                <div class="ui buttons">
                    <button class="ui blue button" id="addToCartButton">Add to Cart</button>
                    <button class="ui yellow button" id="favoriteButton">Favorite</button>
                </div>

                <div class="ui divider"></div>

                <h2 class="ui header">Reviews</h2>
                <div class="ui items">
                    <div class="item">
                        <div class="content">
                            <div class="header">Review Title 1</div>
                            <div class="meta">
                                <span class="rating">Rating: 4/5</span>
                            </div>
                            <div class="description">
                                <p>Review content goes here.</p>
                            </div>
                            <div class="extra">
                                <p>By User123 - 2023-10-31</p>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="content">
                            <div class="header">Review Title 2</div>
                            <div class="meta">
                                <span class="rating">Rating: 5/5</span>
                            </div>
                            <div class="description">
                                <p>Another review content here.</p>
                            </div>
                            <div class="extra">
                                <p>By User456 - 2023-10-30</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ui divider"></div>

                <h2 class="ui header">Add a Review</h2>
                <form class="ui form">
                    <div class="field">
                        <label>Rating</label>
                        <select class="ui dropdown">
                            <option value="5">5 - Excellent</option>
                            <option value="4">4 - Very Good</option>
                            <option value="3">3 - Good</option>
                            <option value="2">2 - Fair</option>
                            <option value="1">1 - Poor</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Review Title</label>
                        <input type="text" name="reviewTitle" placeholder="Enter your review title">
                    </div>
                    <div class="field">
                        <label>Review Comment</label>
                        <textarea rows="2" name="reviewComment" placeholder="Enter your review comment"></textarea>
                    </div>
                    <button class="ui primary button" type="submit">Submit Review</button>
                </form>

                <div class="ui divider"></div>

                <!-- <h2 class="ui header">Preview</h2>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/VIDEO_ID" frameborder="0" allowfullscreen></iframe> -->
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.2/semantic.min.js"></script>
    <script>
        // JavaScript for handling button clicks
        $(document).ready(function() {
            $("#addToCartButton").click(function() {
                // Handle the "Add to Cart" button click event
                // You can add your logic here
            });

            $("#favoriteButton").click(function() {
                // Handle the "Favorite" button click event
                // You can add your logic here
            });
        });
    </script>
</body>

</html>

<script src="../Fomantic-ui/dist/semantic.min.js"></script>
<script src="../Fomantic-ui/dist/components/form.js"></script>
<script src="../Formantic-ui/dist/components/transition.js"></script>
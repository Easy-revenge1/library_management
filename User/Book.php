<?php
include_once("../db.php");

$bookId = $_GET['id'];

$bookInfo = "SELECT * FROM `book` WHERE book_id = ?";
$stmt = mysqli_prepare($conn, $bookInfo);
$stmt->bind_param("s", $bookId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $filePath = $row['book_content'];
} else {
    die("Book not found");
}

$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Viewer</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        #pdf-container {
            flex: 1;
            display: flex;
            flex-wrap: wrap;
        }

        .double-page-view {
            width: 50%;
        }

        #toolbar {
            background-color: #f8f8f8;
            padding: 10px;
            text-align: center;
            position: sticky;
            bottom: 0;
        }

        button {
            margin: 5px;
        }
    </style>
    <script>
        var filePath = "<?php echo $filePath; ?>";
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
</head>

<body>
<div id="pdf-container"></div>
    <div id="toolbar">
        <button onclick="toggleViewMode()">Toggle View Mode</button>
        <button onclick="prevPage()">Previous Page</button>
        <button onclick="nextPage()">Next Page</button>
    </div>

    <script>
        // Initialize PDF.js
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';

        var pdfInstance;
        var currentPage = 1;

        // Fetch the PDF document
        var loadingTask = pdfjsLib.getDocument(filePath);

        // Render all pages of the PDF
        loadingTask.promise.then(function (pdf) {
            pdfInstance = pdf;

            // Get the total number of pages in the PDF
            var numPages = pdf.numPages;

            // Create a container div for the PDF viewer
            var container = document.getElementById('pdf-container');

            // Loop through all pages and render each one
            for (var pageNumber = 1; pageNumber <= numPages; pageNumber++) {
                pdf.getPage(pageNumber).then(function (page) {
                    // Create a container for each page
                    var pageContainer = document.createElement('div');
                    container.appendChild(pageContainer);

                    // Create a canvas element to render the page
                    var canvas = document.createElement('canvas');
                    pageContainer.appendChild(canvas);

                    // Set the canvas dimensions to match the PDF page
                    var viewport = page.getViewport({ scale: 1.5 });
                    canvas.width = viewport.width;
                    canvas.height = viewport.height;

                    // Render the PDF page on the canvas
                    var renderContext = {
                        canvasContext: canvas.getContext('2d'),
                        viewport: viewport
                    };
                    page.render(renderContext);
                });
            }

            // Set initial view mode
            toggleViewMode();
        });

        function toggleViewMode() {
            var container = document.getElementById('pdf-container');
            container.classList.toggle('double-page-view');

            // Update the view mode based on the class
            var isDoublePageView = container.classList.contains('double-page-view');
            if (isDoublePageView) {
                // Implement double page view logic
                showDoublePageView();
            } else {
                // Implement single page view logic
                showSinglePageView();
            }
        }

        function showDoublePageView() {
            var pages = document.querySelectorAll('#pdf-container > div');
            pages.forEach(function (page, index) {
                if (index % 2 === 0) {
                    page.style.order = index;
                    page.style.width = '50%';
                } else {
                    page.style.order = index - 1;
                    page.style.width = '50%';
                }
            });
        }

        function showSinglePageView() {
            var pages = document.querySelectorAll('#pdf-container > div');
            pages.forEach(function (page, index) {
                page.style.order = index;   
                page.style.width = '100%';
            });
        }

        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
            }
        }

        function nextPage() {
            if (currentPage < pdfInstance.numPages) {
                currentPage++;
                showPage(currentPage);
            }
        }

        function showPage(pageNumber) {
            // Hide all pages
            var pages = document.querySelectorAll('#pdf-container > div');
            pages.forEach(function (page) {
                page.style.display = 'none';
            });

            // Show the selected page
            var selectedPage = document.querySelector(`#pdf-container > div:nth-child(${pageNumber})`);
            selectedPage.style.display = 'block';
        }
    </script>
</body>

</html>

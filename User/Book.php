<?php
include_once("../db.php");

$bookId = $_GET['id'];
$userId = $_SESSION['user_id'];

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

$WatchRecordInsert = "INSERT INTO `watch_record` (`book_id`, `user_id`) VALUES (?, ?)";
$watchrecordstmt = mysqli_prepare($conn, $WatchRecordInsert);

mysqli_stmt_bind_param($watchrecordstmt, "ii", $bookId, $userId);
mysqli_stmt_execute($watchrecordstmt);
mysqli_stmt_close($watchrecordstmt);

?>

<!DOCTYPE html>
<html lang="en">

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
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/components/rating.min.css">
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
            flex-direction: column;
            align-items: center;
            overflow-y: auto;
        }

        .pdf-page {
            width: 100%;
            margin: 10px 0;
            position: relative;
        }

        .double-page-view .pdf-page {
            width: 50%;
        }

        #toolbar {
            background-color: #000;
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
    <div id="toolbar" class="ui container">
        <button class="ui button" onclick="toggleViewMode()">Toggle View Mode</button>
        <button class="ui button" onclick="prevPage()">Previous Page</button>
        <button class="ui button" onclick="nextPage()">Next Page</button>
        <button class="ui button" onclick="zoomIn()">Zoom In</button>
        <button class="ui button" onclick="zoomOut()">Zoom Out</button>
    </div>

    <script>
        // Initialize PDF.js
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';

        var pdfInstance;
        var currentPage = 1;
        var pdfScale = 1;

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

                    // Set the position for the first page to stick to the top
                    if (pageNumber === 1) {
                        pageContainer.style.position = 'absolute';
                        pageContainer.style.top = '0';
                    }

                    // Render the PDF page on the canvas
                    var renderContext = {
                        canvasContext: canvas.getContext('2d'),
                        viewport: viewport
                    };
                    page.render(renderContext);
                });
            }

        });

        function updatePagePositions() {
            var pageContainers = document.querySelectorAll('.pdf-page');

            pageContainers.forEach(function (pageContainer, index) {
                var isLastPage = index === pdfInstance.numPages - 1;

                if (isLastPage) {
                    pageContainer.style.position = 'absolute';
                    pageContainer.style.bottom = '0';
                } else {
                    pageContainer.style.position = 'relative';
                    pageContainer.style.bottom = 'auto';
                }
            });
        }

        function scrollPageTop() {
            var pageContainer = document.querySelector(`#pdf-container > div:nth-child(${currentPage})`);
            if (pageContainer) {
                pageContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        function scrollPageBottom() {
            var pageContainer = document.querySelector(`#pdf-container > div:nth-child(${currentPage})`);
            if (pageContainer) {
                pageContainer.scrollIntoView({ behavior: 'smooth', block: 'end' });
            }
        }

        function nextPage() {
            if (currentPage < pdfInstance.numPages) {
                currentPage++;
                scrollToPage(currentPage);
            } else {
                scrollPageBottom();
            }
        }

        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                scrollToPage(currentPage);
            } else {
                scrollPageTop();
            }
        }

        function scrollToPage(pageNumber) {
            var pageContainer = document.querySelector(`#pdf-container > div:nth-child(${pageNumber})`);
            if (pageContainer) {
                pageContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }

        function zoomIn() {
            if (pdfScale < 2) { // Limit maximum zoom to 2x
                pdfScale += 0.1; // You can adjust the zoom increment as needed
                updateZoom(); // Call the function to apply the new zoom
            }
        }

        function zoomOut() {
            if (pdfScale > 0.5) { // Limit minimum zoom to 0.5x
                pdfScale -= 0.1; // You can adjust the zoom decrement as needed
                updateZoom(); // Call the function to apply the new zoom
            }
        }

        function updateZoom() {
            var container = document.getElementById('pdf-container');
            container.style.transform = 'scale(' + pdfScale + ')';
            container.style.overflow = 'hidden'; // Prevent the scroll bar from scaling

            var pages = document.querySelectorAll('#pdf-container canvas');
            pages.forEach(function (canvas) {
                var ctx = canvas.getContext('2d');
                ctx.setTransform(1, 0, 0, 1, 0, 0);
                ctx.scale(pdfScale, pdfScale);
                canvas.style.transformOrigin = '0 0'; // Set the transform origin to the top-left corner
            });

            updatePagePositions();
        }


    </script>
</body>

</html>
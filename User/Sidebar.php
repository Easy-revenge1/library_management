<!DOCTYPE html>
<html>

<head>
    <title>Semantic UI Sidebar Variations</title>
    <link rel="stylesheet" type="text/css" href="../Fomantic-ui/dist/semantic.min.css">

    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous">
    </script>

    <script src="../Fomantic-ui/dist/semantic.min.js"></script>
    </script>
</head>

<body>
    <div class="ui left sidebar inverted vertical menu">
        <a class="item">Web Development</a>
        <a class="item">Machine Learning</a>
        <a class="item">Data Science</a>
        <a class="item">Blockchain</a>
    </div>
    <div class="ui dimmed pusher container">
        <br />
        <button class="ui button" onclick="toggleLeft()">
            Toggle Left Sidebar
        </button>
    </div>

    <script>
        const toggleLeft =
            () => $('.ui.left.sidebar').sidebar('setting',
                'transition', 'overlay').sidebar('toggle');
    </script>
</body>

</html>
<?php
// Start the session
session_start();
   require_once('dbConnect.php');
?>

    <html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="css/drag-and-drop.css" rel="stylesheet">
        <script src="drag-and-drop.js"></script>
        <title> EstimateMe</title>
    </head>

    <body>
        <?php require_once('nav_menu.php') ?>
        
        <div id="drop_zone" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);">
        <p>Drag one or more files to this Drop Zone ...</p>
        </div>
    </body>

    </html>
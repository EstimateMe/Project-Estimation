<!DOCTYPE html>
<html>
<head>
<link href="css/upload.css" rel="stylesheet">
</head>
<body>
    <?php require_once('nav_menu.php') ?>
        <table class="upload-table">
            <tr>
                <td> Импортирай ПРОЕКТИ в json формат </td>

                <td>
                    <form action="import.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="file" id="file" >
                        <br>
                        <input type="submit" name="submit" class="execute-import-button" value="Execute Import">
                    </form>
                </td>
            </tr>
            <tr>
                <td> Импортирай ПОТРЕБИТЕЛИ в json формат</td>

                <td>
                    <form action="import.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="file" id="file" >
                        <br>
                        <input type="submit" name="submit" class="execute-import-button" value="Execute Import">
                    </form>
                </td>
            </tr>

        </table>

        <!-- <div class="upload-btn-wrapper">
  <button class="btn">Upload a file</button>
  <input type="file" name="myfile" />
   <input id="execute-import-button" type="submit" name="submit" class="btn" value="Execute Import">
</div> -->
</body>

</html>
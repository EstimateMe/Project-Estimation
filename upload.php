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
                    <form action="import_projects.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="file" id="file" >
                        <br>
                        <input type="submit" name="submit" class="execute-import-button" value="Execute Import">
                    </form>
                </td>
            </tr>
            <tr>
                <td> Импортирай ПОТРЕБИТЕЛИ в json формат</td>

                <td>
                    <form action="import_users.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="file" id="file" >
                        <br>
                        <input type="submit" name="submit" class="execute-import-button" value="Execute Import">
                    </form>
                </td>
            </tr>

        </table>
</body>

</html>
<?php
// Start the session
session_start();
require_once('dbConnect.php');
$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

$stmt=$conn->prepare("Select * from project");
$stmt->execute();
$projects = $stmt->fetchAll();

?>

<html>
<head>
<link href="css/get_all_projects.css" rel="stylesheet">
<link rel="icon" type="image/png" sizes="32x32" href="icon.png">
<title> EstimateMe</title>
</head>
<body>
    <?php require_once('nav_menu.php') ?>
    <div class="direction">За да експортнете към JSON формат задачите по даден проект, моля изберете име на проект:</div>
    <div class="center">
        <form method="post" action="export.php">
            <select name="selected_project_name">
                <?php foreach($projects as $project ) {?>
                <option value="<?php echo $project->name; ?>"> <?php echo $project->name; ?> </option>
                <?php } ?>
            </select>
            <input class="export-button" type="submit" name="submit" value="Export to JSON"/>
        </form>
    </div>
</body>

</html>
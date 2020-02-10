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

<body>
    <?php require_once('nav_menu.php') ?>
    <div>
        <form method="post" action="export.php">
            <select name="selected_project_name">
                <?php foreach($projects as $project ) {?>
                <option value="<?php echo $project->name; ?>"> <?php echo $project->name; ?> </option>
                <?php } ?>
            </select>
            <input type="submit" name="submit"/>
        </form>
    </div>
</body>

</html>
<?php
// Start the session
session_start();
require_once('dbConnect.php');
$user = $_SESSION['session_user'];
$sql  = 'SELECT * FROM `task` where project_name=?';
$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
?>
<html>
<body>
    <?php require_once('nav_menu.php') ?>
</body>
</html>
<?php
if ($_FILES["file"]["error"] > 0) {
  echo "Error: No file supplied ";
} else {
// read the json file contents
$jsondata = file_get_contents( $_FILES["file"]["name"]);
$data     = json_decode($jsondata);
$import_success_count = 0;
$import_failure_count = 0;

foreach ($data as $projectJson) {
    $name              = $projectJson->name;
    $created_at        = $projectJson->created_at;
    $expert_estimation = $projectJson->expert_estimation;
    
    // Insert project in DB
    $sql = $conn->prepare("INSERT INTO `project`(`name`, `created_at`, `expert_estimation`) 
          VALUES (:name,:created_at,:expert_estimation)");
    if($sql->execute(['name'=>$name,'created_at'=>$created_at,'expert_estimation'=>$expert_estimation])) {
      $import_success_count++;
    } else {
      $import_failure_count++;
    }

    // Make current user the owner of the project in DB
    $sql = $conn->prepare("INSERT INTO `project-user`(`username`, `projectName`, `isOwner`) 
      VALUES (:username,:projectName,:isOwner)");
    $sql->execute(['username'=>$user,'projectName'=>$name,'isOwner'=>true]);
}
echo 'SUCCESSFUL ' .$import_success_count. ' FAILED ' .$import_failure_count. '';
}
?>
</body>
</html>



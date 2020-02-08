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
$data     = json_decode($jsondata, true);
$import_success_count = 0;
$import_failure_count = 0;

foreach ($data as $projectJson) {
    $project_name              = $projectJson['name'];
    $created_at        = $projectJson['created_at'];
    $expert_estimation = $projectJson['expert_estimation'];

        // Insert project in DB
        $sql = $conn->prepare("INSERT INTO `project`(`name`, `created_at`, `expert_estimation`) 
        VALUES (:name,:created_at,:expert_estimation)");
  if($sql->execute(['name'=>$project_name,'created_at'=>$created_at,'expert_estimation'=>$expert_estimation])) {
    $import_success_count++;
  } else {
    $import_failure_count++;
  }

  // Make current user the owner of the project in DB
  $sql = $conn->prepare("INSERT INTO `project-user`(`username`, `projectName`, `isOwner`) 
    VALUES (:username,:projectName,:isOwner)");
  $sql->execute(['username'=>$user,'projectName'=>$project_name,'isOwner'=>true]);

  // Insert tasks for project
    $tasks = $projectJson['tasks'];
    foreach($tasks as $task){ 
      $sql = $conn->prepare("INSERT INTO `task`(`title`, `description`, `project_name`, `status`, `expert_estimation`, `tags`, `actual_hours`) 
      VALUES (:title, :description, :project_name, :status, :expert_estimation, :tags, :actual_hours)");
     if( $sql->execute(['title'=>$task['title'],
                    'description'=>$task['description'],
                    'project_name'=>$project_name,
                    'status'=>'to_do',
                    'expert_estimation'=>$task['expert_estimation'],
                    'tags'=>$task['tags'],
                    'actual_hours'=>0])) {
       } else {
        echo 'There was a problem importing a task to project ' .$project_name. '<br>';
       }
  }
}

echo 'SUCCESSFUL ' .$import_success_count. ' <br/>FAILED ' .$import_failure_count. '';
}
?>
</body>
</html>



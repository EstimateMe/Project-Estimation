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

//Get the tags from the tags table
$q = $conn->prepare("SELECT * FROM tags");
$q->execute();

$tags_rows_from_db = $q->fetchAll(); // every tag_row hast tag_row->tag and tag_row->hours

// print_r(array_values($tags_rows_from_db));

foreach ($data as $projectJson) {
    $project_expert_estimation = 	0; // сума от expert_estimation на всяка задача към проекта; expert_estimation на задача се смята спрямо таговете й
    $project_name              = $projectJson['name'];
    $created_at        =  date('Y-m-d H:i:s'); // set project created_at to current date

  // Insert TASK for project
    $tasks = $projectJson['tasks'];
    foreach($tasks as $task){
      $task_expert_estimation = 0;
      $task_tags_array = explode(",", $task['tags']); // make tags array into string of tags

      // iterate over all tags of a task and create task expert estimation
      foreach($task_tags_array as $task_tag) {
        $sql = 'SELECT hours FROM `tags` where tag=?';
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $stmt = $conn->prepare($sql);
        $stmt->execute([$task_tag]);
        // echo $task_tag;
        $hour_for_task_tag = $stmt->fetchAll();
        // echo $hour_for_task_tag[0]->hours;
        $task_expert_estimation = $task_expert_estimation + $hour_for_task_tag[0]->hours;
      }
      // echo $task_expert_estimation;
      $project_expert_estimation = $project_expert_estimation + $task_expert_estimation;
      $sql = $conn->prepare("INSERT INTO `task`(`title`, `description`, `project_name`, `status`, `expert_estimation`, `tags`, `actual_hours`) 
      VALUES (:title, :description, :project_name, :status, :expert_estimation, :tags, :actual_hours)");
     if( $sql->execute(['title'=>$task['title'],
                    'description'=>$task['description'],
                    'project_name'=>$project_name,
                    'status'=>'to_do',
                    'expert_estimation'=>$task_expert_estimation,
                    'tags'=>$task['tags'],
                    'actual_hours'=>0])) {
       } else {
        echo 'There was a problem importing a task to project ' .$project_name. '<br>';
       }
  }

          // Insert project in DB
    $sql = $conn->prepare("INSERT INTO `project`(`name`, `created_at`, `expert_estimation`) 
          VALUES (:name,:created_at,:expert_estimation)");
    if($sql->execute(['name'=>$project_name,'created_at'=>$created_at,'expert_estimation'=>$project_expert_estimation])) {
      $import_success_count++;
    } else {
      $import_failure_count++;
    }
  
    // Make current user the owner of the project in DB
    $sql = $conn->prepare("INSERT INTO `project-user`(`username`, `projectName`, `isOwner`) 
      VALUES (:username,:projectName,:isOwner)");
    $sql->execute(['username'=>$user,'projectName'=>$project_name,'isOwner'=>true]);
}

echo 'SUCCESSFUL ' .$import_success_count. ' <br/>FAILED ' .$import_failure_count. '';
}

?>
</body>

</html>
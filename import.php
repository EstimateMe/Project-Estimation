<?php
// Start the session
session_start();
require_once('dbConnect.php');
$user = $_SESSION['session_user'];
$sql  = 'SELECT * FROM `task` where project_name=?';
$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
?>

<html>
<head>
</head>
<body>
<?php
//read the json file contents
$jsondata = file_get_contents('test.json');
$data     = json_decode($jsondata);

foreach ($data as $projectJson) {
    $name              = $projectJson->name;
    $created_at        = $projectJson->created_at; // TODO: handle
    $expert_estimation = $projectJson->expert_estimation;
    
    $sql = $conn->prepare("INSERT INTO `project`(`name`, `created_at`, `expert_estimation`) 
          VALUES (:name,:created_at,:expert_estimation)");
    $sql->execute(['name'=>$name,'created_at'=>$created_at,'expert_estimation'=>$expert_estimation]);

    $sql = $conn->prepare("INSERT INTO `project-user`(`username`, `projectName`, `isOwner`) 
      VALUES (:username,:projectName,:isOwner)");
    $sql->execute(['username'=>$user,'projectName'=>$name,'isOwner'=>true]);

    echo "\nDATA SUCCESSFULY IMPORTED!";
    
}
?>
</body>
</html>



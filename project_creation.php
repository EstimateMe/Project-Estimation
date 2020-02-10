<?php
if(isset($_POST["submit"])){ 
require_once('nav_menu.php');
require_once('dbConnect.php');

$user = $_POST['user'];
$project_name=$_POST['project_name'];
$timestamp = date('Y-m-d H:i:s');

$q = $conn->prepare("SELECT * FROM `project` WHERE name=:project_name");
$q->execute(['project_name'=>$project_name]);
$TR_ST = true;

if($q->rowCount() == 0) //no task with such title and project_name combination - these two forms the key for a task sp they have to be unique
{
  
$sql=$conn->prepare("INSERT INTO `project`(`name`, `created_at`) 
	      VALUES (:project_name, :created_at)");
		  $sql->execute(['project_name'=>$project_name, ':created_at'=>$timestamp]);
		  
$sql2=$conn->prepare("INSERT INTO `project-user`(`username`, `projectName`, `isOwner`)
	      VALUES (:username,:projectName, :isOwner)");
		  $sql2->execute(['username'=>$user,'projectName'=>$project_name, 'isOwner'=>$TR_ST]);


		  echo "\nProject successfully created!";
		  
}
else
{
	echo "A project with the same title already exists!";
}

}

?>
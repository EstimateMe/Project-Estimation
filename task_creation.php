<?php
   #var_dump($_POST);
if(isset($_POST["submit"])){ 
require_once('nav_menu.php');

require_once('dbConnect.php');

$title=$_POST['task_title'];  
$description=$_POST['task_description'];
$project_name=$_POST['project_name'];

$q = $conn->prepare("SELECT * FROM user WHERE title=:title, project_name=:project_name");
$q->execute(['title'=>$title, 'project_name'=>$project_name]);



if($q->rowCount() == 0) //no task with such title and project_name combination - these two forms the key for a task sp they have to be unique
{
  
$sql=$conn->prepare("INSERT INTO `task`(`title`, `description`, `project_name`) 
	      VALUES (:title,:description,:project_name)");
		  $sql->execute(['title'=>$title,'description'=>$description,'project_name'=>$project_name]);


		  echo "\nTask successfully created!";
		  
}
else
{
	echo "A task with the same title already exists!";
}

}

?>
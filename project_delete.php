<?php
if(isset($_POST["submit"])){ 
require_once('nav_menu.php');
require_once('dbConnect.php');

$user = $_POST['user'];
$project_name=$_POST['project_name'];

$q = $conn->prepare("Delete * FROM `project` WHERE name=:project_name");
$q->execute(['project_name'=>$project_name]);

  $q = $conn->prepare("Delete * FROM `project-user` WHERE name=:project_name && username:=username");
$q->execute(['project_name'=>$project_name, 'username'=>$user]);

 $q = $conn->prepare("Delete * FROM `task` WHERE name=:project_name && username:=username");
$q->execute(['project_name'=>$project_name, 'username'=>$user]);


  echo "\nProject successfully deleted!";
}

?>
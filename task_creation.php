<?php
 #  var_dump($_POST);

if(isset($_POST["submit"])){ 
require_once('nav_menu.php');

require_once('dbConnect.php');

$title=$_POST['task_title'];  
$description=$_POST['task_description'];
$tags=$_POST['tags'];
$project_name=$_POST['project_name'];
$expert_est=$_POST['hours'];
$username=$_POST['assigned_to']; 

$q = $conn->prepare("SELECT * FROM user WHERE title=:title, project_name=:project_name");
$q->execute(['title'=>$title, 'project_name'=>$project_name]);

$today = date_create()->format('Y-m-d');

if($q->rowCount() == 0) //no task with such title and project_name combination - these two forms the key for a task sp they have to be unique
{
  

	$q2 = $conn->prepare("SELECT expert_estimation, creation_date FROM `task` WHERE
    (datediff(CURRENT_DATE(), creation_date)*5.6)<expert_estimation 
	&& project_name=:project_name && user=:user
	&& creation_date >= all(select creation_date from task
	where project_name=:project_name && user=:user)");
    $q2->execute(['user'=>$username, 'project_name'=>$project_name]);
	$row = $q2->fetch(PDO::FETCH_OBJ);
	
	
	if($row)
	{
	$started_date = new DateTime($row->creation_date);
	$needed_days = ($row->expert_estimation) / 5.6;
	echo $needed_days;
	$rescheduled_date = date_modify($started_date, '+'.round($needed_days).' days')->format('Y-m-d H:i:s');
	echo $rescheduled_date;
	}
	else
	{
		$rescheduled_date = date('Y-m-d H:i:s');
	}
	
  
$sql=$conn->prepare("INSERT INTO `task`(`title`, `description`, `project_name`,`expert_estimation`,`tags`, `user`, `creation_date`) 
	      VALUES (:title,:description,:project_name,:expert_estimation,:tags, :user, :creation_date)");
		  $sql->execute(['title'=>$title,'description'=>$description,'project_name'=>$project_name,'expert_estimation'=>$expert_est,'tags'=>$tags,
		  'user'=>$username, 'creation_date'=>$rescheduled_date]);
		  
		 //new code 
$sum = 	0;
$stmt = $conn->prepare("SELECT * FROM task WHERE project_name=:project_name");
$stmt->execute(['project_name'=>$project_name]);
  while($row = $stmt->fetch(PDO::FETCH_OBJ)){
     $sum = $sum + ($row->expert_estimation);
  }
			  
  $sql=$conn->prepare("Update `project` SET expert_estimation =:sum WHERE name=:project_name");
 $sql->execute(['sum'=>$sum, 'project_name'=>$project_name]);
   //new code
		  echo "\nTask successfully created!";
		  
}
else
{
	echo "A task with the same title already exists!";
}

}

?>
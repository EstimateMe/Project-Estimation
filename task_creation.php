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

$date = date_create();

if($q->rowCount() == 0) //no task with such title and project_name combination - these two forms the key for a task sp they have to be unique
{
	$q = $conn->prepare("SELECT * FROM task
	WHERE project_name=:project_name && username=:user && (datediff(created_at, date)*5,6)<expert_estimation");
    $q->execute(['user'=>$username, 'project_name'=>$project_name]);
	if($q->rowCount() > 0)
	{
    $row = $q->fetch(PDO::FETCH_OBJ);
	$started_date = new DateTime($row->created_at);
	$needed_days = ($row->expert_estimation) / 5.6;
	$rescheduled_date = date_modify($started_date, '+'.$needed_days.' days');
	}
	else
	{
		$rescheduled_date = date('Y-m-d H:i:s');
	}
	
  
$sql=$conn->prepare("INSERT INTO `task`(`title`, `description`, `project_name`,`expert_estimation`,`tags`, `user`, `creation_date`) 
	                            VALUES (:title, :description, :project_name, :expert_estimation, :tags, :user, :creation_date)");
		  $sql->execute(['title'=>$title,'description'=>$description,'project_name'=>$project_name,
		  'expert_estimation'=>$expert_est,'tags'=>$tags, 'user'=>$username, 'creation_date'=>$rescheduled_date]);
		  
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
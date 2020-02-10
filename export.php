<!-- This file contains logic for exporting from the database all tasks for a project in json format -->

<?php
// Start the session
session_start();
require_once('dbConnect.php');
$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
// $conn->exec('SET NAMES utf8'); // NOT WORKING ;(
$project_name =$_POST['selected_project_name'];
?>

<?php


$stmt=$conn->prepare("SELECT * FROM task WHERE project_name=:project_name");
$stmt->execute(['project_name'=>$project_name]);
$tasks = $stmt->fetchAll();

$json_data=array();//create the array 
$json_data=array();//create the array  
foreach($tasks as $task)//foreach loop  
{  
    $json_array['title']=$task->title;
    $json_array['expert_estimation']=$task->expert_estimation;    
    $json_array['actual_hours']=$task->actual_hours;    
    $json_array['tags']=$task->tags;    
    $json_array['description']=$task->description;    
    $json_array['project_name']=$task->project_name;    

//here pushing the values in to an array  
    array_push($json_data,$json_array);  
  
}  
  
//built in PHP function to encode the data in to JSON format  
echo json_encode($json_data);  
 ?>



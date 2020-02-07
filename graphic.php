<?php
session_start();
require_once('dbConnect.php');

$array = array();
$project_name = "my projectN";//Choose a project name;

   $curr_date = date_create();
 /* 
 echo date_format($curr_date, "Y-m-d");
 */
  
   $stmt=$conn->prepare("Select * from project WHERE name=:project_name");
   $stmt->execute(['project_name'=>$project_name]);
   $row = $stmt->fetch(PDO::FETCH_OBJ);
   $datetime = $row->created_at;
   
   $exp_estimation = $row->expert_estimation;
   //$exp_estimation = 
   
   $started_date = new DateTime($datetime);
  
  /* echo $started_date->format('Y-m-d');*/
   
  /* echo $started_date;*/
   
   $sum_task_hours = 0;
   $finishedEnum = "finished";
  
   for ($i=$started_date; $i < $curr_date; date_modify($i, '+1 day')){
   
   $stmt = $conn->prepare("SELECT * FROM `task` WHERE project_name=:project_name && status =:status && finish_date=:finish_date");
   $stmt->execute(['project_name'=>$project_name, 'status'=> $finishedEnum, 'finish_date'=>($i->format('Y-m-d'))]);
		  
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

			$sum_task_hours = $sum_task_hours + ($row['actual_hours']);
			
		}
		$array[$i->format('Y-m-d')]=$sum_task_hours;
    }

$max_data = $sum_task_hours;

$max_width = 500;
$max_height = 200;

$xgap = $max_width/(count($array) + 1); // with add 1 so as to not to get the points stuck on the edge of the graph
$ygap = $max_height /(count($array) + 1);

//$one_unit = $max_height / $max_data;
$one_unit = $max_height / $exp_estimation;

?>
<svg viewbox = "0 0 <?php echo $max_width . " ". $max_height; ?>
 " style="font-size:12px; font-family:tahoma; background-color:#056795; width:50%;">

 <?php
   $num = $xgap;
   $num2 = $ygap;
   
   $points = "";
   $elements = "";
   
   foreach ($array as $key => $value)
   {
	   $y = ($value * $one_unit);
	   	 /*  reverted: $y = $max_height -($value * $one_unit);*/

$elements .= "<polyline points='$num,0 $num,$max_height' style = 'stroke:#ffffff22;'/>";
$elements .= "<polyline points='0,$num2 $max_width,$num2' style = 'stroke:#ffffff22;'/>";

$elements .= "<text x='$num' y=$max_height style='fill:white;'>$key</text>";

$remaining_tasks = $exp_estimation - $value;
$elements .= "<text x='$num' y='".($y - 10)."' style='fill:white;'>$remaining_tasks</text>";

$points .= " $num, $y ";
echo "<polyline points = '$points' style='stroke:white; fill:#056795'/>";

$elements .= "<circle r='5' cx = '$num', cy='$y' style='stroke:white; fill:grey'/>";
	   
	   $num +=$xgap;
	   $num2 +=$ygap;
	   
   }
   echo $elements;
   ?>
 
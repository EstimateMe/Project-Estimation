<?php
session_start();
require_once('dbConnect.php');

$array = array();
$project_name = "myProject";//Choose a project name;

   $curr_date = date_create();
   
   $stmt=$conn->prepare("Select * from project WHERE name=:project_name");
   $stmt->execute(['project_name'=>$project_name]);
   $row = $stmt->fetch(PDO::FETCH_OBJ);
   $datetime = $row->created_at;
   
   $exp_estimation = $row->expert_estimation;
   $days_estimated = $exp_estimation / 8;  // не е е точно целочисленото деление - това са дните общо работа
   
   $started_date = new DateTime($datetime);
   
   $sum_task_hours = 0;
   $num_of_tasks = 0;
   $interval = 0;
  
  date_modify($started_date, '+1 day');
   for ($i=$started_date; $i < $curr_date; date_modify($i, '+1 day')){
   
   
   $stmt = $conn->prepare("SELECT * FROM `task` WHERE project_name=:project_name && creation_date<=:point_in_time");
   $stmt->execute(['project_name'=>$project_name, 'point_in_time'=>($i->format('Y-m-d'))]); 
		   
		    $sum_task_hours = 0;
		   $num_of_tasks = 0;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$num_of_tasks += 1;


     $date_creation = new DateTime($row['creation_date']); 
     $interval = ($date_creation->diff($i))->d;

     if($row['expert_estimation'] <= (5.6*$interval))//productive 5,6
	 {
	 $sum_task_hours = $sum_task_hours + $row['expert_estimation'];

     }
			
		}
		$array[$i->format('Y-m-d')]=$sum_task_hours;
    }



  $work_completion_est = (ceil($days_estimated) / $num_of_tasks) /0.7;   //0.7 productivity of programmers;
  
	
$max_width = 500;
$max_height = 200;
$array_size = count($array);

$xgap = $max_width  / (ceil($work_completion_est)+2); // with add 1 so as to not to get the points stuck on the edge of the graph
$ygap = $max_height / (($array_size)+2);

$one_unit = $max_height / $exp_estimation;

   $ideal_line = $xgap . ', ' . $ygap . ' ' . ($max_width-$xgap) . ', ' . ($max_height - $ygap) . ' ';
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
	   $y = ($value * $one_unit) + $ygap;
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

   echo "<polyline points =  '$ideal_line' style='stroke:red; fill:#056795'/>";
   $elements .= "<polyline points='0,$num2 $max_width,$num2' style = 'stroke:#ffffff22;'/>";

   echo $elements;
   echo "<circle r='5' cx ='".($max_width-$xgap)."', cy='".($max_height-$ygap)."' style='stroke:white; fill:grey'/>";

   ?>
 
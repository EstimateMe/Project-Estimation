<?php
   $array = array();

   $curr_date = date_create();
   
   $stmt=$conn->prepare("Select * from project WHERE name=:project_name");
   $stmt->execute(['project_name'=>$project_name]);
   $row = $stmt->fetch(PDO::FETCH_OBJ);
   $datetime = $row->created_at;
   
   $exp_estimation = $row->expert_estimation;
   $days_estimated = $exp_estimation / 8;  // не е е точно целочисленото деление - това са дните общо работа
   
   $started_date = new DateTime($datetime);
   
   $sum_task_hours = 0;
   $x_value_of_tasks = 0;
   $interval = 0;
  
  date_modify($started_date, '+1 day');
   for ($i=$started_date; $i < $curr_date; date_modify($i, '+1 day')){
   
   
   $stmt = $conn->prepare("SELECT * FROM `task` WHERE project_name=:project_name && creation_date<=:point_in_time");
   $stmt->execute(['project_name'=>$project_name, 'point_in_time'=>($i->format('Y-m-d'))]); 
		   
		    $sum_task_hours = 0;
		   $x_value_of_tasks = 0;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$x_value_of_tasks += 1;


     $date_creation = new DateTime($row['creation_date']); 
     $interval = ($date_creation->diff($i))->d;

     if($row['expert_estimation'] <= (5.6*$interval))//productive 5,6
	 {
	 $sum_task_hours = $sum_task_hours + $row['expert_estimation'];

     }
			
		}
		$array[$i->format('Y-m-d')]=$sum_task_hours;
    }

if ($x_value_of_tasks>0)
{
  $work_completion_est = (ceil($days_estimated) / $x_value_of_tasks) /0.7;   //0.7 productivity of programmers;

	
$max_width = 500;
$max_height = 200;
$array_size = count($array);

$x_interval = $max_width  / (ceil($work_completion_est)+2); // with add 1 so as to not to get the points stuck on the edge of the graph
$y_interval = $max_height / (($array_size)+2);

$one_unit = $max_height / $exp_estimation;

   $ideal_line = $x_interval . ', ' . $y_interval . ' ' . ($max_width-$x_interval) . ', ' . ($max_height - $y_interval) . ' ';
?>

<div style="text-align:center">
 <h3 style="text-align:center">Burn down chart (Estimated):</h3>

<svg viewbox = "0 0 <?php echo $max_width . " ". $max_height; ?>
 " style="font-size:12px; font-family:tahoma; background-color:white; width:50%; display:block; margin:auto;">

 <?php
   $x_value = $x_interval;
   $y_value = $y_interval;
   
   $points = "";
   $elements = "";
   

   
   foreach ($array as $key => $value)
   {
	   $y = ($value * $one_unit) + $y_interval;
	   	 /*  reverted: $y = $max_height -($value * $one_unit);*/

echo "<polyline points='$x_value,0 $x_value,$max_height' style = 'stroke:#BEBEBE;'/>";
echo "<polyline points='0,$y_value $max_width,$y_value' style = 'stroke:#BEBEBE;'/>";

$elements .= "<text x='$x_value' y=$max_height style='fill:black;'>$key</text>";

$remaining_tasks = $exp_estimation - $value;
$elements .= "<text x='$x_value' y='".($y - 10)."' style='fill:black;'>$remaining_tasks</text>";

$points .= " $x_value, $y ";

$elements .= "<circle r='5' cx = '$x_value', cy='$y' style='stroke:black; fill:#DB4C2C'/>";
	   
	   $x_value +=$x_interval;
	   $y_value +=$y_interval;
	   
   }
    
	echo "<polyline points='0,$y_value $max_width,$y_value' style = 'stroke:#BEBEBE;'/>";
    echo "<polyline points =  '$ideal_line' style='stroke:red; fill:none'/>";
    echo "<polyline points = '$points' style='stroke:green; fill:none'/>";
    
	echo $elements;
    echo "<circle r='5' cx ='".($max_width-$x_interval)."', cy='".($max_height-$y_interval)."' style='stroke:black; fill:#DB4C2C'/>";

} ?> 
<h3 style="color:red"> 
 ___ ideal burndown
</h3>

<h3 style="color:green">
___ remaining tasks
</h3>
</div>


   
 
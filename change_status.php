<?php

$status=$_POST['status']; // предадено от ajax data
$title=$_POST['task_title'];
if(empty($status) || !empty($title)) {
    echo 0;
}


if(!empty($status) && !empty($title)) {	
// echo $title;
// echo $status;
require_once('dbConnect.php');
$sql=$conn->prepare("Update `task` SET status =:status WHERE title=:title");
if($sql->execute(['status'=>$status, 'title'=>$title])){
    echo "success";
} else {
    echo "fail";
}
}

?>
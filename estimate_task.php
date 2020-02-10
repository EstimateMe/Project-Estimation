<?php

$tags=$_POST['tags'];

if(empty($tags))
echo 0;

if(!empty($tags)) {
	
require_once('dbConnect.php');

//divide the tags string into an array of separate tags
$tags_arr=explode(",",$tags);

$sum=0;

foreach($tags_arr as $tag_elem):

$q = $conn->prepare("SELECT * FROM tags WHERE tag=:tag_elem"); 
$q->execute(['tag_elem'=>$tag_elem]);

if($q->rowCount() != 0)
{
	$row = $q->fetch(PDO::FETCH_OBJ);
	
	//sum the hours from all tags
    $sum=$sum+$row->hours;
}
endforeach;

echo $sum;
}

?>
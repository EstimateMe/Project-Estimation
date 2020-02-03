<?php
$title = $_POST['title'];
if(empty($title))
echo "Моля въведете име на задача!";
else {
require_once('dbConnect.php');
$q = $conn->prepare("SELECT * FROM task WHERE title LIKE CONCAT('%', :title, '%') LIMIT 1");
$q->execute(['title'=>$title]);

if($q->rowCount() == 0)
{
echo "Няма задачи с подобно име!";
}
else
{
$rows = $q->fetchAll();    
    foreach($rows as $row):
	 echo $row['description'];
    endforeach;
}
}
?>
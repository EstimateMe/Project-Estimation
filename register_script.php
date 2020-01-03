<?php
   #var_dump($_POST);
if(isset($_POST["submit"])){ 

require_once('dbConnect.php');

$user=$_POST['username'];  
$pass=$_POST['password'];
$email=$_POST['email'];
$account=$_POST['account_type'];


$q = $conn->prepare("SELECT * FROM user WHERE username=:username");
$q->execute(['username'=>$user]);

if($q->rowCount() == 0) //no users with such username/password combination
{
	$sql=$conn->prepare("INSERT INTO `user`(`username`, `password`, `email`, `account_type`) 
	      VALUES (:username,:password,:email,:account_type)");
		  $sql->execute(['username'=>$user,'password'=>$pass,'email'=>$email,'account_type'=>$account]);
		  echo "\nUser successfully created!";
		  
}
else
{
	echo "Username already exists!";
}

}

?>
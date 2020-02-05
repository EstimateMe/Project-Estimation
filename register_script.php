<?php
#echo $_POST['account_type'];
require_once('dbConnect.php');

$user=$_POST['username'];  
$pass=$_POST['password'];
$email=$_POST['email'];
$account=$_POST['account_type'];

$hash=password_hash($_POST['password'], PASSWORD_BCRYPT);

$q = $conn->prepare("SELECT * FROM user WHERE username=:username");
$q->execute(['username'=>$user]);

if($q->rowCount() == 0) //no users with such username/password combination
{
	$sql=$conn->prepare("INSERT INTO `user`(`username`, `password`, `email`, `account_type`) 
	      VALUES (:username,:password,:email,:account_type)");
		  $sql->execute(['username'=>$user,'password'=>$hash,'email'=>$email,'account_type'=>$account]);
		  echo 'User successfully created!';
}
else
{
	echo "Username already exists!";
}

?>
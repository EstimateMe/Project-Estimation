<?php
$host = 'localhost:3306'; //port of database
$dbname = 'user_registration'; //name of database
$username = 'root';
$password = '123'; //default=''


// Create connection
try {
	
    $conn = new PDO('mysql:host=localhost:3306;dbname=user_registration',$username,$password);
    print "Connected to $dbname at $host successfully.";
	
} catch (PDOException $pe) {

    die("Could not connect to the database $dbname : " . $pe->getMessage());
}
?>
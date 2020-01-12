<?php
$host = 'localhost: 3306'; //port of database
$dbname = 'estimateme'; //name of database
$username = 'root';
$password = ''; //default=''


// Create connection
try {
	
    $conn = new PDO('mysql:host=localhost;dbname=estimateme',$username,$password);
    //print "Connected to $dbname at $host successfully.";
	
} catch (PDOException $pe) {

    die("Could not connect to the database $dbname : " . $pe->getMessage());
}
?>
<?php
var_dump($_POST);
if(isset($_POST["submit"])){ 
 
  require_once('dbConnect.php');
  
if(!empty($_POST['username']) && !empty($_POST['password'])) { 

    $user=$_POST['username'];  
    $pass=$_POST['password']; 
    $q = $conn->query("SELECT * FROM user");
    $rowcount = $q->rowCount();

    if($rowcount!=0)
    {
while ($row = $q->fetch()) {
    
    echo $row['username']."<br />\n";
	
    $dbusername=$row['username'];  
    $dbpassword=$row['password'];
    
if($user == $dbusername && $pass == $dbpassword)  
    {  
    session_start();  
    $_SESSION['session_user']=$user;  
  
    /* Redirect browser */  
    header("Location: landing_page.html");  
    }
    }
    }    
    else {  
    echo "Invalid username or password!";  
    } 
}	
else {  
    echo "All fields are required!";  
}  
}

?>
<?php
#var_dump($_POST);
$msg="";
if(isset($_POST["submit"])){ 
 
  require_once('dbConnect.php');

    $user=$_POST['username'];  
    $pass=$_POST['password'];
	
    $q = $conn->prepare("SELECT * FROM user WHERE username=:username");
	$q->execute(['username'=>$user]);
	
    if($q->rowCount()>0) {
		$row = $q->fetch();
    
        if( password_verify($pass,$row['password'])) {
			session_start();  
            $_SESSION['session_user']=$user;  
  
            /* Redirect browser */  
            header("Location: landing_page.php");  
		}
	}
	else  
		$msg="Invalid username or password!";  
    }    	

?>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>
Project Estimation
</title>
<link rel="icon" type="image/png" sizes="32x32" href="icon.png">
<link rel="stylesheet" href="main.css">
</head>
<body>

<div class="container">
<div class="header">
<center>Project Estimation</center>
</div>

<div class="form_holder">
<h2><center>Вход</center></h2>

<?php 
if ($msg != "") 
	echo $msg . "<br><br>"; 
?>

<form id="login_form" name="login_form" method="post" action="login.php">

   Потребителско име: <input type="text" name="username" value="">
   <span class="error"></span>

   Парола: <input type="password" name="password">
   <span class="error"></span>
   
   <input type="submit" name="submit" class="btn" value="Вход">

   <a href="register.php" class="btn">Регистрация</a>
   </form>
   </div>
   <div class="footer"> Made by Diana Ivanova, Svetlana Grueva &amp Yana Zdravkova</div>
</div>  

</body>
</html>
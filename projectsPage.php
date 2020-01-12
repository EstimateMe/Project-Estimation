<?php
// Start the session
session_start();
?>

<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

	<link href="css/projectsPage.css" rel="stylesheet">
	<title> EstimateMe</title>
</head>

<body>
	 <?php
	 require_once('nav_menu.php');
  $user = $_SESSION['session_user'];
   require_once('dbConnect.php');
  $sql = 'SELECT * FROM `project-user` where username=?';
  $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
  $stmt = $conn->prepare($sql);
  $stmt->execute([$user]);
  $projectUsers = $stmt->fetchAll();
  
  $TRUE_ST = true;
 // echo '<br>';
   foreach($projectUsers as $projectUser){
   $projectName = $projectUser->projectName;
   
  $sql = 'SELECT * FROM `project-user` where projectName=? && isOwner=?';
  $stmt = $conn->prepare($sql);
  $stmt->execute([$projectName, $TRUE_ST]);
  $row = $stmt->fetch();
  $lead=$row->username;
  
  $sql = 'SELECT * FROM `project` where name=?';
  $stmt = $conn->prepare($sql);
  $stmt->execute([$projectName]);
  $row = $stmt->fetch();
  $creationDate= $row->created_at;
  echo '<a href="current_project.php?name=' . $projectName . '"> <span class="projectBox" >';
	  print('<h3>' . $projectName . '</h3>' 
	   . 'The owner is: '
	   . $lead 
	   . '<br> <br>'
	   . 'created at: '
	   . '<br>'
	   . $creationDate
	   . '<br>');
	 '</span> </a>';	
    
  }
	 ?>
	 
	
	<main>
		<section>	
		</section>
	</main>
		<footer id="end">
			
		</footer>
	</body></html>
	
	

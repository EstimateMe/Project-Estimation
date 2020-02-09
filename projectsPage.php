<?php
session_start();
 require_once('nav_menu.php');
   require_once('dbConnect.php');
    $user = $_SESSION['session_user'];
	$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
?>

<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

		<link href="css/projectsPage.css" rel="stylesheet">
	   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="createProjectScript.js"></script>
		<link href="css/createProject.css" rel="stylesheet">
	
		
	<title> EstimateMe</title>
</head>

<body>
            <main>
                <div>
				<?php
				  $sql = 'SELECT * FROM `user` WHERE username=?';
				 
				$stmt = $conn->prepare($sql);
				$stmt->execute([$user]);
				$row = $stmt->fetch();
				$accType=$row->account_type;
				
				if ($accType == "Manager"){
                   echo '<button id="create-project-button">Създай нов проект</button>';
				
				}
				?>
                        <div id="myModal" class="modal">
                            <div class="modal-content">
                                <form id="create-project-form" name="login_form" method="post" action="project_creation.php">

                                    Заглавие:
                                    <input type="text" name="project_name" id="project_name"> 
									 <input type="hidden" name="user" value='<?php echo "$user";?>' />
                                    <input id="create-button" type="submit" name="submit" class="btn" value="Създай">
                                </form>
                            </div>
                    </div>
                </div>

	 <?php
	 
   
  $sql = 'SELECT project_name FROM `task` 
  where user=?
  union 
  Select projectName from `project-user`
  where username=?';
  $stmt = $conn->prepare($sql);
  $stmt->execute([$user, $user]);
  $projects = $stmt->fetchAll();
  
  $TRUE_ST = true;
   foreach($projects as $project){
   $projectName = $project->project_name;
   
   //намира създателя
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
  $estimateProject=$row->expert_estimation;
  
  
  echo '<a href="current_project.php?name=' . $projectName . '"> <span class="projectBox" >';
	  print('<h3 id="title_project">' . $projectName . '</h3>' 
	   . 'The owner is: '
	   . $lead 
	   . '<br> <br>'
	   . 'created at: '
	   . $creationDate
	   . '<br><br>'
	   . 'Expert estimation: '
	   . $estimateProject
	   . '<br>');
	 '</span> </a>';	
    
  }
	 ?>
	</main>
		<footer id="end">
			
		</footer>
	</body></html>
	
	

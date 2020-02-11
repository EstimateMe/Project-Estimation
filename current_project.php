<?php
// Start the session
session_start();
$project_name = $_GET['name'];
 require_once('dbConnect.php');
  $sql = 'SELECT * FROM `task` where project_name=?';
  $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
  $stmt = $conn->prepare($sql);
  $stmt->execute([$project_name]);
  $tasks = $stmt->fetchAll();
  
  //account_type
        $user = $_SESSION['session_user'];
  	  $sql = 'SELECT * FROM `user` WHERE username=?';
				 
				$stmt = $conn->prepare($sql);
				$stmt->execute([$user]);
				$row = $stmt->fetch();
				$accType=$row->account_type;
   //
  

  //Get the tags from the tags table
  $q = $conn->prepare("SELECT tag FROM tags");
  $q->execute();

$a=array();
  $rows = $q->fetchAll();
  foreach($rows as $row):
  array_push($a,$row->tag);
  endforeach;
  #echo json_encode($a);
?>

    <html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="css/current-project.css" rel="stylesheet">
        <link rel="stylesheet" href="tags.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	   
        <script type="text/javascript" src="autofill.js"></script>
        <script type="text/javascript" src="tags.js"></script>
        <script src="current-project.js"></script>

        <title> EstimateMe</title>
    </head>

    <body>
        <?php require_once('nav_menu.php') ;
		if ($accType == "Manager"){
						
						echo '<button id="create-task-button">Създай нова задача</button>';

                        echo '<button id="delete-project-button">Изтрий проекта</button>';
		}
		?>
            <main>
                <div>
						
                    <h1 class="description"> <?php echo $project_name;?> </h1>
                    <div>
                        <br>
                        <!-- TODO: populate description from DB -->
                        <div>
                        </div>
                        <div>
                            <table class="tasks-table" id="tasks-table">
                                <tr>
                                    <th>Статус</th>
                                    <th>Име на задачата</th>
                                    <th>Експертна сложност</th>
                                </tr>
                                <?php foreach($tasks as $task): ?>
                                <tr>
                                <td>
                                <!-- TODO: submit status change with AJAX Ask Svetle how -->
                                <form id="change-status" name="change_status_form" method="post" action="change_status.php"> 
                                <select name="status-select">        
                                    <option value="to_do">TO DO</option>
                                    <option value="in_progress">IN PROGRESS</option>
                                    <option value="finished">DONE</option>
                                </select>
                                <input type="submit" name="submit" value="Смени"/>
                                <input type="hidden" name="task_name" value='<?php echo "$task->title";?>'/>
                                </form>
                              </td>
                                <td><?php echo $task->title; ?></td>
                                <td><?php echo $task->expert_estimation; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
					 <!-- new code -->
					 <br>
					 <br>
					<div id="expertEstChart"> <?php  require_once('graphic.php'); ?> </div>
					<!--!>
                        <!-- The Modal -->
                        <div id="myModal" class="modal">

                            <!-- Modal content -->
                            <div class="modal-content">
                                <h2><center>Създаване на нова задача</center></h2>
                                <form id="create-task-form" name="login_form" method="post" action="task_creation.php">

                                    Заглавие
                                    <input type="text" name="task_title" id="task_title"> 
									Описание
                                    <textarea rows="2" cols="50" name="task_description" id="task_description" form="create-task-form"> </textarea>
									Избери изпълнител на задачата:
									<input type="text" id="assigned_to" name="assigned_to"> 

									<!--pass the possible tag values to a hidden filed-->
                                    <input type='hidden' id='arr' value='<?php echo implode(',', $a) ?>'>
                                    <script type="text/javascript">
                                        //Functionality for tag display and autofill
                                        $(function() {
                                      //      console.log(typeof $('#arr')); //object
                                            var p = $('#arr').val();
                                            p = p.split(',');
                                     //       console.log(typeof p); //string

                                            $('#tags').tags({
                                                requireData: true,
                                                unique: true
                                            }).autofill({
                                                data: p
                                            });
                                        });
                                    </script>

                                    <!-- pass the project name to task_creation.php but not display it-->
                                    <input type='hidden' name='project_name' value='<?php echo "$project_name";?>' />
									Тагове
									<input type="text" id="tags" name="tags">
									Часове
									<input type="text" id="hours" name="hours" value='0'>

                                    <input id="create-button" type="submit" name="submit" class="btn" value="Създай">
									
                                    <input id="display-button" type="button" name="display-button" class="btn" value="Оцени задача">
                                </form>
                            </div>
                        </div>

		 <div id="deleteProject" class="modal">
                            <div class="delete-content">
                                <form id="delete-project-form" name="delete-project" method="post" action="project_delete.php">
                                    Сигурни ли сте, че искате да изтриете този проект? Всички задачи към него ще бъдат изгубени?
									 <input type="hidden" name="user" value='<?php echo "$user";?>' />
							         <input type="hidden" name="project_name" value='<?php echo "$project_name";?>' />
                                     <input id="delete-yes" type="submit" name="submit" class="btn" value="Да">
								     <button type="button" id="delete-no">Не</button>

								   
                                </form>
								 
                            </div>
                        </div>
						
						
                    </div>
                </div>

            </main>
            <footer id="end">

            </footer>
    </body>

    </html>
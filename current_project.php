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
        <?php require_once('nav_menu.php') ?>

            <main>
                <div>
                    <button id="create-task-button">Създай нова задача</button>

                    <h1 class="description"> Описание на Проекта </h1>
                    <div>
                        <br>
                        <br>
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
                                <?php 
                            foreach($tasks as $task) {
                            $title = $task->title;
                            $status = $task->status;
                            $expert_estimation =$task->expert_estimation;
                              echo '<tr> <td>' . $status . '</td> <td>'
                                    . $title 
                                    . '</td> <td>' .$expert_estimation. ' </td> </tr>';
                            }
                            ?>
                            </table>
                        </div>
                        <!-- The Modal -->
                        <div id="myModal" class="modal">

                            <!-- Modal content -->
                            <div class="modal-content">
                                <h2><center>Създаване на нова задача</center></h2>
                                <form id="create-task-form" name="login_form" method="post" action="task_creation.php">

                                    Заглавие
                                    <input type="text" name="task_title" id="task_title"> 
									Описание
                                    <textarea rows="5" cols="50" name="task_description" id="task_description" form="create-task-form"> </textarea>
									Избери изпълнител на задачата:
									<input type="text" id="assigned_to" name="assigned_to"> 

									
									
									<!--pass the possible tag values to a hidden filed-->
                                    <input type='hidden' id='arr' value='<?php echo ' "'.implode(',', $a).'" ' ?>'>
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
									<input type="text" id="hours" name="hours">

                                    <input id="create-button" type="submit" name="submit" class="btn" value="Създай">
									
                                    <input id="display-button" type="button" name="display-button" class="btn" value="Покажи сходна задача">
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
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
?>

    <html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="css/current-project.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
                        <?php 
                            foreach($tasks as $task) {
                            $title = $task->title;
                            $description = $task->description;
                              echo '<h2>' . $title . '</h2>' 
                                    . 'Description: '
                                    . $description 
                                    . '<br> <br>';
                            }
                            ?>
                        </div>
                        <!-- The Modal -->
                        <div id="myModal" class="modal">

                            <!-- Modal content -->
                            <div class="modal-content">
                                <h2><center>Създаване на нова задача</center></h2>
                                <form id="create-task-form" name="login_form" method="post" action="task_creation.php">

                                    Заглавие
                                    <input type="text" name="task_title" id="task_title"> 
									<div id="suggesstion-box"></div>
									Описание
                                    <textarea rows="4" cols="50" name="task_description" id="task_description" form="create-task-form"> </textarea>
                                    <!-- pass the project name to task_creation.php but not display it-->
                                    <input type='hidden' name='project_name' value='<?php echo "$project_name";?>' />

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
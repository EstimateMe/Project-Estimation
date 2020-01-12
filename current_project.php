<?php
// Start the session
session_start();
$project_name = $_GET['name'];
?>

    <html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="css/current-project.css" rel="stylesheet">
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
                        <section>
                        </section>
                        <!-- The Modal -->
                        <div id="myModal" class="modal">

                            <!-- Modal content -->
                            <div class="modal-content">
                                <h2><center>Създаване на нова задача</center></h2>
                                <form id="create-task-form" name="login_form" method="post" action="task_creation.php">

                                    Заглавие<input type="text" name="task_title">
                                    Описание<textarea rows="4" cols="50" name="task_description" form="create-task-form"> </textarea>
                                    <!-- pass the project name to task_creation.php but not display it-->
                                    <input type='hidden' name='project_name' value='<?php echo "$project_name";?>'/> 

                                    <input id="create-button" type="submit" name="submit" class="btn" value="Създай">
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
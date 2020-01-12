<?php
// Start the session
session_start();
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
                                <form id="create-task-form" name="login_form" method="post" action="login_script.php">

                                    Заглавие<input type="text" name="username">
                                    Описание<textarea rows="4" cols="50" name="description" form="create-task-form"> </textarea>
                                    

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
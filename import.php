<?php
// Start the session
session_start();
   require_once('dbConnect.php');
  $sql = 'SELECT * FROM `task` where project_name=?';
  $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
?>

<html>
<head>
</head>
<body>
<?php
    //read the json file contents
    $jsondata =file_get_contents('test.json');
    $data = json_decode($jsondata, true);
    echo '<div>' . $data . '</div>';
?>
</body>
</html>
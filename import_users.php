<?php
// Start the session
session_start();
require_once('dbConnect.php');
$user = $_SESSION['session_user'];
$sql  = 'SELECT * FROM `task` where project_name=?';
$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
?>
<html>
<body>
    <?php require_once('nav_menu.php') ?>
</body>
</html>
<?php
if ($_FILES["file"]["error"] > 0) {
  echo "Error: No file supplied ";
} else {
// read the json file contents
$jsondata = file_get_contents( $_FILES["file"]["name"]);
$data     = json_decode($jsondata);

foreach ($data as $userJson) {
    $username = $userJson->username;
    $password = $userJson->password; 
    $email = $userJson->email;
    $account_type = $userJson->account_type;
    
    $sql = $conn->prepare("INSERT INTO `user`(`username`, `password`, `email`, `account_type`) 
          VALUES (:username, :password, :email, :account_type)");
    $sql->execute(['username'=>$username,'password'=>$password,'email'=>$email,'account_type'=>$account_type]);
    echo "\nDATA SUCCESSFULY IMPORTED!";
}
}
?>
</body>
</html>



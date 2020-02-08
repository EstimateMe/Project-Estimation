<?php
// Start the session
session_start();
require_once('dbConnect.php');
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
$import_success_count = 0;
$import_failure_count = 0;

foreach ($data as $userJson) {
    $username = $userJson->username;
    $password = $userJson->password; 
    $email = $userJson->email;
    $account_type = $userJson->account_type;
    
    // Insert user in DB
    $sql = $conn->prepare("INSERT INTO `user`(`username`, `password`, `email`, `account_type`) 
          VALUES (:username, :password, :email, :account_type)");
    if($sql->execute(['username'=>$username,'password'=>$password,'email'=>$email,'account_type'=>$account_type])){
        $import_success_count++;
    } else {
        $import_failure_count++;
    }
}
echo 'SUCCESSFUL ' .$import_success_count. ' FAILED ' .$import_failure_count. '';
}
?>
</body>
</html>



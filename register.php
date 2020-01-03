<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script type="text/javascript" src="validate_registration.js"></script>
<title>
Project Estimation
</title>
<link rel="icon" type="image/png" sizes="32x32" href="icon.png">
<link rel="stylesheet" href="main.css">
</head>
<body>

<div class="container">
					 
<div class="form_holder">
<h2><center>Register</center></h2>
<form id="register_form" method="post" action="register_script.php" onsubmit="return validateForm();">

   Тип акаунт: 
   <input type="radio" name="account_type" value="Manager"> Manager
   <input type="radio" name="account_type" value="Developer"> Developer<br><br>
   <span id="error-type-acc" class="err"></span><br>
   
   E-mail: <input type="text" name="email" value="" >
   <span id="error-email" class="err"></span><br>
   
   Потребителско име: <input type="text" name="username" value="">
   <span id="error-username" class="err"></span><br>

   Парола: <input type="password" name="password">
   <span id="error-password" class="err"></span><br>
   
   Повтори Парола: <input type="password" name="confirm_password">
   <span id="error-confirm-password" class="err"></span><br>
   
   <input type="submit" name = "submit" class="btn" value="Register"><br>
   </form>
   </div>
   <div class="footer"> Made by Diana Ivanova, Svetlana Grueva &amp Yana Zdravkova</div>
</div>
  
</body>
</html>

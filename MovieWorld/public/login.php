<?php

require_once __DIR__ . '../../boot/boot.php';

use Movie\User;

//Check if user is logged in
$userId = User::getCurrentUserId();
if(!empty($userId)){
    header('Location: /public '); 
  return;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/icon/favicon.ico">
    <title>Login Form</title>
    <link href="css/signup.css" type="text/css" rel="stylesheet"/>
</head>
<body>
     <main>
        <div class="container">
            <div class="space">
                <h2>Login Form</h2>
            </div>
            <form method="post" action="actions/login.php">
                <?php if (!empty($_GET['error'])){?>
                    <h1>Login Error</h1> 
                    <?php } ?>
                <div class="space">
                    <label for="Email-login">Email</label>
                    <input class="space" id="Email-login" type="text" name="email" placeholder="Enter Email" required/>
                </div>
                <div class="space">
                    <label for="Password-login">Password</label>
                    <input  class="space" id="Password-login" type="password" name="password" placeholder="Enter Password" required/>
                </div>
                <div class="space">                
                    <button class="sub-b" type="submit">Login</button>
                </div>
            </form>
        </div>
     </main>
  </body>
</html>
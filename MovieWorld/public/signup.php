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
    <title>Registration form</title>
    <link href="css/signup.css" type="text/css" rel="stylesheet"/>
</head>
<body>
     <main>
        <div class="container">
            <div class="space">
                <h2>Register Form</h2>
            </div>
            <form method="post" action="actions/signup.php">
                <?php if (!empty($_GET['error'])){?>
                    <h1>Register Error</h1> 
                    <?php } ?>
                <div class="space">
                    <label for="Name-register">Name</label>
                    <input class="space" id="Name-register" type="text" name="name" placeholder="Enter Name" required/>
                </div>
                <div class="space">
                    <label for="Email-register">Email</label>
                    <input class="space" id="Email-register" type="text" name="email" placeholder="Enter Email" required/>
                </div>
                <div class="space">
                    <label for="Password-register">Password</label>
                    <input  class="space" id="Password-register" type="password" name="password" placeholder="Enter Password" required/>
                </div>
                <div class="space">                
                    <button class="sub-b" type="submit">Register</button>
                </div>
            </form>
        </div>
     </main>
  </body>
</html>
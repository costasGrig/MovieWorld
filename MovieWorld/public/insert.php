<?php

require_once __DIR__ . '../../boot/boot.php';

use Movie\Post;
use Movie\User;

$post =new Post();

//Check if user is logged in
$userId = User::getCurrentUserId();
if(empty($userId)){
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
    <title>Share your favorite movie!</title>
    <link rel="icon" type="image/x-icon" href="assets/icon/favicon.ico">
    <link rel="stylesheet" href="css/signup.css">
</head>
<body>
    <main>
        <div class="container">
            <div class="space">
                <h1>Movie post form</h1>
            </div>
            <form action="actions/insert.php" method="post">
                <div class="space">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" required>
                </div>
                <div class="space">
                    <label for="post" class="form-label">Add your post</label>
                    <textarea type="text" class="form-control" name="post" required></textarea>
                </div>
                <div class="space">
                    <button class="sub-b" type="submit">Submit</button>    
                </div>
            </form>
        </div>
    </main>
</body>
</html>
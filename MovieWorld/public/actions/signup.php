<?php

//Boot application
require_once __DIR__ . '../../../boot/boot.php';

use Movie\User;

//Return to home page unless it's get method
if(strtolower($_SERVER['REQUEST_METHOD']) != 'post' || !empty(User::getCurrentUserId())){
    header('Location: /public');
    return;
}

//Create new user
$user = new User();

$user->insert($_REQUEST['name'],$_REQUEST['email'],$_REQUEST['password']);

//Find user
$userInfo = $user->getByEmail($_REQUEST['email']);

//Generate Token
$token = $user->generateWebToken($userInfo['user_id']);

//Set cookie
setcookie('user_token', $token, time() + 2592000, '/');

//Return to home page
header('Location: /public');



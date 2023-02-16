<?php

//Boot application
require_once __DIR__ . '/../../boot/boot.php';

use Movie\User;

//Return to home page unless it's get method or if the user already logged in
if(strtolower($_SERVER['REQUEST_METHOD']) != 'post' || !empty(User::getCurrentUserId())){
    header('Location: /public');

    return;
}

$user = new User();

//User authentication
$userExists = $user->verify($_REQUEST['email'],$_REQUEST['password']);

if($userExists){

$userInfo = $user->getByEmail($_REQUEST['email']);

//Generate Token
$token = $user->generateWebToken($userInfo['user_id']);

//Set cookie
setcookie('user_token', $token, time() + 2592000, '/');


//Return to home page
header('Location: ../index.php');

}else{
    header('Location: ../login.php');
}
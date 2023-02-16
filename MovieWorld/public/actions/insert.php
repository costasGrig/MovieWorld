<?php

//Boot application
require_once __DIR__ . '/../../boot/boot.php';

use Movie\User;

use Movie\Post;

//Return to home page unless it's get method or if the user already logged in
if(strtolower($_SERVER['REQUEST_METHOD']) != 'post' || empty(User::getCurrentUserId())){
    header('Location: /public');

    return;
}

$post = new Post();

$insertNewPost = $post->insertNewPost($_REQUEST['title'], $_REQUEST['post'], User::getCurrentUserId());

//Return to home page
header('Location: /public');


<?php

//Boot application
require_once __DIR__ . '/../../boot/boot.php';

use Movie\User;

use Movie\Preference;

use Movie\Opinion;

//Return to home page unless it's get method or if the user already logged in
if(strtolower($_SERVER['REQUEST_METHOD']) != 'post' || empty(User::getCurrentUserId())){
    header('Location: /public');

    return;
}

$preference = new Preference();

$opinion = new Opinion();

$isPreference = $preference->isPreference($_REQUEST['user_id'], $_REQUEST['movie_id']);

if(!$isPreference){

    $insertNewPreference = $preference->addPreference($_REQUEST['user_id'], $_REQUEST['movie_id'], $_REQUEST['user_like'], $_REQUEST['user_hate']);
    
    $insertNewOpinion = $opinion->addOpinion($_REQUEST['movie_id'], $_REQUEST['user_like'], $_REQUEST['user_hate']);

}else{
    if($isPreference['user_like'] == 1 && $_REQUEST['user_like'] == 0){

        $changeOpinion = $opinion->changeOpinionHate($_REQUEST['movie_id']);

    }

    if($isPreference['user_like'] == 0 && $_REQUEST['user_like'] == 1){

        $changeOpinion = $opinion->changeOpinionLike($_REQUEST['movie_id']);

    }

    $updatePreference = $preference->updatePreference($isPreference['rate_id'], $_REQUEST['user_like'], $_REQUEST['user_hate']);

}

//Return to home page
header('Location: /public');


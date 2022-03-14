<?php
if(isset($_POST['register'])){
    $error = null;

    if(empty($_POST['username'])){
        $error = 'Please enter a username';
    }

    if(preg_match("/^[a-zA-Z0-9]+$/", $_POST['username']) == 0){
        $error = 'The username contains unauthorized characters';
    }

    if(empty($_POST['email'])){
        $error = 'Please enter a email';
    }

    if(empty($_POST['password'])){
        $error = 'Please enter a password';
    }

    if(empty($_POST['password_repeat'])){
        $error = 'Please repeat your password to';
    }

    if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) == false){
        $error = 'Please enter a valid email';
    }

    if($_POST['password'] != $_POST['password_repeat']){
        $error = 'The passwords do not match';
    }

    if($user->exists($_POST['email'])){
        $error = 'A user with this email already exists';
    }

    if($user->exists($_POST['username'])){
        $error = 'A user with this user name already exists';
    }

    if($system->getSetting('register') == 0){
        $error = 'The account creation is currently disabled';
    }

    if(empty($error)){
        $user_id = $user->create($system->xssFix($_POST['username']), $system->xssFix($_POST['email']), $_POST['password'],'pending','user');
        header($system->url().'login');
    } else {
        echo $error;
    }
}
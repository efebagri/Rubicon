<?php
if(isset($_POST['login'])){
    $error = null;

    if(empty($_POST['email'])){
        $error = 'Please enter a email';
    }

    if(empty($_POST['password'])){
        $error = 'Please enter a password';
    }

    if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) == false){
        $error = 'Please enter a valid email';
    }

    if(!$user->verifyLogin($_POST['email'], $_POST['password'])){
        $error = 'The specified password is not correct';

        //set cookie for 30 min after miss login
        setcookie('7apwy35m2budptd7', 'y', time()+'1800','/');
    }

    if($system->getSetting('login') == 0){
        if($user->getDataByEmail($_POST['email'],'role') == 'admin'){
        } else {
            $error = 'The login is currently disabled';
        }
    }

    if($user->getState($_POST['email']) == 'banned'){
        $error = 'Your account is locked.';
    }

    if(empty($error)){

        $SQL = $system->db()->prepare("UPDATE `users` SET `user_addr` = :user_addr WHERE `email` = :email");
        $SQL->execute(array(":user_addr" => $user->getIP(), ":email" => $_POST['email']));

        $userid = $user->getDataByEmail($_POST['email'], 'id');

        $user->logLogin($userid, $user->getIP(), $user->getAgent());

        $sessionId = $user->generateSessionToken($_POST['email']);
        if(isset($_POST['stayLogged'])){
            setcookie('session_token', $sessionId,time()+'864000','/');
        } else {
            setcookie('session_token', $sessionId,time()+'86400','/');
        }
        header('Location: '.$system->url().'dashboard');

    } else {
        echo $error;
    }
}
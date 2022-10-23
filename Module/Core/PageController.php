<?php

if($user->sessionExists($_COOKIE['session_token'])){

    $username = $user->getDataBySession($_COOKIE['session_token'],'username');
    $mail = $user->getDataBySession($_COOKIE['session_token'],'email');
    $userid = $user->getDataBySession($_COOKIE['session_token'],'id');
    $user_addr = $user->getDataBySession($_COOKIE['session_token'],'user_addr');

    if(is_null($user_addr)){
        $SQL = $system->db()->prepare("UPDATE `users` SET `user_addr` = :user_addr WHERE `id` = :id");
        $SQL->execute(array(":user_addr" => $user->getIP(), ":id" => $userid));
        $user_addr = $user->getIP();
    }
    if($user->getIP() != $user_addr){
        if(isset($_COOKIE['old_session_token'])){
            if($user->isInTeam($_COOKIE['old_session_token'])){

            } else {
                setcookie('session_token', null, time(), '/'); header('Location: '.$system->url().'login');
                die();
            }
        } else {
            setcookie('session_token', null, time(), '/'); header('Location: '.$system->url().'login');
            die();
        }
    }
}

if(strpos($currPage,'_auth') !== false) {
    if($user->sessionExists($_COOKIE['session_token'])){
        die(header('Location: '.env('URL').'dashboard'));
    }
}

if (strpos($currPage,'back_') !== false || strpos($currPage,'team_') !== false) {

    if($currPage != 'back_backtologin_hidehead'){
        if(!($user->loggedIn($_COOKIE['session_token']))){
            die(header('Location: '.env('URL').'login'));
        }
    }

    if(strpos($currPage,'team_') !== false) {
        if(!$user->isInTeam($_COOKIE['session_token'])){
            die(header('Location: '.env('URL').'dashboard'));
        }
    }

    if(strpos($currPage,'_admin') !== false) {
        if(!$user->isAdmin($_COOKIE['session_token'])){
            die(header('Location: '.env('URL').'dashboard'));
        }
    }

}

$currPageName = explode('_',$currPage)[1];
if (strpos($currPage,'system_') !== false) {} else {
    include BASE_PATH.'components/include/head.php';
    if ($user->sessionExists($_COOKIE['session_token'])) {

        if (strpos($currPage,'_hidelayout') !== false) {} else {
            if (strpos($currPage,'_hidehead') !== false) {} else {

                include BASE_PATH . 'components/include/nav.php';
                include BASE_PATH . 'components/include/header.php';

            }
        }
    } else {
        if (strpos($currPage,'_auth') !== false) {} else {
            include BASE_PATH . 'components/include/FRONT/nav.php';
        }
    }
}

include BASE_PATH.'Module/Notifications/sendAlert.php';

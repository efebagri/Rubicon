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
        $error = 'Please send an email to';
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
        $verify_code = $system->generateRandomString(12);
        include BASE_PATH.'app/notifications/mail_templates/auth/confirm_account.php';
        $mail_state = sendMail($_POST['email'], $_POST['username'], $mailContent, $mailSubject, $emailAltBody);

        if($mail_state != true){
            $error = 'The e-mail could not be sent';
            dd($mail_state);
        }
    }

    if(empty($error)){
        $user_id = $user->create($system->xssFix($_POST['username']), $system->xssFix($_POST['email']), $_POST['password'],'pending','customer');
        $user->renewSupportPin($user_id);
        $SQL = $system->db()->prepare("UPDATE `users` SET `verify_code` = :verify_code WHERE `id` = :user_id");
        $SQL->execute(array(":verify_code" => $verify_code, ":user_id" => $user_id));
        header($system->url().'login');
        echo sendSuccess('Please confirm your mail now!');
    } else {
        echo sendError($error);
    }
}
<?php
$currPage = 'front_Login_auth';
include BASE_PATH.'Module/Core/PageController.php';
include BASE_PATH.'Module/Auth/login.php';
?>

<form method="post">
    E-Mail:<br>
    <input value="<?= $_POST['email']; ?>" type="email" size="40" maxlength="250" name="email"><br><br>

    Your password:<br>
    <input type="password" size="40"  maxlength="250" name="password"><br><br>

    <input type="submit" value="Login">
</form>
<a href="<?= $system->url() ?>register">Register</a>
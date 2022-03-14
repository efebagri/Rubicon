<?php
$currPage = 'front_Register_auth';
include BASE_PATH.'Module/Core/PageController.php';
include BASE_PATH.'Module/Auth/register.php';
?>

<form method="post">
    E-Mail:<br>
    <input value="<?= $_POST['email']; ?>" type="email" size="40" maxlength="250" name="email" autocomplete="off"><br><br>

    Your password:<br>
    <input type="password" size="40"  maxlength="250" name="password" autocomplete="off"><br><br>

    Repeat password:<br/>
    <input type="password" size="40" maxlength="250" name="password_repeat" autocomplete="off"><br/><br/>

    <input type="submit" value="Register">
</form>
<a href="<?= $system->url() ?>login">Login</a>
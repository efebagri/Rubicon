<?php
$currPage = 'front_Register_auth';
include BASE_PATH . 'Module/Core/PageController.php';
include BASE_PATH.'Module/Auth/register.php';
?>

<div id="auth">
    <form method="post">
        <input type="email" name="email" placeholder="Mail" value="<?= $_POST['email']; ?>" autocomplete="off">
        <input type="text" name="username" placeholder="Username" value="<?= $_POST['username']; ?>" autocomplete="off">
        <input type="password" name="password" placeholder="Password" value="" autocomplete="off">
        <input type="password" name="password_repeat" placeholder="Confirm Password" value="" autocomplete="off">

        <button type="submit" name="register">Register</button>
    </form>
</div>
</body>
</html>
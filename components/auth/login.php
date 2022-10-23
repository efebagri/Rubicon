<?php
$currPage = 'front_Register_auth';
include BASE_PATH . 'Module/Core/PageController.php';
include BASE_PATH.'Module/Auth/login.php';
?>

<div id="auth">
    <form method="post">
            <input type="email" name="email" placeholder="Mail" value="<?= $_POST['email']; ?>" autocomplete="off">
            <input type="password" name="password" placeholder="Password" value="" autocomplete="off">

            <input type="checkbox" name="stayLogged" id="stayLogged">
            <label>
                Keep me logged in
            </label>

        <button type="submit" name="login">Log in</button>
    </form>
</div>
</body>
</html>
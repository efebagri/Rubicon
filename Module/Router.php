<?php
$resources = BASE_PATH.'components/';
$sites = $resources.'sites/';
$auth = $resources.'auth/';
$legal = $resources.'legal/';
$admin = $resources.'admin/';
$page = $system->protect($_GET['page']);

if(isset($_GET['page'])) {
    switch ($page) {

        // errors
        default: include($legal . "404.php"); break;

        // auth
        case "auth_login": include($auth . "login.php"); break;
        case "auth_register": include($auth . "register.php"); break;
        case "auth_logout": setcookie('session_token', null, time(),'/'); header('Location: '.$system->url().'login'); break;

        // index
        case "dashboard": include($sites . "dashboard.php"); break;

        // legal
        case "imprint": include($legal . "imprint.php"); break;
        case "privacy": include($legal . "privacy.php"); break;
        case "terms": include($legal . "terms.php"); break;

        // admin

    }

    if(strpos($currPage,'system_') !== false || strpos($currPage,'_hidelayout') !== false || strpos($currPage,'_auth') !== false) {} else {
        include BASE_PATH . '/components/include/footer.php';
    }

} else {
    die('please enable .htaccess on your server');
}
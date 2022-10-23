<?php
$resources = BASE_PATH.'components/';
$homepage = $resources.'homepage/';
$auth = $resources.'auth/';
$panel = $resources.'panel/';
$legal = $resources.'legal/';
$page = $system->protect($_GET['page']);

if(isset($_GET['page'])) {
    switch ($page) {

        // errors
        default: include($legal . "404.php"); break;

        // homepage
        case "homepage": include($homepage . "homepage.php"); break;

        // auth
        case "login": include($auth . "login.php"); break;
        case "register": include($auth . "register.php"); break;

        // index
        case "dashboard": include($panel . "dashboard.php"); break;

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

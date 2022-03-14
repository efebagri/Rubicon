<?php

ob_start();
session_start();

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

include_once BASE_PATH . 'Module/Core/Utilities.php';

if(env('DEBUG','false') == 'true'){
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}

$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS']);
<?php

#/**
# * @author TheLinuxRaze
# * Date: 10/4/2022
# * Time: 7:51 PM
# * @copyright Copyright (c) BindYourServer All rights reserved.
# **/

error_reporting(E_ALL ^ E_WARNING && E_NOTICE);

/* ================ AUTOLOADER / KERNEL ================ */
include_once '../system.php';
include_once BASE_PATH.'vendor/autoload.php';
include_once BASE_PATH . 'Module/Kernel/autoload.php';

/* ================ CORE ================ */
include_once BASE_PATH . 'Module/Core/Core.php';

define('SYSTEM_END', round(microtime(true) - SYSTEM_START,4));
/* ================ ROUTER DATA ================ */
include_once BASE_PATH . 'Module/Router.php';
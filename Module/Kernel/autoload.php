<?php

include_once BASE_PATH . 'Module/Core/Controller.php';

foreach (glob('../Module/Kernel/*.php') as $filename)
{
    if($filename != 'autoload.php'){
        include_once $filename;
    }
}
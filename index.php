<?php
require_once 'config.php';
require_once 'classes/autoload.php';
require_once 'vendor/autoload.php';
require_once 'classes/start.php';



init::load();



if(!file_exists(APP::GET('SITEDIR').APP::GET('SCRIPT').'.php')) {
    require 'sites/error/404.php';
    exit();
}

if(APP::GET('ALLOW')==='allow') {
    echo init::$html;
} else {
    require APP::GET('SITEDIR').'login.php';
}


?>

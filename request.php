<?php
require_once 'config.php';
require_once 'classes/start.php';
require_once 'classes/autoload.php';
require_once 'vendor/autoload.php';

if(empty($meta['post'])) {
    app::$errmsg="You need to pass parameters";
    app::quit();
    exit();
}

if(file_exists('controllers/'.$a.'.php')) { 
    require_once('controllers/'.$a.'.php');
} else {
    app::$errmsg='Controller not found'; 
    app::quit();
    exit();
}

if(method_exists($a,$p)) { 
    $a::$p();
} else {
    app::$errmsg='Process Not Found'; 
}

app::quit();
?>
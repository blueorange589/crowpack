<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set('Europe/London');
    session_start();

    APP::SET('GET',$_GET);
    APP::SET('POST',$_POST);
    APP::SET('FILES',$_FILES);
    APP::SET('SCRIPT','index');

    $defaultconf = get_class_vars ( 'CONFIG' );
    foreach($defaultconf as $prop=>$val) {
        APP::SET($prop,$val);
    }

    APP::SET('ENVIRONMENT',($_SERVER['SERVER_NAME'] == 'localhost'?'dev':'production'));
    if(APP::GET('ENVIRONMENT')=='dev') {

        APP::SET('ROOTFOLDER','/var/www/html/');
        APP::SET('APPFOLDER','crowpack/');
        APP::SET('BASEURL',"http://localhost:4002/".CONFIG::$APPFOLDER);

    } else {
        APP::SET('BASEURL',CONFIG::$APPURL.CONFIG::$APPFOLDER);
    }

    APP::SET('PROJECTFOLDER',CONFIG::$ROOTFOLDER.CONFIG::$APPFOLDER);
    APP::SET('CDN',APP::GET('BASEURL')."assets/");
    APP::SET('CDNPATH',APP::GET('PROJECTFOLDER')."assets/");

    if(isset(APP::GET('GET')['route'])&&APP::GET('GET')['route']) {
        APP::SET('ROUTE',APP::GET('GET')['route']);
        $dirs = explode('/',APP::GET('ROUTE'));
        $dirs = array_filter($dirs);
        APP::SET('SITE',$dirs[0]);
        if(isset($dirs[1])) {
            APP::SET('SCRIPT',$dirs[1]);
        }
    }

    // set site directory
    APP::SET('SITEDIR','sites/'.APP::GET('SITE').'/');
    APP::SET('VIEWDIR',APP::GET('SITEDIR').'views/');

    // include site vars
    if(file_exists(APP::GET('SITEDIR').'sitevars.php')) {
        require APP::GET('SITEDIR').'sitevars.php';
        APP::SET('SITEVARS',$SITEVARS);
    }

    // include template engine
    if(file_exists(APP::GET('SITEDIR').'template.php')) {
        require APP::GET('SITEDIR').'template.php';
        APP::SET('TPLENGINE',new sitetemplate());
    }

    // manage session and set action allow/block
    APP::SET('ALLOW',session::manage());
?>

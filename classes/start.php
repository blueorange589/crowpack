<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Europe/London');
session_start();

// APPLICATION CONFIGURATION
$APPNAME = "ISAPP";
$ACCESSCODE = "123456";
$SITEURL = "http://localhost/isapp/"; // starts with http:// ends with /
$CLIENTID = "b8bhby3vxtty8qxzpqbytux4";
$CLIENTSECRET = "xcffTPd2QQ";
$CALLBACKURL = $SITEURL."index.php"; // no need to change this line

$meta = array();

$meta['get'] = $_GET;
$meta['post'] = $_POST;
$meta['files'] = $_FILES;
$meta['sess'] = $_SESSION;

$meta['env'] = $_SERVER['SERVER_NAME'] == 'localhost'?'dev':'production';

if($meta['env']=='dev') {
    $meta['base']="http://localhost/isapp/";
    $meta['cdn']= $meta['base']."assets/";
} else {
    $meta['base']= $SITEURL;
    $meta['cdn']= $meta['base']."assets/";
}

$page = isset($meta['get']['p'])?$meta['get']['p']:'index';


?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Europe/London');
session_start();

$meta           = array();
$meta['get']    = $_GET;
$meta['post']   = $_POST;
$meta['files']  = $_FILES;
$meta['page']   = isset($meta['get']['p'])?$meta['get']['p']:'index';


CONFIG::$ENVIRONMENT = $_SERVER['SERVER_NAME'] == 'localhost'?'dev':'production';
if(CONFIG::$ENVIRONMENT=='dev') {

    CONFIG::$ROOTFOLDER = '/var/www/html/';
    CONFIG::$APPFOLDER  = 'crowpack-php/';
    CONFIG::$BASEURL    = "http://localhost/".CONFIG::$APPFOLDER;

} else {

    CONFIG::$BASEURL    = CONFIG::$SITEURL.CONFIG::$APPFOLDER;

}

CONFIG::$PROJECTFOLDER  = CONFIG::$ROOTFOLDER.CONFIG::$APPFOLDER;
CONFIG::$CDN            = CONFIG::$BASEURL."vendor/bower/crowpack/assets/";
CONFIG::$CDNPATH        = CONFIG::$PROJECTFOLDER."vendor/bower/crowpack/assets/";


?>

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
$meta['env']    = $_SERVER['SERVER_NAME'] == 'localhost'?'dev':'production';
$meta['page']   = isset($meta['get']['p'])?$meta['get']['p']:'index';



if($meta['env']=='dev') {
    $meta['base']="http://localhost/";
    if(CONFIG::$LOCALFOLDER) { $meta['base'] .= CONFIG::$LOCALFOLDER."/"; }
    $meta['cdn']= $meta['base']."assets/";
} else {
    $meta['base']= $SITEURL;
    $meta['cdn']= $meta['base']."assets/";
}

?>
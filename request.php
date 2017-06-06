<?php
require_once 'config.php';
require_once 'classes/start.php';
require_once 'classes/autoload.php';
require_once 'vendor/autoload.php';

if(empty(APP::GET('POST'))) {
    APP::SET('ERRMSG','');="You need to pass parameters";
    APP::QUIT();
    exit();
}

/*
      self::$a = isset($m['post']['a'])?$m['post']['a']:'';
	  self::$p = isset($m['post']['p'])?$m['post']['p']:'';
      self::$i = isset($m['post']['i'])?$m['post']['i']:'';
      unset($m['post']['a'],$m['post']['p'],$m['post']['i']);
      self::$params = $m['post'];

      if(self::$sccmsg&&!self::$result) {
          self::$result = "OK";
        }

      if(self::$dberror) {
          $rarr['dberror'] = self::$dberror;
        }
*/

if(file_exists('controllers/'.$a.'.php')) { 
    require_once('controllers/'.$a.'.php');
} else {
    APP::SET('ERRMSG','');='Controller not found';
    APP::QUIT();
    exit();
}

if(method_exists($a,$p)) { 
    $a::$p();
} else {
    APP::SET('ERRMSG','');='Process Not Found';
}


APP::QUIT();
?>

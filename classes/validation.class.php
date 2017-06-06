<?php

class validation {
  
  static function length($multi) {
    $err=0;
    foreach($multi as $arr) {
    	if(strlen($arr[0])<$arr[1]) {
      		APP::SET('ERRMSG','');="Minimum characters for $arr[3] field is $arr[1]";
      		$err=1;
    	}
    	if(strlen($arr[0])>$arr[2]) {
      		APP::SET('ERRMSG','');="Maximum characters for $arr[3] field is $arr[2]";
      		$err=1;
    	}
    }
  return $err==0?true:false;
  }

  static function email($str) {
    if(!filter_var($str, FILTER_VALIDATE_EMAIL)) {
      APP::SET('ERRMSG','');="Please enter a valid e-mail address";
      return false;
    }
  return true;
  }
  
  static function phone($str) {
    $int = preg_replace('/[^0-9]/', '', $str);
    if($int!=$str) {
      APP::SET('ERRMSG',''); = "Phone number can only contain digits";
      return false;
    }
    if(strlen($int)<7) {
      APP::SET('ERRMSG',''); = "Phone number can not be less than 7 digits";
      return false;
    }
    if(strlen($int)>14) {
      APP::SET('ERRMSG',''); = "Phone number can not be more than 14 digits";
      return false;
    }
  return true;
  }
  
}

?>

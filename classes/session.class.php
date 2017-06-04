<?php
class session {
  
  static function login($phn,$code) {
	  if(!$phn) {
		  app::$errmsg="Phone number can not be empty";
		  return false;
	  }
	  if(!$code) {
		  app::$errmsg="Access code can not be empty";
		  return false;
	  }
      //var_dump($eml);
    $user = db::selectrow('*','users', array('phone'=>$phn));
      
    if(!$user) {
      app::$errmsg = "Phone number not found";
      return false;
    }
    if($code!=$user['authcode']) {
      app::$errmsg = 'Access code is invalid.';
      return false;
    }
	$_SESSION['udata'] = $user;
  return self::setsession($user['id']);
  }
    
  static function setsession($uid) {
    $sarr = array (
      'sid'		=> helper::hash(16),
      'user' 	=> $uid,
      'logintime' => time()
    );
      
    $act = db::insert('sessions', $sarr);
    //var_dump($act);
    
    if($act) {
      $_SESSION['waonline'] = $sarr['sid'];
      app::$sccmsg = "Login successful";
      db::update('users', array("timelogin"=>time()), array("id" => $uid));
      return true;
    }
    app::$errmsg = "Session information could not be saved";
  return false;
  }
  
  static function check() {
    if(!isset(app::$meta['sess']['waonline'])) {
      return false;
    }
    $sid = app::$meta['sess']['waonline'];
    return db::selectrow('*', 'sessions', array('sid'=>$sid));
  }
  
  static function setuser($uid) {
    $user = db::selectrow('*', 'users', array('id'=>$uid));
    if($user) {
      app::$mydata = $user;
      app::$myid = $user['id'];
    return $user;
    }
  return false;
  }
  
  
  
  
  
  
  
  // ---- ADMIN ----//
  static function admlogin($eml,$pwd) {
    $user = db::selectrow('*','admin', array('username'=>$eml));
    if(!$user) {
      app::$errmsg = "User not found";
      return false;
    }
    if(md5($pwd)!=$user['pwd']) {
      app::$errmsg = "Password does not match";
      return false;
    }
  return self::admsetsession($user['id']);
  }
    
  static function admsetsession($uid) {
    $sarr = array (
      'sid'		=> helper::hash(16),
      'user' 	=> $uid,
      'logintime' => time()
    );
    
    if(db::insert('sessionsadmin', $sarr)) {
      $_SESSION['wadm'] = $sarr['sid'];
      app::$sccmsg = "Login successful";
      db::update('admin', array("lastlogin"=>time()), array("id" => $uid));
      return true;
    }
    app::$errmsg = "Session information could not be saved";
  return false;
  }
  
  
  
  static function admcheck() {
    if(!isset(app::$meta['sess']['wadm'])) {
      return false;
    }
    $sid = app::$meta['sess']['wadm'];
    return db::selectrow('*', 'sessionsadmin', array('sid'=>$sid));
  }
  
  
}
?>
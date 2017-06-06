<?php
class session {
    
    public static function manage() {
        // public site
        if(APP::GET('SITEVARS')['requireauth']==false) { return 'allow'; }

        // is loggedin on requested site?
        if(self::checksession()) { return 'allow'; }

        // if post login authfields, check authdb.authcols
        if(self::authonsite()) { return 'allow'; }

    return 'block';
    }

    private static function checksession() {
        $authsave = APP::GET('SITEVARS')['authsave'];
        $authsavekey = APP::GET('SITEVARS')['authsavekey'];
        if($authsave=='COOKIE') {
            if(isset($_COOKIE[$authsavekey])) {
                $set = self::setuserdata($_COOKIE[$authsavekey]);
                if($set) {
                    APP::SET('LOGGEDIN',true);
                    return true;
                }
            }
        }
        if($authsave=='SESSION') {
            if(isset($_SESSION[$authsavekey])) {
                $set = self::setuserdata($_SESSION[$authsavekey]);
                if($set) {
                    APP::SET('LOGGEDIN',true);
                    return true;
                }
            }
        }
    return false;
    }

    private static function authonsite() {

        $authsavekey = APP::GET('SITEVARS')['authsavekey'];
        $authfields = array_keys(APP::GET('SITEVARS')['authfields']);
        $allok = 1;

        foreach($authfields as $k=>$f) {
            if(!isset(APP::GET('POST')[$f])) { $allok=0; }
        }
        if(!$allok) { return false; }

        if(APP::GET('SITEVARS')['authtype']=='basic') {
            if(!self::authbasic()) { return false; }
        } else {
            // select user by username

            // compare pwd

            // insert to authdb uid,token,time
        }



        // if successful save to authsave
        $key = helper::hash(8);
        if(APP::GET('SITEVARS')['authsave']=='COOKIE') {
            setcookie($authsavekey, $key, time()+30*24*3600);
        }
        if(APP::GET('SITEVARS')['authsave']=='SESSION') {
            $_SESSION[$authsavekey] = $key;
        }
        header('Location:'.APP::GET('SITEURL').APP::GET('SITE'));
    }
    
    private static function logoutsite() {

    }
    
    private static function setuserdata($ssid) {
        /*
        $sessdata = DB::SELECTROW('*',APP::GET('SITEVARS')['sessiontable'],array(APP::GET('SITEVARS')['tokencolumn'] => $ssid));
        if(!$sessdata) { return false; }
        $columns = DB::SELECTROWSPLAIN('SHOW COLUMNS FROM '.APP::GET('SITEVARS')['authtable'].';');
        if(($key = array_search(APP::GET('SITEVARS')['authcols']['pwd'], $columns)) !== false) {
            unset($columns[$key]);
        }
        $dbcols = helper::rowstosingle($columns);
        $user = DB::SELECTROW($dbcols,APP::GET('SITEVARS')['authtable'],array('id'=>$sessdata['uid']));
        if(!$user) { return false; }
        APP::SET('ME',$user);
        APP::SET('MYID',$user['id']);
        */
        APP::SET('ME',array('username'=>'blueorange589','firstname'=>'Ozgur','lastname'=>'Arslan'));
        APP::SET('MYID',7214);
    return true;
    }

    private static function authbasic() {
        if(APP::GET('POST')['username']!=CONFIG::$USERNAME) {
            APP::SET('ERRMSG','Invalid Username');
            return false;
        }
        if(APP::GET('POST')['password']!=CONFIG::$PASSWORD) {
            APP::SET('ERRMSG','Invalid Password');
            return false;
        }
    return true;
    }
  
}
?>

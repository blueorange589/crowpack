<?php
class app {


    static $a               = "";
    static $p               = "";
    static $i               = "";
  	static $meta			= array();
    static $params          = array();

    static $result          = "";
    static $error           = false;
    static $errmsg          = "";
    static $sccmsg          = "";
    static $info            = "";
    static $dberror         = "";
    static $numrows         = 0;
  	static $insertid		= 0;

  	static $mydata			= array();
    static $myid            = 0;

    function __construct($m) {

      self::$meta = $m;
      self::$a = isset($m['post']['a'])?$m['post']['a']:'';
	  self::$p = isset($m['post']['p'])?$m['post']['p']:'';
      self::$i = isset($m['post']['i'])?$m['post']['i']:'';
      unset($m['post']['a'],$m['post']['p'],$m['post']['i']);
      self::$params = $m['post'];
      //print_r(self::$meta);

    }


    static function quit() {

        self::$error = self::$errmsg?true:false;
        $rarr = array(
            "result"    =>self::$result,
            'error'     =>self::$error,
            'errmsg'    =>self::$errmsg,
            'sccmsg'    =>self::$sccmsg,
            'info'      =>self::$info,
            'numrows'   =>self::$numrows
        );

      	if(self::$sccmsg&&!self::$result) {
          self::$result = "OK";
        }
        // var_dump( self::$meta['env']);
		// self::$meta['env']=='dev'
      	if(self::$dberror) {
          $rarr['dberror'] = self::$dberror;
        }

        // var_dump($rarr);

        echo json_encode($rarr);
    }


    static function userscombo() {
        if(empty(app::$combousers)) {
            db::$countrows=false;
            $users = db::selectrows('id,nick','users');
            $uarr = array();
            foreach($users as $user) {
                $uarr[$user['id']] = $user['nick'];
            }
            app::$combousers = $uarr;
        return $uarr;
        }
    return app::$combousers;
    }

    static function test() {
      echo self::$errmsg;
    }

}
?>

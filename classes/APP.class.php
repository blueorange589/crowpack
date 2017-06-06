<?php
class APP {
    static $PROPS   = array(
            'ENVIRONMENT'            => '',
            'PROJECTFOLDER'          => '',
            'BASEURL'                => '',
            'CDN'                    => '',
            'CDNPATH'                => '',
            'SITE'                   => 'main',
            'SITEDIR'                => '',
            'SITEVARS'               => array('requireauth'=>false),
            'VIEWDIR'                => '',
            'SCRIPT'                 => 'login',
            'ROUTE'                  => '',
            'TPLENGINE'              => NULL,
            'LOGGEDIN'               => false,
            'ME'                     => array(),
            'MYID'                   => 0,
            'ALLOW'                  => false,

            'RESULT'                 => '',
            'ERRMSG'                 => '',
            'SCCMSG'                 => '',
            'INFO'                   => '',
            'DBERROR'                => '',
            'NUMROWS'                => '',
            'INSERTID'               => 0,
    );

    static function QUIT() {
        $return = array('result'=>APP::GET('RESULT'),'errmsg'=>APP::GET('ERRMSG'),'sccmsg'=>APP::GET('SCCMSG'),'info'=>APP::GET('INFO'));
        if(APP::GET('DBERROR')&&APP::GET('ENVIRONMENT')=='dev') { $return['dberror']=APP::GET('DBERROR'); }
        if(APP::GET('NUMROWS')) { $return['numrows']=APP::GET('NUMROWS'); }
        if(APP::GET('INSERTID')) { $return ['insertid']=APP::GET('INSERTID'); }
        echo json_encode($return);
    }

    static function GET($k) {
        return self::$PROPS[$k];
    }

    static function SET($k,$v) {
        self::$PROPS[$k] = $v;
    }
}
?>

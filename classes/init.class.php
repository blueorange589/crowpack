<?php
class init {
    public static $favicon = '';
    public static $initjson= '';
    public static $html    = '';
    public static $css     = array();
    public static $js      = array();
    public static $menu1   = '';
    public static $views   = array();
    public static $builder = array();
    
    static function load() {
        self::$favicon = APP::GET('CDN').'img/favicon.ico';
        
        // TODO: Register CSS
        self::$css = array(
            APP::GET('BASEURL').'vendor/bower/bootstrap/dist/css/bootstrap.min.css',
            APP::GET('BASEURL').'vendor/bower/ie10-viewport-bug-workaround/dist/ie10-viewport-bug-workaround.css'
        );
        
        // TODO: Register JS
        self::$js = array(
            APP::GET('BASEURL').'vendor/bower/jquery/dist/jquery.min.js',
            APP::GET('BASEURL').'vendor/bower/bootstrap/dist/js/bootstrap.min.js',
            APP::GET('BASEURL').'vendor/bower/ie10-viewport-bug-workaround/dist/ie10-viewport-bug-workaround.js'
        );

        // auto-append app css
        self::appendcss();
        
        // auto-append app js
        self::appendjs();
        
        // auto-register views
        self::appendviews();

        // build initjson
        self::setinitjson();

        // invoke template functions
        self::rendersitelayout();
    }



    // TODO: get all data required for init

    /* ------- PRIVATE AREA ---------- */
    private static function appendcss() {
        $files = helper::listfiles(APP::GET('CDNPATH').'css','css');
        foreach($files as $f) {
            self::$css[] = APP::GET('CDN').'css/'.$f.'.css';
        }
    }

    private static function appendjs() {
        $files = helper::listfiles(APP::GET('CDNPATH').'js','js');
        foreach($files as $f) {
            self::$js[] = APP::GET('CDN').'js/'.$f.'.js';
        }
    }

    private static function appendviews() {
        self::$views = helper::listfiles(APP::GET('PROJECTFOLDER').'sites/'.APP::GET('SITE').'/views','php');
    }

    private static function setinitjson() {
        // make viewids
        $viewids = array();
        foreach(self::$views as $v) { $viewids[]='#'.$v; }


        $json = array(
            'views'     => self::$views,
            'viewids'   => $viewids,
        );
    self::$initjson = json_encode($json);
    }
    
    private static function rendersitelayout() {
        $currentlayout = APP::GET('SITEDIR').APP::GET('SCRIPT').'.php';
        $text = file_get_contents($currentlayout);
        // RENDER PROPS
        preg_match_all('/{=([^}]*)=}/', $text, $matches);
        foreach($matches[1] as $prop) {
            $newcontent = APP::GET($prop);
            $text = str_replace('{='.$prop.'=}',$newcontent,$text);
        }

        // RENDER FUNCTIONS
        preg_match_all('/{-([^}]*)-}/', $text, $matches);
        foreach($matches[1] as $fn) {
            $newcontent = APP::GET('TPLENGINE')->$fn();
            $text = str_replace('{-'.$fn.'-}',$newcontent,$text);
        }
    self::$html = $text;
    }

}
?>

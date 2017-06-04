<?php
class init {
    public static $favicon = '';
    public static $initjson= '';
    public static $css     = array();
    public static $js      = array();
    public static $menu1   = '';
    public static $menu2   = '';
    public static $views   = array();
    public static $builder = array();
    
    static function load() {
        self::$favicon = CONFIG::$CDN.'img/favicon.ico';
        // TODO: build single JSON for init load
        // TODO: get all views, set display:none
        
        // TODO: Register CSS
        self::$css = array(
            CONFIG::$BASEURL.'vendor/bower/bootstrap/dist/css/bootstrap.min.css',
            CONFIG::$BASEURL.'vendor/bower/ie10-viewport-bug-workaround/dist/ie10-viewport-bug-workaround.css'
        );
        
        // TODO: Register JS
        self::$js = array(
            CONFIG::$BASEURL.'vendor/bower/jquery/dist/jquery.min.js',
            CONFIG::$BASEURL.'vendor/bower/bootstrap/dist/js/bootstrap.min.js',
            CONFIG::$BASEURL.'vendor/bower/ie10-viewport-bug-workaround/dist/ie10-viewport-bug-workaround.js'
        );
        
        // build menus
        self::buildmenu1();
        self::buildmenu2();
        
        // auto-append app css
        self::appendcss();
        
        // auto-append app js
        self::appendjs();
        
        // auto-register views
        self::appendviews();

        // build initjson
        self::setinitjson();
    }




    // TODO: Build Primary Menu
    public static function buildmenu1() {
        $wrapper = array( //wrapper
            'link>'     => '<a href="#" onclick="showpage("*");">', //replace * with page
            '<link'     => '</a>',
            'subitem>'  => '<li>',
            '<subitem'  => '</li>',
            'submenu>'  => '<ul class="dropdown-menu">',
            '<submenu'  => '</ul></li>',
            'divider>'  => '<li role="separator" class="divider">',
            '<divider'  => '</li>',
            'header>'   => '<li class="dropdown-header">',
            '<header'   => '</li>',
            'activator>'=> '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">', //activator of submenu
            '<activator'=> '<span class="caret"></span></a>',
            'item>'     => '<li>',
            '<item'     => '</li>',
            'menu>'     => '<div id="navbar" class="navbar-collapse collapse"><ul class="nav navbar-nav navbar-right">',
            '<menu'     => '</ul></div>',
        );

        $menuarr = array(
            'about'     => 'About',
            'contact'   => 'Contact',
            'manual1'   => '<li><a href="#" onclick="showpage("manual");">Manual</a></li>',
            'manual2'   => '<li><a href="#" onclick="showpage("manual");">Manual 2</a></li>',
            'submenu1'  => array(
                'page1'     => 'Page 1',
                'page2'     => 'Page 2',
                'manual3'   => '<li><a href="#" onclick="showpage("manual");">Manual 3</a></li>',
                'divider1'  => '',
                'header1'   => 'Nav header',
                'page3'     => 'Page 3'
            )
        );
        $attr = array(
            'submenu1'=>array('title'=>'Drop me Down')
        );

    self::$menu1 = self::menubuilder($wrapper,$menuarr,$attr);
    }

    // TODO: Build Secondary Menu
    public static function buildmenu2() {
        $wrapper = array( //wrapper
            'link>'     => '<a href="#" onclick="showpage("*");">', //replace * with page
            '<link'     => '</a>',
            'item>'     => '<li><a href="#" onclick="showpage("*");">', //replace * with page
            '<item'     => '</a></li>',
            'menu>'     => '<div id="navbar" class="navbar-collapse collapse"><ul class="nav navbar-nav navbar-right">',
            '<menu'     => '</ul></div>',
        );
        $menuarr = array(
            'blog'      => 'Blog'
        );
    self::$menu2 = self::menubuilder($wrapper,$menuarr);
    }


    // TODO: get all data required for init

    /* ------- PRIVATE AREA ---------- */
    private static function appendviews() {
        self::$views = helper::listfiles(CONFIG::$PROJECTFOLDER.'views','php');
    }

    private static function appendcss() {
        $files = helper::listfiles(CONFIG::$CDNPATH.'css','css');
        foreach($files as $f) {
            self::$css[] = CONFIG::$CDN.'css/'.$f.'.css';
        }
    }

    private static function appendjs() {
        $files = helper::listfiles(CONFIG::$CDNPATH.'js','js');
        foreach($files as $f) {
            self::$js[] = CONFIG::$CDN.'js/'.$f.'.js';
        }
    }

    private static function setinitjson() {
        $json = array(
            'views' => self::$views,
        );
    self::$initjson = json_encode($json);
    }

    private static function menubuilder($w,$m,$attr=array()) {
        $out = $w['menu>'];
        foreach($m as $mk=>$mv) {
            $y1 = 0;
            if(substr($mk,0,6)=='manual') { $out.=$mv; $y1=1; }
            if(substr($mk,0,6)=='header') { $out.=$w['header>'].$w['<header']; $y1=1; }
            if(substr($mk,0,7)=='divider') { $out.=$w['divider>'].$w['<divider']; $y1=1; }
            if(substr($mk,0,7)=='submenu') {
                $out.=$w['activator>'].$attr[$mk]['title'].$w['<activator'].$w['submenu>'];
                foreach($mv as $sk=>$sv) {
                    $y2 = 0;
                    if(substr($sk,0,6)=='manual') { $out.=$sv; $y2=1; }
                    if(substr($sk,0,6)=='header') { $out.=$w['header>'].$w['<header']; $y2=1; }
                    if(substr($sk,0,7)=='divider') { $out.=$w['divider>'].$w['<divider']; $y2=1; }
                    if($y2==0) {
                        $w['link>'] = str_replace('*',$sk,$w['link>']);
                        $out.=$w['subitem>'].$w['link>'].$sv.$w['<link'].$w['<subitem'];
                    }
                }
                $out.=$w['<submenu'];
                $y1=1;
            }
            if($y1==0) {
                $w['link>'] = str_replace('*',$mk,$w['link>']);
                $out.=$w['item>'].$w['link>'].$mv.$w['<link'].$w['<item'];
            }
        }
        $out.= $w['<menu'];
        $out = str_replace('("',"('",$out);
        $out = str_replace('")',"')",$out);
    return $out;
    }

    
}
?>

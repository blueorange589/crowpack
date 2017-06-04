<?php
class init {
    public static $favicon = '';
    public static $css     = array();
    public static $js      = array();
    public static $builder = array();
    
    static function load() {
        self::$favicon = app::$meta['cdn'].'img/favicon.ico';
        // TODO: build single JSON for init load
        // TODO: get all views, set display:none
        
        // TODO: Register CSS
        self::$css = array(
            app::$meta['base'].'vendor/bower/bootstrap/dist/css/bootstrap.min.css',
            app::$meta['base'].'vendor/bower/ie10-viewport-bug-workaround/dist/ie10-viewport-bug-workaround.css',
            app::$meta['base'].'vendor/bower/crowpack/assets/css/app.css'
        );
        
        // TODO: Register JS
        self::$js = array(
            app::$meta['base'].'vendor/bower/jquery/dist/jquery.min.js',
            app::$meta['base'].'vendor/bower/bootstrap/dist/js/bootstrap.min.js',
            app::$meta['base'].'vendor/bower/ie10-viewport-bug-workaround/dist/ie10-viewport-bug-workaround.js',
            app::$meta['base'].'vendor/bower/crowpack/assets/js/app.js'
        );
        
        // TODO: Build Primary Menu
        
        // TODO: Build Secondary Menu
        
        // TODO: get all data required for init
        
    }
    
}
?>
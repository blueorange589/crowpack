<?php
class sitetemplate extends template {



    function loadmenu() {
        $wrapper = array( //wrapper
            'sublink>'  => '<a href="#" class="navbar-link" data-page="*">',
            '<sublink'  => '</a>',
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
            'mylink>'   => '<a href="#" class="navbar-link" data-page="*" data-parent="%">', //replace * and %
            '<mylink'  => '</a>',
            'item>'     => '<li id="*">',  //replace *
            '<item'     => '</li>',
            'menu>'     => '<div id="navbar" class="navbar-collapse collapse"><ul class="nav navbar-nav navbar-right">',
            '<menu'     => '</ul></div>',
        );

        $menuarr = array(
            'about'     => 'About',
            'contact'   => 'Contact',
            'manual1'   => '<li id="nav-manual1"><a href="#" class="navbar-link" data-page="#manual1" data-parent="#nav-manual1">Manual 1</a></li>',
            'manual2'   => '<li id="nav-manual2"><a href="#" class="navbar-link" data-page="#manual2" data-parent="#nav-manual2">Manual 2</a></li>',
            'submenu1'  => array(
                'page1'     => 'Page 1',
                'page2'     => 'Page 2',
                'manual3'   => '<li><a href="#" class="navbar-link" data-page="#manual3">Manual 3</a></li>',
                'divider1'  => '',
                'header1'   => 'Nav header',
                'page3'     => 'Page 3'
            )
        );
        $attr = array(
            'submenu1'=>array('title'=>'Drop me Down')
        );

    return $this->menubuilder($wrapper,$menuarr,$attr);
    }

    function menubuilder($w,$m,$attr=array()) {
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
                    if(substr($sk,0,6)=='header') { $out.=$w['header>'].$sv.$w['<header']; $y2=1; }
                    if(substr($sk,0,7)=='divider') { $out.=$w['divider>'].$w['<divider']; $y2=1; }
                    if($y2==0) {
                        $linkstart = str_replace('*','#'.$sk,$w['sublink>']);
                        $out.=$w['subitem>'].$linkstart.$sv.$w['<sublink'].$w['<subitem'];
                    }
                }
                $out.=$w['<submenu'];
                $y1=1;
            }
            if($y1==0) {
                $linkstart = str_replace('*',   '#'.$mk,        $w['mylink>']);
                $linkstart = str_replace('%',   '#nav-'.$mk,    $linkstart);
                $sistart   = str_replace('*',   'nav-'.$mk,     $w['item>']);
                $out.=$sistart.$linkstart.$mv.$w['<mylink'].$w['<item'];
            }
        }
        $out.= $w['<menu'];
    return $out;
    }

}
?>

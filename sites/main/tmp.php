<?php
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

        init::$menu1 = init::menubuilder($wrapper,$menuarr,$attr);


?>

<?php
class template {

    function favicon() {
        return '<link rel="icon" href="'.init::$favicon.'">';
    }

    function title() {
        return '<title>'.APP::GET('APPTITLE').'</title>';
    }

    function loadcss() {
        $out='';
        foreach(init::$css as $cssurl) {
            $out .= '<link href="'.$cssurl.'" rel="stylesheet">
    ';
        }
    return $out;
    }

    function loadjs() {
        $out='';
        foreach(init::$js as $jsurl) {
            $out .= '<script src="'.$jsurl.'"></script>
    ';
        }
    return $out;
    }

    function initjson() {
        return '<script type="text/javascript">var initjson = '.init::$initjson.';</script>';
    }

    function views() {
        $out = '';
        foreach(init::$views as $v) {
            $text = file_get_contents(APP::GET('VIEWDIR').$v.'.php');

            // RENDER PROPS
            preg_match_all('/{=([^}]*)=}/', $text, $matches);
            foreach($matches[1] as $prop) {
                $newcontent = APP::GET($prop);
                $text = str_replace('{='.$prop.'=}',$newcontent,$text);
            }

            // RENDER FUNCTIONS
            preg_match_all("/{-([^}]*)-}/", $text, $matches);
            foreach($matches[1] as $fn) {
                $newcontent = $this->$fn();
                $text = str_replace('{-'.$fn.'-}',$newcontent,$text);
            }
        $out .= $text;
        }
    return $out;
    }

}
?>

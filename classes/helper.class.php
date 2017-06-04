<?php

class helper {
  
  // ---- STRING ---- //
  
  static function hash($digits) {
        return substr(md5(microtime()),0,$digits);
  }
  
  static function SEO($t) {
        return strtr($t, array ('Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
		'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g', ' '=>'-', '.'=>'', '/'=>'-'));
  }
    
    
  // ---- ARRAY ---- //
  static function arraytable($multiarr,$before,$between,$after,$seperator='') {
      $out='';
      foreach($multiarr as $arr) {
          $out .= $seperator;
          foreach($arr as $k=>$v) {
              if(is_array($v)) {
                $v = json_encode($v);
              } else {
                $k = ucwords(str_replace('_',' ',$k));
                $v = ucwords(str_replace('_',' ',$v));
              }
              
              $out .= $before.$k.$between.$v.$after;
          }
      }
  return $out;
  }
  
  
  
  // ----  TIME ---- //
  
  static function averagetime($average) {
        // 1 day = 24 hours * 60 minutes * 60 seconds = 86400 seconds
        $days    = floor( $average / 86400 );
        $hours   = floor( ( $average % 86400 ) / 3600 );
        $minutes = floor( ( $average % 3600 ) / 60 );
        $seconds = $average % 60;
        
        $w = '';
        if($days>0) { $w .= $days . ' days '; }
        $w .= $hours . ' hours';
        //$w .= $minutes . ' minute' . ( $minutes > 0 ? 's' : '' ) . ', ';
        //$w .= $seconds . ' second' . ( $seconds > 0 ? 's' : '' );
    return $w;
    }
    
  
  static function timeago($ptime) {
        $estimate_time = time() - $ptime;
        if( $estimate_time < 1 )    {
            return '1 seconds ago';
        }
        $condition = array( 
                    12 * 30 * 24 * 60 * 60  =>  'years',
                    30 * 24 * 60 * 60       =>  'months',
                    24 * 60 * 60            =>  'days',
                    60 * 60                 =>  'hours',
                    60                      =>  'minutes',
                    1                       =>  'seconds'
        );
        foreach( $condition as $secs => $str ) {
            $d = $estimate_time / $secs;
            if( $d >= 1 )
            {
                $r = round( $d );
                return $r . ' ' . $str . ' ago';
            }
        }
    }
    
    /* ------ FILES -------- */
    public static function listfiles($dir,$ext) {
        $views = scandir($dir);
        unset($views[0], $views[1]);
        $list = array();
        foreach($views as $v) {
            $f = explode('.',$v);
            if($f[1]==$ext) {
                $list[] = $f[0];
            }
        }
    return $list;
    }
    
  
}

?>

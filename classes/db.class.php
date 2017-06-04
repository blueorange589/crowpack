<?php
/*  mysqli Wrapper Class
 *  @author Ozgur Arslan 
 *  github.com/blueorange589
 *  http://stackoverflow.com/users/7838027/Оzgur
 * 
 *  Usage;
 *      Select rows example
 *      db::selectrows('*', 'users', array('name'=>'Tom'), array('id','DESC'), array(0,50));
 *      
 *      Available methods : selectrow, selectrows, insert, update, delete
*/


class db {
    static $link;
    static $countrows   = true;
    
    function __construct() {
      //mysqli_report( MYSQLI_REPORT_STRICT );
      try {
        self::$link = new mysqli(app::$meta['dbhost'], app::$meta['dbuser'], app::$meta['dbpass'], app::$meta['dbdb']);
      } catch (Exception $e) {
        echo $e->message;
        exit;
      }
      //var_dump(self::$link);
      self::$link->set_charset("utf8");
    }
    
    
    static function query( $query ) {
        // echo $query;
      	$full_query = self::$link->query( $query );
        if( self::$link->error )
        {
            app::$dberror = self::$link->error;
            return false; 
        }
        else
        {
            return true;
        }
    }
    
    static function insert($t,$v=array()) {
        
        $sqlbindstring = '';
        $pstr = '';
        $ctext = "(";
        foreach($v as $col=>$val) {
            $type = gettype($val);
            if($type=='integer') { $sqlbindstring.='i'; }
            else if($type=='double') { $sqlbindstring.='d'; }
            else { $sqlbindstring.='s'; }
            $pstr.='?, ';
            $ctext.=$col.',';
        }
        $pstr = rtrim($pstr,', ');
        $ctext = rtrim($ctext,',');
        $ctext.=')';
        
        $recordvalues = array_values($v);
        $bind_arguments = [];
        $bind_arguments[] = $sqlbindstring;
        foreach ($recordvalues as $recordkey => $recordvalue)
        {
            $bind_arguments[] = & $recordvalues[$recordkey];    # bind to array ref, not to the temporary $recordvalue
        }
        
        // PREPARED
        $q = "INSERT INTO ".$t." ".$ctext." VALUES (".$pstr.")";
        //echo $q;
        $stmt = self::$link->prepare($q);
       
        call_user_func_array(array($stmt, 'bind_param'), $bind_arguments);
        $stmt->execute();

        if($stmt->error) {
            app::$dberror = $stmt->error;
            return false; 
        }
        app::$insertid = $stmt->insert_id;
        $stmt->close();
    return true;
    }
      
    static function selectrow($s,$f,$w=array()) {
        
        if(is_array($w)) {
            $sqlbindstring = '';
            $pstr = '';
            foreach($w as $col=>$val) {
                $type = gettype($val);
                if($type=='integer') { $sqlbindstring.='i'; }
                else if($type=='double') { $sqlbindstring.='d'; }
                else { $sqlbindstring.='s'; }
                $pstr.=$col."=? AND ";
            }
            $pstr = rtrim($pstr,' AND ');
        } else {
            
        }
        
        $recordvalues = array_values($w);
        $bind_arguments = [];
        $bind_arguments[] = $sqlbindstring;
        foreach ($recordvalues as $recordkey => $recordvalue)
        {
            $bind_arguments[] = & $recordvalues[$recordkey];    # bind to array ref, not to the temporary $recordvalue
        }
        
        // PREPARED
        $q = 'SELECT '.$s.' FROM '.$f.' WHERE '.$pstr;
        //echo $q;
        $stmt = self::$link->prepare($q);
        if(!$stmt) { echo "Invalid Query"; exit; }
        
        call_user_func_array(array($stmt, 'bind_param'), $bind_arguments);
        $stmt->execute();
        
        if($stmt->error) {
            app::$dberror = $stmt->error;
            return false; 
        } 
        
        $result = $stmt->get_result();
        app::$numrows = $result->num_rows;
        $stmt->close();
        
        $resultarr = array();
        if(app::$numrows>0) {
            while ($row = $result->fetch_assoc()) {
                $resultarr[]=$row;
            }
        } else {
            return false;
        }
        
        
    return $resultarr[0];
    }

    static function convert($sqlString) {
        # regex pattern
        $patterns = array();
        $patterns[0] = '/\'.*?\'/';

        # best to use question marks for an easy example
        $replacements = array();
        $replacements[0] = '?';

        # perform replace
        $preparedSqlString = preg_replace($patterns, $replacements, $sqlString);

        # grab parameter values
        $pregMatchAllReturnValueHolder = preg_match_all($patterns[0], $sqlString, $grabbedParameterValues);
        $parameterValues = $grabbedParameterValues[0];
        
        $bindstr = '';
        $newvals = array();
        foreach($parameterValues as $k=>$pv) {
            $type = gettype($pv);
            if($type=='integer') { $bindstr.='i'; }
            else if($type=='double') { $bindstr.='d'; }
            else { $bindstr.='s'; }
            $newvals[$k] = str_replace("'","",$pv);
        }
        if(!$bindstr) { return false; }
        //print_r($newvals);
    return array($preparedSqlString,$newvals,$bindstr);
    }
    
    static function valref($arr){
        $refs = array();
        foreach($arr as $key => $value) {
            $refs[$key] = &$arr[$key];
        }
    return $refs;
    }
    
    
    static function selectrowsplain($q) {
        $c = self::convert($q);
        if(!$c) { echo 'Empty Query'; return false; }
        $query = $c[0];
        $params = $c[1];
        $bindstr = array($c[2]);
        
        $bind_arguments = array_merge($bindstr,$params);
        
        $stmt = self::$link->prepare($query);
        if(!$stmt) { 
            app::$dberror = self::$link->error;
            exit; 
        }

        call_user_func_array(array($stmt, 'bind_param'), self::valref($bind_arguments));
        $stmt->execute();
        
        if($stmt->error) {
            app::$dberror = $stmt->error;
            return false; 
        } 
        $result = $stmt->get_result();
        app::$numrows = $result->num_rows;
        //echo self::$numrows;
        $stmt->close();
        
        $row = array();
        if(self::$numrows>0) {
            while ($r = $result->fetch_assoc()) {
                $row[] = $r;
            }
        } else {
            return false;
        }
        
    return $row;
    }
    
    
    static function selectrows($s,$f='',$w=array(),$o=array(),$l=array()) {
        $vt = '';
        $ot = '';
        $lt = '';
        $sqlbindstring = '';

        if(!empty($w)) { 
            $vt .= ' WHERE ';  
            foreach ($w as $key=>$val) {
                $vt .= $key."=? AND ";
                $type = gettype($val);
                if($type=='integer') { $sqlbindstring.='i'; }
                else if($type=='double') { $sqlbindstring.='d'; }
                else { $sqlbindstring.='s'; }
            }
            $vt = rtrim($vt,' AND ');
        }
        
        if(!empty($l)) {
            $sqlbindstring.='i';
            $sqlbindstring.='i';
            $lt = ' LIMIT ?,?';
        }
        
        
        $rv1 = array_values($w);
        $rv2 = array_values($l);
        $recordvalues = array_merge($rv1,$rv2);
        $bind_arguments = [];
        $bind_arguments[] = $sqlbindstring;
        foreach ($recordvalues as $recordkey => $recordvalue)
        {
            $bind_arguments[] = & $recordvalues[$recordkey];    # bind to array ref, not to the temporary $recordvalue
        }
        
        if(!empty($o)) { $ot = ' ORDER BY '.$o[0].' '.$o[1]; } 
        //if(!empty($l)) { $lt = ' LIMIT '.$l[0].','.$l[1]; }
        $q = 'SELECT '.$s.' FROM '.$f.$vt.$ot.$lt;
        //echo $q;
        
        $stmt = self::$link->prepare($q);
        if(!$stmt) { 
            app::$dberror = self::$link->error;
            exit; 
        }
        //print_r($bind_arguments);
        if(strlen($sqlbindstring)>0) { call_user_func_array(array($stmt, 'bind_param'), $bind_arguments); }
        $stmt->execute();
        
        if($stmt->error) {
            app::$dberror = $stmt->error;
            return false; 
        } 
        
        $result = $stmt->get_result();
        app::$numrows = $result->num_rows;
        $stmt->close();
        
        $row = array();
        if(app::$numrows>0) {
            while ($r = $result->fetch_assoc()) {
                
                foreach($r as $k=>$v) {
                    if(substr($k,0,4)=="user") { 
                        $users = app::userscombo(); 
                        if(array_key_exists($v,$users)) { $r['x'.$k]=$users[$v]; } else { $r['x'.$k]="0"; }
                    }               
                    if(substr($k,0,4)=="pric") { $r[$k]=floatval($v); }
                    if(substr($k,0,4)=="time") { 
                        $r['x'.$k]=date('d-m-Y', $v); 
                        $r['y'.$k]=date('d-m-Y H:i', $v); 
                        $r['z'.$k]=helper::timeago($v);
                    }
                    if(substr($k,0,4)=="text") {  $r['x'.$k]=str_replace(array("\r\n","\r","\n"),'<br>',$v); }
                }
                
                //print_r($r);
                $row[] = $r;
            }
        } else {
            return false;
        }

        
    return $row;
    }
    
    
    static function update($t,$set,$w) {
        $sqlbindstring ='';
        $st='';
        foreach ($set as $col=>$val) {
            $st.=$col."=?,";
            $type = gettype($val);
            if($type=='integer') { $sqlbindstring.='i'; }
            else if($type=='double') { $sqlbindstring.='d'; }
            else { $sqlbindstring.='s'; }
        }
        $st = rtrim($st,',');
        
        $wt='';
        
        foreach($w as $key=>$v) {
            $wt.=$key."=? AND ";
            $type = gettype($v);
            if($type=='integer') { $sqlbindstring.='i'; }
            else if($type=='double') { $sqlbindstring.='d'; }
            else { $sqlbindstring.='s'; }
        }
        $wt = rtrim($wt,' AND ');
        
        $rv1 = array_values($set);
        $rv2 = array_values($w);
        $recordvalues = array_merge($rv1,$rv2);
        $bind_arguments = [];
        $bind_arguments[] = $sqlbindstring;
        foreach ($recordvalues as $recordkey => $recordvalue)
        {
            $bind_arguments[] = & $recordvalues[$recordkey];    # bind to array ref, not to the temporary $recordvalue
        }
        
        $q = 'UPDATE '.$t.' SET '.$st.' WHERE '.$wt;
        $stmt = self::$link->prepare($q);
        
        if(!$stmt) { 
          app::$dberror = self::$link->error;
          exit;
        }
        call_user_func_array(array($stmt, 'bind_param'), $bind_arguments);
        
        $stmt->execute();
        if($stmt->error) {
            app::$dberror = $stmt->error;
            return false; 
        }
        app::$numrows = $stmt->affected_rows;
        $stmt->close();
    return true;
    }
    
    static function delete ($t,$w) {
        $sqlbindstring ='';
        $wt='';
        foreach($w as $key=>$v) {
            $wt.=$key."=? AND ";
            $type = gettype($v);
            if($type=='integer') { $sqlbindstring.='i'; }
            else if($type=='double') { $sqlbindstring.='d'; }
            else { $sqlbindstring.='s'; }
        }
        $wt = rtrim($wt,' AND ');
        
        $recordvalues = array_values($w);
        $bind_arguments = [];
        $bind_arguments[] = $sqlbindstring;
        foreach ($recordvalues as $recordkey => $recordvalue)
        {
            $bind_arguments[] = & $recordvalues[$recordkey];    # bind to array ref, not to the temporary $recordvalue
        }
        
        $q = 'DELETE FROM '.$t.' WHERE '.$wt;
        $stmt = self::$link->prepare($q);
        if(!$stmt) {
          app::$dberror = self::$link->error;
          exit; 
        }
        call_user_func_array(array($stmt, 'bind_param'), $bind_arguments);
        $stmt->execute();
        if($stmt->error) {
            app::$dberror = $stmt->error;
            return false; 
        }
        app::$numrows = $stmt->affected_rows;
        $stmt->close();
    return true;
    }
        
}

?>
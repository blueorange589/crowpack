<?php
// echo __DIR__;
// $wppath = substr(__DIR__,0,-27);
// require $wppath.'wp-config.php';


class db {
	public	$errmsg	= '';
	public	$numrows = '';
	public	$insertid = 0;
	private $link;

	function __construct($host,$user,$pass,$name) {
		$this->link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if (mysqli_connect_errno()) {
			$this->errmsg = mysqli_connect_error();
			return false;
		}
		mysqli_set_charset($this->link, "utf8");
	return $this->link;
	}

	function selectvar($q) {
		if(!$this->link) { return false; }

		$string = $q;
		$string = ' ' . $string;
    $ini = stripos($string, 'SELECT ');
    if ($ini == 0) {
			$this->errmsg = 'Var not defined';
			return false;
		}
    $ini += strlen($start);
    $len = stripos($string, ' FROM', $ini) - $ini;
    $var = substr($string, $ini, $len);

		$query = mysqli_query($this->link, $q);
		if(!$query) {
			$this->errmsg = mysqli_error($this->link);
			return false;
		}
		$this->numrows = mysqli_num_rows($query);
		$result = mysqli_fetch_assoc($query);
		mysqli_free_result($query);
	return $result[$var];
	}

	function selectrow($q) {
		if(!$this->link) { return false; }
		$query = mysqli_query($this->link, $q);
		if(!$query) {
			$this->errmsg = mysqli_error($this->link);
			return false;
		}
		$this->numrows = mysqli_num_rows($query);
		$result = false;
		if($this->numrows>0) { $result = mysqli_fetch_assoc($query); }
	return $result;
	}

	function selectrows($q) {
		if(!$this->link) { return false; }
		$query = mysqli_query($this->link, $q);
		if(!$query) {
			$this->errmsg = mysqli_error($this->link);
			return false;
		}
		$this->numrows = mysqli_num_rows($this->link);
		$rows=array();
		while ($row=mysqli_fetch_assoc($query)) {
     $rows[] = $row;
    }
	return $rows;
	}

	function insert($q) {
		if(!$this->link) { return false; }
		$query = mysqli_query($this->link, $q);
		if(!$query) {
			$this->errmsg = mysqli_error($this->link);
			return false;
		}
		$this->numrows = mysqli_affected_rows($this->link);
		if($this->numrows<1) {
			$this->errmsg = mysqli_error($this->link);
			return false;
		}
		$this->insertid = mysqli_insert_id($this->link);
	return true;
	}

	function update($q) {
		if(!$this->link) { return false; }
		$query = mysqli_query($this->link, $q);
		if(!$query) {
			$this->errmsg = mysqli_error($this->link);
			return false;
		}
		$this->numrows = mysqli_affected_rows($this->link);
		if($this->numrows<1) {
			$this->errmsg = mysqli_error($this->link);
			return false;
		}
	return true;
	}

	function delete($q) {
		if(!$this->link) { return false; }
		$query = mysqli_query($this->link, $q);
		if(!$query) {
			$this->errmsg = mysqli_error($this->link);
			return false;
		}
		$this->numrows = mysqli_affected_rows($this->link);
		if($this->numrows<1) {
			$this->errmsg = mysqli_error($this->link);
			return false;
		}
	return true;
	}

	function close() {
		if(!$this->link) { return false; }
		mysqli_close($this->link);
	}
}
$db = new db(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$out = array('result'=>'','sccmsg'=>'','errmsg'=>'','success'=>false,'dberror'=>'');


if($db->errmsg) { $out['dberror']=$db->errmsg; }
$db->close();

if($out['result']) { $out['success']=true; }
echo json_encode($out);


?>

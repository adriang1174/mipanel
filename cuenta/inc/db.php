<?
require_once("adodb/adodb.inc.php");

class sql_query
{
	var $select;
	var $from;
	var $where;
	var $groupby;
	var $orderby;
	var $limit;
	var $offset;

	function sql_query()
	{
		$this->select = false;
		$this->from = false;
		$this->where = false;
		$this->groupby = false;
		$this->orderby = false;
		$this->limit = false;
		$this->offset = false;
	}
	function render()
	{
		if($this->select == false)
			return false;
		if($this->from == false)
			return false;

		$q = "select ".$this->select." from ".$this->from;

		if($this->where != false)
			$q .= " where ".$this->where;
		  
		if($this->groupby != false)
			$q .= " group by ".$this->groupby;
			
		if($this->orderby != false)
			$q .= " order by ".$this->orderby;
			
		if($this->limit != false)
			$q .= " limit ".$this->limit;
			
		if($this->offset != false)
			$q .= " offset ".$this->offset;
		return $q;
	}
}

class db
{
	/* Connect to DB, default persistent connection is used */
	static function init($persistent = true)
	{
	global $dbh;
		//$host = "201.216.230.78";
		$host = "db-mipanel.alternativa.com.ar";
		// $host = "127.0.0.1";
		$user = "site_cuenta";
		$pass = "cuenta*111";
		$dbname = "ra_cuenta";
		
		$dbh = NewADOConnection('postgres');
		$dbh->autoCommit = true;
		
		// PARCHE FUERZO TODAS LAS CONEXIONES PARA QUE NO SEAN PERSISTENTES
		/*
		if($persistent){
		  $dbh->PConnect($host, $user, $pass, $dbname);
		}else{
		  $dbh->Connect($host, $user, $pass, $dbname);
		 }
		 */
		 $dbh->Connect($host, $user, $pass, $dbname);
		
		
		return $dbh;
	}
	
	function mssql_escape_string($string_to_escape) {
		$replaced_string = str_replace("'","''",$string_to_escape);
		return $replaced_string;
	} 
	
	function cleanup()
	{
	global $dbh;

		$dbh->Close();
	}

	function prepare()
	{
		return 1;
	}

	/* Execute and see if something changes */
	function DoIt($sql_query)
	{
	global $dbh;

		$dbh->Execute($sql_query);

		return $dbh->Affected_Rows();
	}

	/* Return first field from the first row as scalar */
	static function get_row_as_scalar($sql_query)
	{
	global $dbh;
	
		$dbh->SetFetchMode(ADODB_FETCH_NUM);
		if(($rs = $dbh->Execute($sql_query)) == FALSE)
		  return $rs;
		$arr = $rs->FetchRow();

		return $arr[0];
	}

	static function get_rows_field_as_array($sql_query, $field_pos = 0)
	{
	global $dbh;

		$rs_out = array();
		if(($rs = $dbh->Execute($sql_query)) == FALSE)
		  return $rs;
		while ($arr = $rs->FetchRow())
			$rs_out[] = $arr[$field_pos];

		return $rs_out;
	}
	
	/* Return rows as array of arrays */
	static function get_rows_as_array($sql_query)
	{
	global $dbh;
		$dbh->SetFetchMode(ADODB_FETCH_NUM);
		if(($rs = $dbh->Execute($sql_query)) == FALSE)
		  return $rs;

		return $rs->GetArray();
	}
	
	static function get_rows_as_hash($sql_query)
	{
	global $dbh;
		$dbh->SetFetchMode(ADODB_FETCH_ASSOC);
		if(($rs = $dbh->Execute($sql_query)) == FALSE)
		  return $rs;
	return $rs->fields;
	}
	
	static function get_rows_as_array_of_hashes($sql_query)
	{
	global $dbh;
		$dbh->SetFetchMode(ADODB_FETCH_ASSOC);
		if(($rs = $dbh->Execute($sql_query)) == FALSE){
		  return $rs;
		 }
		return $rs->GetArray();

	}

	static function get_record_set($sql_query)
	{
	global $dbh;
	
		return $dbh->Execute($sql_query);
	}

	function sql_escape($sql_query)
	{
	global $dbh;

		return $dbh->Quote($sql_query);
	}
	
	static function get_rows_field_as_hash($sql_query, $field_key = 0, $field_value = 1)
	{
	global $dbh;

		$rs_out = array();
		if(($rs = $dbh->Execute($sql_query)) == FALSE)
		  return $rs;
		while ($arr = $rs->FetchRow())
		{
			$key = $arr[$field_key];
			$value = $arr[$field_value];
			$rs_out[$key] = $value;
		}
		return $rs_out;
	}
	
}

?>

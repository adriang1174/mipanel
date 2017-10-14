<?
require_once( INCLUDE_PATH . "db.php");

define( 'CCENTER_LINE_TYPE_PIN', "P");
define( 'CCENTER_LINE_TYPE_LINE', "L");
define( 'CCENTER_USER', "web");
define( 'CCENTER_PROGRAM', "ca");

class ccenter_line
{
	var $type;		// L/P
	var $number;	// ####

	function ccenter_line( $type, $number)
	{
		$this->type = $type;
		$this->number = $number;
	}

	function create_from_str( $str)
	{
		$str = trim( $str);
		$type = trim( substr( $str, 0, 1));
		$number = trim( substr( $str, 1));

		if ( !in_array( $type, array( CCENTER_LINE_TYPE_PIN, CCENTER_LINE_TYPE_LINE)))
			return null;

		if ( !is_numeric( $number))
			return null;

		return new ccenter_line( $type, $number);
	}
}

class ccenter_item
{
	var $name;			// Name.
	var $line;			// object: ccenter_line.
	
	function ccenter_item( $name, $line)
	{
		$this->name = $name;
		$this->line = $line;
	}
}

class ccenter
{
	var $userid;
	
	function ccenter( $userid)
	{
		$this->userid = $userid;
	}
	
	function get_all( )
	{
		db::init();
		$query = "select centrocostos, linea, cliente_id, tiposervicio from centrocostos where cliente_id ='".$this->userid."'";
		$ccenters = db::get_rows_as_array($query);
		$out = array();
		
		foreach ($ccenters as $ccenter)
		  $out[] = new ccenter_item( $ccenter[0], new ccenter_line( $ccenter[3], $ccenter[1]));	
	
	  	return $out;	  
	}

	function get_free_lines( )
	{
		db::init();
		$query = "select distinct tiposervicio, linea from traficohistorico where cliente_id = '$this->userid' and linea not in (select linea from centrocostos where cliente_id = '$this->userid') union ";
		$query .= " select distinct tiposervicio, linea from trafico where cliente_id = '$this->userid' and linea not in (select linea from centrocostos where cliente_id = '$this->userid')";
		
		$freelines = db::get_rows_as_array($query);
		$out = array();
		
		foreach($freelines as $freeline)
			$out[] = new ccenter_line( $freeline[0], $freeline[1]);

		return $out;
	}

	function del( $line)
	{
		// type: $line->type
		// number: $line->number
		db::init();
		$query = "delete from centrocostos where cliente_id = '$this->userid' and linea = '$line->number'";
		return db::DoIt($query);
	}

	function get_name( $line)
	{
		db::init();
		$query = "select centrocostos from centrocostos where cliente_id = '$this->userid' and linea = '$line->number'";
		return db::get_row_as_scalar($query);
	}
	
	function update( $line, $name)
	{
		// type and number, same as above.
		db::init();
		$query = "update centrocostos set centrocostos = '$name' where cliente_id = '$this->userid' and linea = '$line->number'";
		return db::DoIt($query);
	}

	function create( $ccenter)
	{
		db::init();
		// $ccenter = object(ccenter_item)
		$query = "insert into centrocostos(cliente_id, tiposervicio, linea, centrocostos, usuario, last_update, programa) values('$this->userid', '".$ccenter->line->type."', '".$ccenter->line->number."', '".$ccenter->name."', '".CCENTER_USER."', now(), '".CCENTER_PROGRAM."')";
		return db::DoIt($query);
	}
}

?>

<?
require_once( INCLUDE_PATH . "db.php");

define( 'RCALL_USER', "web");
define( 'RCALL_PROGRAM', "ca");

class rcall_item
{
	var $dest;
	var $project;
	var $name;
	var $lastname;
	var $company;
	var $title;
	var $email;
	
	function rcall_item( $dest, $project, $name, $lastname, $company, $title, $email)
	{
		$this->dest = $dest;
		$this->project = $project;
		$this->name = $name;
		$this->lastname = $lastname;
		$this->company = $company;
		$this->title = $title;
		$this->email = $email;
	}
}

class rcall
{
	var $userid;
	
	function rcall( $userid)
	{
		$this->userid = $userid;
	}
	
	function get_all( )
	{
		db::init();

		$query = "select destino, proyecto,  nombre, apellido, empresa, cargo, email From proyectos where cliente_id = '".$this->userid."' order by proyecto";
		$rcalls = db::get_rows_as_array($query);
		$out = array();
		
		foreach ($rcalls as $rcall)
		  $out[] = new rcall_item( $rcall[0], $rcall[1], $rcall[2], $rcall[3], $rcall[4], $rcall[5], $rcall[6]);	
	
	  	return $out;	  
	}

	function get_free_dest( )
	{
		db::init();
		$query = "select distinct destino from traficohistorico where cliente_id = '$this->userid' ";
		$query .= "and destino not in (select destino from trafico where cliente_id = '$this->userid') ";
		$query .= "and destino not in (select destino from proyectos where cliente_id = '$this->userid') ";
		$query .= " union ";
		$query .= "select distinct destino from trafico where cliente_id = '$this->userid' ";
		$query .= "and destino not in (select destino from traficohistorico where cliente_id = '$this->userid') ";
		$query .= "and destino not in (select destino from proyectos where cliente_id = '$this->userid')";
		
		return db::get_rows_as_array($query);
	}

	function del( $dest)
	{
		db::init();
		$query = "delete from proyectos where cliente_id = '$this->userid' and destino = '$dest'";
		return db::DoIt($query);
	}

	function get_project( $dest)
	{
		db::init();
		$query = "select proyecto, nombre, apellido, empresa, cargo, email From proyectos where cliente_id = '".$this->userid."' and destino = '$dest'";
		$proj_arr1 = db::get_rows_as_array($query);
		$proj_arr = $proj_arr1[0];
		return  new rcall_item($dest, $proj_arr[0], $proj_arr[1], $proj_arr[2], $proj_arr[3], $proj_arr[4], $proj_arr[5]);
	}
	
	function update( $dest, $item)
	{
		db::init();
		$query = "update proyectos set proyecto = '$item->project', nombre = '$item->name', apellido = '$item->lastname', empresa = '$item->company', cargo = '$item->title', email = '$item->email' where cliente_id = '$this->userid' and destino = '$dest'";
		return db::DoIt($query);
	}

	function create( $item)
	{
		db::init();
		$query = "insert into proyectos(cliente_id, destino, proyecto, nombre, apellido, cargo, empresa, email, usuario, last_update, programa) values('$this->userid', '$item->dest', '$item->project', '$item->name', '$item->lastname', '$item->title', '$item->company', '', '".RCALL_USER."', now(), '".RCALL_PROGRAM."')";
		return db::DoIt($query);
	}
}

?>

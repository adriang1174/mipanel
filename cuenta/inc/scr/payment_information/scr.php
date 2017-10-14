<?

class scr
{
    
	function parameters( $params)
	{
		return true;
	}
	
	function filter( $params)
	{
		return true;
	}
	
	function process( $params)
	{
		return true;
	}

	function assign( $params)
	{
		global $smarty;	
	
		$query = "SELECT fpago, nro_tc, vto_tc FROM clientes WHERE cliente_id = '". ca_session::get_userid( ) ."'";

		$datos = db::get_rows_as_hash($query);

		$q_nombre = "SELECT codigo_traduccion, muestra_detalles FROM codigos_fpago WHERE fpago = '". $datos['fpago'] ."'";
		
		$nombre_forma_pago = db::get_rows_as_hash($q_nombre);


		$smarty->assign('nombre_forma_pago', constant('TPL_FORMAPAGO_'.$nombre_forma_pago["codigo_traduccion"]));
		
		if($nombre_forma_pago["muestra_detalles"]){
			$smarty->assign('datos', $datos);
			$smarty->assign('muestra_detalles', true);
		}
		
		return true;
	}
}

?>

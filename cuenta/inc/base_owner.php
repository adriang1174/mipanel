<?
class base_owner
{
	function load( $owner)
	{

		if ( !$owner)
			return false;
		if ( strstr( $owner, ".."))
            return false;

		// Owner
		$ownerfile = "owner/" . $owner . "/owner.ca";
		if ( !is_file( $ownerfile))
			return false;
		define( 'OWNER', $owner );
		
		require_once( $ownerfile );
		
		$ownerlangfile = "owner/" . $owner . "/lang/" . ca_session::language_get( ) . ".ca";

		if ( !is_file($ownerlangfile))
		{
			die("Error: Imposible cargar el archivo requerido: " . $ownerlangfile);
			return false;
		}
		
		// Loading the language file.
		require_once( $ownerlangfile);
		

		return true;
	}

	function detect_and_load( $_owner='', $cliente_id = NULL )
	{
		if(isset($cliente_id) && $cliente_id != ''){
			db::init();			
			$res = db::get_rows_as_array("SELECT o.carpeta, o.mercado, o.empresa FROM owner o INNER JOIN clientes c ON o.mercado = c.mercado AND o.empresa = c.empresa WHERE c.cliente_id = '". $cliente_id ."'");

			if(count($res) > 0){
				ca_session::set('mercado', $res["mercado"]);
				ca_session::set('empresa', $res["empresa"]);	
				if($res["carpeta"] != ''){
					base_owner::load( $res["carpeta"]);
					return true;
				}
				
			}
			
			
		}
		
        // Loading the session owner.		
		if ($_owner == '') {
			$_owner = ca_session::get( "owner");
		} 
		
		if ( $_owner && base_owner::load( $_owner))
			return true;

		/* TODO: Darse cuenta que owner es en funcion del referer. */
        $ref = $_SERVER[ 'HTTP_REFERER'];

        // Loading the default owner.
		
		if ( !base_owner::load( "red"))
			return false;

		return true;
	}
}

?>

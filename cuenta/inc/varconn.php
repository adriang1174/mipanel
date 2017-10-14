<?

/*
 * varconn contiene la funcionalidad necesaria para obtener informacion de las variables
 * del PHP. Puede obtener los parametros pasados al script que la utilize, y ademas tiene
 * funcionalidad para obtener todo tipo de informacion desde el array _SERVER. Una ventaja
 * que tiene, es que implementa varios checkeos antes de obtener el valor de un elemento de
 * un array, y de esta manera, son todos los metodos libres de errores. 
 * 
 */

class varconn
{
	/*
     * Funciones para obtener parametros pasadas por GET, POST o ambos de una manera segura
	 * y limpia de errores.
	 */

	function GET( $key, $maxlength = 256)
	{
		return varconn::safe_get_variable_from_array( $_GET, $key, $maxlength);
	}

	function POST( $key, $maxlength = 50000)
	{
		return varconn::safe_get_variable_from_array( $_POST, $key, $maxlength);
	}

	function REQUEST( $key, $maxlength = 256)
	{
		return varconn::safe_get_variable_from_array( $_REQUEST, $key, $maxlength);
	}

    function get_host( )
    {
        return varconn::safe_get_variable_from_array( $_SERVER, "HTTP_HOST", 64);
    }

    function is_https( )
    {
        $https = varconn::safe_get_variable_from_array( $_SERVER, "HTTPS", 8);
        if ( $https && strcmp( $https, "on") == 0)
            return true;

        return false;
    }
    
	/*
	 * Funciones de caracter concreto, obtienen informacion especifica sobre algun recurso.
 	 */

	function get_language( )
	{
		return varconn::safe_get_variable_from_array( $_SERVER, "HTTP_ACCEPT_LANGUAGE", 64);
	}

	function get_remoteip( )
	{
		$ffor = varconn::safe_get_variable_from_array( $_SERVER, "HTTP_X_FORWARDED_FOR", 64);
		if ( $ffor)
			return $ffor;
		
		$raddr = varconn::safe_get_variable_from_array( $_SERVER, "REMOTE_ADDR", 64);
		if ( $raddr)
			return $raddr;

		return false;
	}
	
	
	/*
	 * Funciones internas.
 	 */
	
	function safe_get_variable_from_array( $arr, $key, $length) {
	
		if ( !$key)
			return "";
		
		$_value = "";
		if ( !is_array( $arr) || !array_key_exists( $key, $arr))
			return "";
		
		if ( strlen( $arr[ $key]) > $length)
			return "";
		
		if ( strlen( $arr[ $key]) <= 0)
			return "";

		return trim( $arr[ $key]);
	}
}

?>

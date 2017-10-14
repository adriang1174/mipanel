<?

require_once( INCLUDE_PATH . "data/payment_gateways.php");

define( 'FILTER_TYPE_GENERIC', "generic");
define( 'FILTER_TYPE_NAME', "name");
define( 'FILTER_TYPE_MONTHID', "monthid");
define( 'FILTER_TYPE_FLAG', "flag");
define( 'FILTER_TYPE_TICKETID', "ticketid");
define( 'FILTER_TYPE_RECEIPTID', "receiptid");
define( 'FILTER_TYPE_ITEMID', "itemid");
define( 'FILTER_TYPE_SERVICETYPE_PINID', "servicetype_pinid");
define( 'FILTER_TYPE_PINID', "pinid");
define( 'FILTER_TYPE_SERVICETYPE', "servicetype");
define( 'FILTER_TYPE_NEXT', "next");
define( 'FILTER_TYPE_LIMIT', "limit");
define( 'FILTER_TYPE_LANGUAGE', "language");
define( 'FILTER_TYPE_USERNAME', "username");
define( 'FILTER_TYPE_DATE', "date");
define( 'FILTER_TYPE_TRAFF_NF_TYPE', "traff_nf_type");
define( 'FILTER_TYPE_TRAFF_P_TYPE', "traff_p_type");
define( 'FILTER_TYPE_TRAFF_F_TYPE', "traff_f_type");
define( 'FILTER_TYPE_LIMIT_MINUTES', "limit_minutes");
define( 'FILTER_TYPE_LIMIT_PRICE', "limit_price");
define( 'FILTER_TYPE_EMAIL', "email");
define( 'FILTER_TYPE_PASSWORD', "password");
define( 'FILTER_TYPE_GENFORMTXT', "genformtxt");

/*
 * filter, contiene la funcionalidad necesaria para filtrar los parametros
 * inseguros que llegan desde la web y convertirlos en algo seguro. Por convencion
 * todas las funciones aceptan un string, y devuelven false en el caso de que
 * el filtrado sea fallido, (un string en caso contrario). Este string que
 * devuelven las funciones de filtrado, debe reemplazar al original que se
 * le paso como parametro. De esta manera, podemos ademas de devolver el valor
 * de verdad sobre su seguridad, modificarla a gusto para que satisfaga
 * nuestras necesidades.
 *
 */

class filter
{
    function generic( $haystack)
    {
        return trim( $haystack);
    }

    function genformtxt( $haystack)
    {
        $haystack = trim( $haystack);
        if ( strlen( $haystack) <= 0 || strlen( $haystack) > 60)
            return false;

        return $haystack;
    }
    
	function name( $haystack)
	{
		return filter::name_generic( $haystack, 2, 128);
	}

	/*
	 * Un nombre, el largo permitido esta definido por los parametros minlength y 
	 * maxlength.
	 */
	
	function name_generic( $haystack, $minlength, $maxlength)
	{
		if ( !$haystack || !is_string( $haystack))
			return false;

		$tmp = trim( $haystack);
		$length = strlen( $tmp);
		if ( $length < $minlength || $length > $maxlength)
			return false;

		if ( !preg_match( "/^[[:alnum:] \\-\\.,#']{" . $minlength ."," . $maxlength . "}$/", $tmp))
			return false;

		return $tmp;
	}

	function monthid( $haystack)
	{
		$haystack = trim( $haystack);
		if ( !is_numeric( $haystack))
			return false;

		if ( ( int)$haystack <= 0 || ( int)$haystack > 12)
			return false;

		return $haystack;
	}

	function flag( $haystack)
	{
		$haystack = trim( $haystack);
		if ( strcmp( ( string)$haystack, "0") == 0
			|| strcmp( ( string)$haystack, "1") == 0)
			return ( string)$haystack;

		return false;
	}

	function ticketid( $haystack)
	{
		$haystack = trim( $haystack);
		if ( !preg_match( "/^(FA|FB|FE|CA|CB|CE)\\-([0-9]{4})\\-([0-9]{8})$/", $haystack))
			return false;

		return $haystack;
	}

	function receiptid( $haystack)
	{
		$haystack = trim( $haystack);
		if ( !preg_match( "/^(R)\\-([0-9]{4})\\-([0-9]{8})$/", $haystack))
			return false;

		return $haystack;
	}
	
	function itemid( $haystack)
	{
		$haystack = trim( $haystack);
		if ( !is_numeric( $haystack))
			return false;

		if ( ( int)$haystack <= 0 || ( int)$haystack > 32768)
			return false;

		return ( int)$haystack;
	}

	function servicetype_pinid( $haystack)
	{
		$haystack = trim( $haystack);

		if ( strlen( $haystack) <= 0)
			return false;
		if ( strlen( $haystack) > 32)
			return false;

		$sp = explode( ' ', $haystack);
		if ( count( $sp) != 2)
			return false;

		if ( $sp[ 0] != "L" && $sp[ 0] != "P")
			return false;
		
		if ( !is_numeric( $sp[ 1]))
			return false;
			
		return $haystack;
	}
	
	function pinid( $haystack)
	{
		$haystack = trim( $haystack);
		if ( !is_numeric( $haystack))
			return false;

		if ( ( int)$haystack <= 0)
			return false;

		if ( strlen( $haystack) > 32)
			return false;
			
		return $haystack;
	}

	function servicetype( $haystack)
	{
		$haystack = strtoupper( trim( $haystack));

		if ( $haystack != "L" && $haystack != "P")
			return false;
		
		return $haystack;
	}

	function next( $haystack)
	{
		$haystack = trim( $haystack);
		if ( ( int)$haystack <= 0 || ( int)$haystack > DEF_BIGLIMIT)
			return false;

		return ( int)$haystack;
	}

	function limit( $haystack)
	{
		global $DEF_PAGINATION_LIMITS;
		
		$haystack = trim( $haystack);
		foreach( $DEF_PAGINATION_LIMITS as $key => $limit)
		{
			if ( ( int)$haystack == ( int)$limit[ "limit"])
				return ( int)$haystack;
		}

		return false;
	}

	function language( $haystack)
	{
		$haystack = trim( $haystack);
		if ( strlen( $haystack) <= 0 || strlen( $haystack) > 2)
			return false;

		if ( !ctype_alpha( $haystack))
			return false;
			
		return strtolower( $haystack);
	}

	function username( $haystack)
	{
		return $haystack;
	}

	function date( $haystack, $swap = false)
	{
		if ( !$haystack)
			return false;

		$haystack = trim( $haystack);
		$matches = array( );

		$year = 0;
		$month = 0;
		$day = 0;

		if ( $swap)
		{
			$regexp = "";
			if ( !preg_match( "/^([0-9]{4})\\/([0-9]{2})\\/([0-9]{2})$/", $haystack, $matches))
				return false;

			$year = ( int)$matches[ 1];
			$month = ( int)$matches[ 2];
			$day = ( int)$matches[ 3];
		}
		else
		{
			if ( !preg_match( "/^([0-9]{2})\\/([0-9]{2})\\/([0-9]{4})$/", $haystack, $matches))
				return false;

			$year = ( int)$matches[ 3];
			$month = ( int)$matches[ 2];
			$day = ( int)$matches[ 1];
		}

		if ( $day > 31 || $day <= 0 || $month > 12 || $month <= 0 || $year > ( int)date( "Y") || $year <= 1900)
			return false;
		
		return $haystack;
	}

	function traff_nf_type( $haystack)
	{
		if ( !$haystack)
			return false;

		$haystack = ( int)trim( $haystack);
		switch ( $haystack)
		{
			case 1:
			case 2:
			case 3:
			case 4:
			case 5:
			case 6:
			case 7:
			case 8:
			case 9:
			case 10:
				return $haystack;
		}

		return false;
	}

	function traff_p_type( $haystack)
	{
		if ( !$haystack)
			return false;

		$haystack = ( int)trim( $haystack);
		switch ( $haystack)
		{
			case 1:
			case 2:
			case 3:
			case 4:
			case 5:
			case 6:
			case 7:
			case 8:
				return $haystack;
		}

		return false;
	}

	function traff_f_type( $haystack)
	{
		if ( !$haystack)
			return false;

		$haystack = ( int)trim( $haystack);
		switch ( $haystack)
		{
			case 1:
			case 2:
			case 3:
			case 4:
			case 5:
			case 6:
			case 7:
			case 8:
				return $haystack;
		}

		return false;
	}
	
	function limit_minutes( $haystack)
	{
		$haystack = trim( $haystack);
		if ( !is_numeric( $haystack))
			return false;

		if ( ( int)$haystack <= 0)
			return false;

		if ( strlen( $haystack) > 6)
			return false;
			
		return $haystack;
	}

	function limit_price( $haystack)
	{
		$haystack = str_replace( ",", ".", trim( $haystack));
		
		if ( ( float)$haystack <= 0)
			return "";

		return $haystack;
	}

	/*
	function email($haystack) {
		
		if (strlen( $haystack) <= 0 || strlen( $haystack) > 64) return false;

		$haystack = trim( $haystack);
		if (!preg_match( "/^[0-9a-z]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $haystack))
			return false;

		return $haystack;
		
	}
	*/
	
	function email($email){
		$pattern = "/^[\w-]+(\.[\w-]+)*@";
		$pattern .= "([0-9a-z][0-9a-z-]*[0-9a-z]\.)+([a-z]{2,4})$/i";
		if (preg_match($pattern, $email)) {
			return $email;
		}else{
			return false;
		}	
	}

	function password( $haystack)
	{
		if ( strlen( $haystack) <= 0 || strlen( $haystack) > 64)
			return false;

		return $haystack;
	}

	function service_name( $haystack)
	{
		$haystack = trim( urldecode($haystack));

		if ( strlen( $haystack) <= 0 || strlen( $haystack) > 64)
			return false;
		/*
		if ( !preg_match( "/^[a-z0-9]+$/i", $haystack))
			return false;
		*/
		
		return $haystack;
	}

	function rate_number( $haystack)
	{
		$email = filter::email( $haystack);
		if ( $email)
			return $email;

		$haystack = trim( $haystack);
		if ( strlen( $haystack) <= 0 || strlen( $haystack) > 64)
			return false;
/*
		if ( !preg_match( "/^[[:alnum:]]+$/i", $haystack))
			return false;
*/
		return $haystack;
	}

    function p_gateway( $haystack)
    {
		if($haystack == 'rapipago'){
			return $haystack;
		}
        $haystack = trim( $haystack);
        if ( !preg_match( "/^[a-z_]+$/i", $haystack))
            return false;
        
        if ( !p_gateways::exists( $haystack))
            return false;
           
        
        return $haystack;
    }

    function import( $haystack)
    {
        $haystack = trim( $haystack);
        $haystack = str_replace( ",", ".", $haystack);
        if ( !preg_match( "/^[0-9]+(\\.[0-9]+|)$/", $haystack))
            return false;

        return ( float)$haystack;
    }

    function sid( $haystack)
    {
        $haystack = trim( $haystack);
        if ( !preg_match( "/^[0-9a-z]+$/i", $haystack))
            return false;

        return $haystack;
    }

}

?>

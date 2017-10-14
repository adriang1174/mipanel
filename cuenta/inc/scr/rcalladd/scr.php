<?

require_once( INCLUDE_PATH . 'data/rcall.php');

class scr
{
    var $allow_print = false;
    var $allow_printall = false;
    var $allow_exportcsv = false;
    var $allow_email = false;
    var $allow_pay = false;
    
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
	
		$ca_form_rcalladd = new ca_form_rcalladd( );
		$res = $ca_form_rcalladd->do_magic( );
		switch ( $res)
		{
			case CA_FORM_RESULT_DISPLAY:
				// Continue, we should display the form.
				break;

			default:
				// The form has been executed, maybe we redirect
				// somewhere.
				clientcontrol::redirect( "rcalllist.ca");
		}
		
		return true;
	}
}

?>

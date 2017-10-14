<?

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
		$ca_form_ccadd = new ca_form_ccadd( );
		$res = $ca_form_ccadd->do_magic( );
		switch ( $res)
		{
			case CA_FORM_RESULT_DISPLAY:
				// Continue, we should display the form.
				break;

			default:
				// The form has been executed, maybe we redirect
				// somewhere.
				clientcontrol::redirect( "cclist.ca");
		}
		
		return true;
	}
}

?>

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
		if ( $params)
		{
			basescr::setvar( "line", varconn::REQUEST( "line"));
		}
		
		return true;
	}
	
	function filter( $params)
	{
		// It's not necessary filter the line because it is filter with the funcion "create_from_str".
		return true;
	}
	
	function process( $params)
	{
		return true;
	}

	function assign( $params)
	{
		$ca_form_ccadd = new ca_form_ccedit( );
		$res = $ca_form_ccadd->do_magic( );
		switch ( $res)
		{
			case CA_FORM_RESULT_DISPLAY:
				// Continue, we should display the form.
				break;

			default:
				// The form has been executed, maybe we redirect
				// somewhere.
				clientcontrol::redirect( "cclist.ca?r=1");
		}
		
		return true;
	}
}

?>

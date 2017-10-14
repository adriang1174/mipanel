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
			basescr::setvar( "dest", varconn::REQUEST( "dest"));
		}
		
		return true;
	}
	
	function filter( $params)
	{
		basescr::setvar( "dest", filter::pinid( basescr::getvar( "dest")));
		return true;
	}
	
	function process( $params)
	{
		return true;
	}

	function assign( $params)
	{
		$ca_form_rcalledit = new ca_form_rcalledit( );
		$res = $ca_form_rcalledit->do_magic( );
		switch ( $res)
		{
			case CA_FORM_RESULT_DISPLAY:
				// Continue, we should display the form.
				break;

			default:
				// The form has been executed, maybe we redirect
				// somewhere.
				clientcontrol::redirect( "rcalllist.ca?r=1");
		}
		
		return true;
	}
}

?>

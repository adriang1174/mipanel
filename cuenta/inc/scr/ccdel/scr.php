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
		$_line = basescr::getvar( "line");
		$line = ccenter_line::create_from_str( $_line);
		if ( !$line)
			return false;
		
		$ccenter = new ccenter( ca_session::get_userid( ));
		$flag = "";
		if ( !$ccenter->del( $line))
			$flag = "2";
		else
			$flag = "1";

		clientcontrol::redirect( "cclist.ca?r=" . urlencode( $flag));
		return true;
	}
}

?>

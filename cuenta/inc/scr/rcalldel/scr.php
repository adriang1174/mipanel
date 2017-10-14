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
		if ( $params)
		{
			basescr::setvar( "dest", varconn::REQUEST( "dest"));
		}
		
		return true;
	}
	
	function filter( $params)
	{
		$_dest = filter::pinid( basescr::getvar( "dest"));
		basescr::setvar( "dest", $_dest);
		return true;
	}
	
	function process( $params)
	{
		return true;
	}

	function assign( $params)
	{
		$dest = basescr::getvar( "dest");
		if ( !$dest)
			return false;

		$rcall = new rcall( ca_session::get_userid( ));
		$flag = "";
		if ( !$rcall->del( $dest))
			$flag = "2";
		else
			$flag = "1";

		clientcontrol::redirect( "rcalllist.ca?r=" . urlencode( $flag));
		return true;
	}
}

?>

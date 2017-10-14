<?

class scr
{
    var $allow_print = true;
    var $allow_printall = false;
    var $allow_exportcsv = false;
    var $allow_email = true;
    var $allow_pay = false;
    
	function parameters( $params)
	{
		if ( $params)
		{
			basescr::setvar( "receiptid", varconn::REQUEST( "receiptid"));
		}

		return true;
	}
	
	function filter( $params)
	{
		if ( $params)
		{
			$receiptid = filter::receiptid( basescr::getvar( "receiptid"));
			basescr::setvar( "receiptid", $receiptid);
		}
		
		return true;
	}
	
	function process( $params)
	{
		return true;
	}

	function assign( $params)
	{
		global $smarty;
		
		$receiptid = basescr::getvar( "receiptid");

		$user = new user( ca_session::get_userid( ));
		$smarty->assign( "receipt", $user->get_receipt( $receiptid));
		$smarty->assign( "info_contact", owner::info_contact( ));
		$smarty->assign( "info_facturation", owner::info_facturation( ));
		$smarty->assign( "show_iva_details", owner::show_iva_details( ));
		return true;
	}
}

?>

<?

class scr
{
    var $allow_print = true;
    var $allow_printall = false;
    var $allow_exportcsv = true;
    var $allow_email = true;
    var $allow_pay = false;
    
	function parameters( $params)
	{
		if ( $params)
		{
			basescr::setvar( "ticketid", varconn::REQUEST( "ticketid"));
			basescr::setvar( "itemid", varconn::REQUEST( "itemid"));
		}

		return true;
	}
	
	function filter( $params)
	{
		if ( $params)
		{
			$ticketid = filter::ticketid( basescr::getvar( "ticketid"));
			$itemid = filter::itemid( basescr::getvar( "itemid"));

			basescr::setvar( "ticketid", $ticketid);
			basescr::setvar( "itemid", $itemid);
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
		
		$ticketid = basescr::getvar( "ticketid");
		$itemid = basescr::getvar( "itemid");

		$user = new user( ca_session::get_userid( ));
		$smarty->assign( "ticket_item", $user->get_ticket_item_details( $ticketid, $itemid));
	
		return true;
	}
}

?>

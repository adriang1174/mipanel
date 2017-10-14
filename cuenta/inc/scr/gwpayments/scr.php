<?

class scr
{
    var $allow_print = true;
    var $allow_printall = false;
    var $allow_exportcsv = false;
    var $allow_email = true;
    var $allow_pay = true;
    
	function parameters( $params)
	{
		if ( $params)
		{
			basescr::setvar( "ticketid", varconn::REQUEST( "ticketid"));
			basescr::setvar( "month", varconn::REQUEST( "month"));
		}

		return true;
	}
	
	function filter( $params)
	{
		if ( $params)
		{
			$ticketid = filter::ticketid( basescr::getvar( "ticketid"));
			$month = filter::monthid( basescr::getvar( "month"));

			basescr::setvar( "ticketid", $ticketid);
			basescr::setvar( "month", $month);
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
		$month = basescr::getvar( "month");
        
		$user = new user( ca_session::get_userid( ));
		$smarty->assign( "ticket", $month ? $user->get_ticket( null, $month) : $user->get_ticket( $ticketid, null));

		$smarty->assign( "ticket_sel_month", $month ? $month : false);
		$smarty->assign( "ticket_months", $user->get_ticket_months( ));
		$smarty->assign( "info_contact", owner::info_contact( ));
		$smarty->assign( "info_facturation", owner::info_facturation( ));
		$smarty->assign( "show_iva_details", owner::show_iva_details( ));

		return true;
	}
}

?>

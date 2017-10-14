<?

class scr
{
    var $allow_print = true;
    var $allow_printall = true;
    var $allow_exportcsv = true;
    var $allow_email = true;
    var $allow_pay = true;
    
	function parameters( $params)
	{
		if ( $params)
		{
			basescr::setvar( "monthid", varconn::REQUEST( "monthid"));
			basescr::setvar( "eml_confirm", varconn::REQUEST( "eml_confirm"));
			basescr::setvar( "pay", varconn::REQUEST( "pay"));
		}

		return true;
	}
	
	function filter( $params)
	{
		if ( $params)
		{
			$monthid = filter::monthid( basescr::getvar( "monthid"));
			$eml_confirm = filter::flag( basescr::getvar( "eml_confirm"));
			if ( $monthid === false)
				basescr::destroyvar( "monthid");
			else
				basescr::setvar( "monthid", $monthid);
			basescr::setvar( "eml_confirm", $eml_confirm);
            
		}
		
		return true;
	}
	
	function process( $params)
	{
		if ( $params)
		{
			/* Nothing to do for now. */
		}

		return true;
	}

	function assign( $params)
	{	
		if(basescr::getvar( "pay") == "1"){
			header("location: ticket.ca?pay=1");
		}
		global $smarty;
		$month = false;
		if ( $params)
		{
			$smarty->assign( "monthid", basescr::getvar( "monthid"));
			$month = basescr::getvar( "monthid");
		}

        // Show or not the "e-mail confirmation" message.
        $smarty->assign( "eml_confirm", basescr::getvar( "eml_confirm"));
        
		$user = new user( ca_session::get_userid( ));
		$smarty->assign( "ticket_months", $user->get_ticket_months( $month));
		$smarty->assign( "ticket_years", $user->get_ticket_years( ));
		$total = 0;
		$is_last = false;
        
		/* Getting the ticket list. */
		$ticket_list = $user->get_ticket_list( false, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, $total);
		SmartyPaginate::setTotal( $total);
		SmartyPaginate::assign( $smarty);

		
		
		/* Converting the list into a generic ca_list. */
		$ca_list_body = array( );
		foreach( $ticket_list as $key => $value)
		{
			if ( $value->ticketid)
			{
				$fletter = substr( trim( $value->ticketid), 0, 1);
				$value->ticketid = str_replace( " ", "", trim( $value->ticketid));

				if ( strcmp( $fletter, "F") == 0)
				{
					$ca_list_body[ ] = array( array( "value" => $value->ticketid, "href" => "ticket.ca?ticketid=" . urlencode( $value->ticketid)), $value->date, $value->importe);
				}
			}
		}
		$ca_list = new ca_list( array( "COMPROBANT", "DATE", "PRICE2"), $ca_list_body);
		$ca_list->show_footer = false;
		$ca_list->paginate = true;
		$ca_list->paginate_element = "TICKETS";
		$smarty->assign( "ca_list", $ca_list);
		

		return true;
	}
}

?>

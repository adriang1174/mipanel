<?

class scr
{
    var $allow_print = true;
    var $allow_printall = true;
    var $allow_exportcsv = true;
    var $allow_email = true;
    var $allow_pay = false;
    
	function parameters( $params)
	{
		if ( $params)
		{
			basescr::setvar( "ticketid", varconn::REQUEST( "ticketid"));
			basescr::setvar( "itemid", varconn::REQUEST( "itemid"));
			basescr::setvar( "pinid", varconn::REQUEST( "pinid"));
			basescr::setvar( "servicetype", varconn::REQUEST( "servicetype"));
		}

		return true;
	}
	
	function filter( $params)
	{
		if ( $params)
		{
			$ticketid = filter::ticketid( basescr::getvar( "ticketid"));
			$itemid = filter::itemid( basescr::getvar( "itemid"));
			$pinid = filter::pinid( basescr::getvar( "pinid"));
			$servicetype = filter::servicetype( basescr::getvar( "servicetype"));

			basescr::setvar( "ticketid", $ticketid);
			basescr::setvar( "itemid", $itemid);
			basescr::setvar( "pinid", $pinid);
			basescr::setvar( "servicetype", $servicetype);
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
		$pinid = basescr::getvar( "pinid");
		$servicetype = basescr::getvar( "servicetype");

		$user = new user( ca_session::get_userid( ));
		$total = 0;
		$is_last = false;

        $traff_details = $user->get_ticket_item_traff( $ticketid, $itemid, $pinid, $servicetype, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, $total);
    	SmartyPaginate::setTotal( $total);
		SmartyPaginate::assign( $smarty);
        $smarty->assign( "ticket_item_traff", $traff_details);

        /* Converting the list into a generic ca_list. */
		$ca_list_body = array( );
        foreach( $traff_details->traff_list as $key => $value)
        {
            $ca_list_body[ ] = array( $value->date, $value->hour, $value->source, $value->called, $value->target, $value->duration, $value->price);
        }
		$ca_list = new ca_list( array( "DATE", "HOUR", "SOURCE", "CALLED", "TARGET", "DURATION", "PRICE2"), $ca_list_body);
		$ca_list->show_footer = false;
		$ca_list->paginate = true;
		$ca_list->paginate_element = "CALLS";
        $smarty->assign( "show_total", $is_last);
		if ( $is_last)
        {
            $smarty->assign( "ca_list_total", array( $traff_details->total_duration, $traff_details->total_price));
            $smarty->assign( "ca_list_total_count", 2);
        }
		$smarty->assign( "ca_list", $ca_list);

		return true;
	}
}

?>

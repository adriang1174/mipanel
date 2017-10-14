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
		global $smarty;

		$rates = new rates( ca_session::get_userid( ));
		$accounts = $rates->get_accounts( );
	
		
		// Converting the list into a generic ca_list.
		$ca_list_body = array( );
		foreach( $accounts as $key => $account)
		{
			if ( $account->number)
			{
				$ca_list_body[ ] = array( $account->service_name, array( "value" => $account->number, "href" => "rate.ca?t=" . urlencode( $account->service) . "&n=" . urlencode( $account->number)));
			}
		}
		$ca_list = new ca_list( array( "SERVICE", "ACCOUNT"), $ca_list_body);
		$ca_list->show_footer = false;
		$ca_list->paginate = false;
		$smarty->assign( "ca_list", $ca_list);

		return true;
	}
}

?>

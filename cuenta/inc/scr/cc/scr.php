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
			basescr::setvar( "datefrom", varconn::REQUEST( "datefrom"));
			basescr::setvar( "dateto", varconn::REQUEST( "dateto"));
			basescr::setvar( "pay", varconn::REQUEST( "pay"));
		}

		return true;
	}
	
	function filter( $params)
	{
		if ( $params)
		{
			// datefrom.
			$datefrom = filter::date( basescr::getvar( "datefrom"));
			if ( $datefrom === false){
				basescr::destroyvar( "datefrom");
			}else{
				basescr::setvar( "datefrom", $datefrom);
			}
			// dateto.
			$dateto = filter::date( basescr::getvar( "dateto"));
			if ( $dateto === false)
				basescr::destroyvar( "dateto");
			else
				basescr::setvar( "dateto", $dateto);
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
		global $smarty;
		
		if( basescr::getvar( "pay") == 1){
			clientcontrol::redirect( "ticket.ca?lastticket=true&pay=1");
		}
		
		$user = new user( ca_session::get_userid( ));
		

		
		$datefrom = basescr::getvar( "datefrom");
		
				
//	parche	print "-- $datefrom --";	
		if(!$datefrom)
		{
			if(isset($_REQUEST['datefrom']))
			{
				$datefrom=trim(urldecode($_REQUEST['datefrom']));

				if(!preg_match("/^\d{1,2}\/\d{1,2}\/\d{1,4}$/",$datefrom))
				{
					$datefrom='';
				}
			}
			else
			{
				$mes_actual = date("m");
				$anio_actual = date("Y");


				if($mes_actual > 6){
					$datefrom= sprintf("%02d", $mes_actual - 6) .'/01/'. $anio_actual;
				}else{
					$datefrom= sprintf("%02d", $mes_actual + 6) .'/01/'. ($anio_actual - 1);
				}
			}
		}

		$dateto = basescr::getvar( "dateto");
//		print "-- ".$_SESSION['owner']." --";
		$total = 0;
		$is_last = false;
		

		/* Getting the cc list. */
		$cc_list = $user->get_cc_detail( $datefrom, $dateto, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, $total);

		
		SmartyPaginate::setTotal( $total);
		SmartyPaginate::assign( $smarty);
		$smarty->assign( "cc_list", $cc_list);

		/* Converting the list into a generic ca_list. */
		$ca_list_body = array( );
		foreach( $cc_list->cc_detail_list as $key => $value)
		{
			$new_receipt = false;
			if ( $value->receipt)
			{
				$fletter = substr( trim( $value->receipt), 0, 1);
				$value->receipt = str_replace( " ", "", trim( $value->receipt));
				switch( $fletter)
				{
					case "D":
						$new_receipt = $value->detail ? array( "value" => $value->receipt, "href" => "") : $value->receipt;
						break;
					case "F":
					
                        $new_receipt = $value->detail ? array( "value" => $value->receipt, "href" => "ticket.ca?ticketid=" . urlencode( $value->receipt)) : $value->receipt;
                        break;
                    case "C":
                    	$new_receipt = $value->detail ? array( "value" => $value->receipt, "href" => "ticket.ca?ticketid=".urlencode( $value->receipt)) : $value->receipt;
                    	break;    
					case "R":
					case "Ri":
                        $new_receipt = $value->detail ? array( "value" => $value->receipt, "href" => "receipt.ca?receiptid=" . urlencode( $value->receipt)) : $value->receipt;
                        //$new_receipt = array( "value" => $value->receipt, "href" => "receipt.ca?receiptid=" . urlencode( $value->receipt));
                        break;
                        
					default: continue;
				}
			}

			if ( $new_receipt)
			{
                $ca_list_body[ ] = array( "value" => $value->date, $new_receipt, $value->expiration,
                    ( strlen( $value->negative) > 0 ? ( ( $cc_list->symbol ? ( $cc_list->symbol . " ") : "") . number_format( ( float)$value->negative, 2)) : ""),
                    ( strlen( $value->positive) > 0 ? ( ( $cc_list->symbol ? ( $cc_list->symbol . " ") : "") . number_format( ( float)$value->positive, 2)) : ""),
                    ( $cc_list->symbol ? ( $cc_list->symbol . " ") : "") . number_format( ( float)$value->balance, 2));
			}
		}
		$ca_list = new ca_list( array( "RELEASE", "COMPROBANT", "EXPIRE_DATE", "NEGATIVE_ALT", "POSITIVE_ALT", "BALANCE"), $ca_list_body);
		$ca_list->show_footer = false;
		$ca_list->paginate = true;
		$ca_list->paginate_element = "TICKETS";
		if ( SmartyPaginate::getCurrentIndex( ) == 0)
            $ca_list->set_section( CA_LIST_SECTION_SUBHEADER, "INITIAL_BALANCE", ( $cc_list->symbol ? ( $cc_list->symbol . " ") : "") . number_format( ( float)$cc_list->saldo_inicial, 2));
		if ( $is_last)
            $ca_list->set_section( CA_LIST_SECTION_SUBFOOTER, "TOTAL_BALANCE", ( $cc_list->symbol ? ( $cc_list->symbol . " ") : "") . number_format( ( float)$cc_list->saldo_final, 2));
		$smarty->assign( "ca_list", $ca_list);
		
		return true;
	}
}

?>

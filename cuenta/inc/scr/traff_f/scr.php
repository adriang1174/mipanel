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
			basescr::setvar( "type", varconn::REQUEST( "type"));
			basescr::setvar( "ticketid", varconn::REQUEST( "ticketid"));
		}

		return true;
	}
	
	function filter( $params)
	{
		if ( $params)
		{
			$type = filter::traff_f_type( basescr::getvar( "type"));
			$ticketid = filter::ticketid( basescr::getvar( "ticketid"));

			basescr::setvar( "type", $type);
			basescr::setvar( "ticketid", $ticketid);
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

		$type = basescr::getvar( "type");
		$ticketid = basescr::getvar( "ticketid");

		// Initializing the user data interface.
		$user = new user( ca_session::get_userid( ));

		// Initializing some pagination stuff.
		$total = 0;
		$is_last = false;

		// Setting the two objects to null.
		$traff_detail = null;
		$traff_resume = null;

		switch ( $type)
		{
			case 1: // Detalle por Centro de Costos
				$smarty->assign( "_title", "TITLE_TRAFF_F_REPORT_DETAIL_BY_COST_CENTER");
				$traff_detail = get_traff_f_by_centro_costos_detail( $user->userid, $ticketid, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, &$total);
				break;
				
			case 2: // Detalle por Cuenta
				$smarty->assign( "_title", "TITLE_TRAFF_F_REPORT_DETAIL_BY_ACCOUNT");
				$traff_detail = get_traff_f_by_account_detail( $user->userid, $ticketid, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, &$total); 
				break;

			case 3: // Detalle por Referencia de Llamada
				$smarty->assign( "_title", "TITLE_TRAFF_F_REPORT_DETAIL_BY_CALL_REFERENCE");
				$traff_detail = get_traff_f_by_reference_call_detail( $user->userid, $ticketid, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, &$total); 
				break;
				
			case 4: // Resumen por Centro de Costos
				$first_col = "DETAIL";
				$smarty->assign( "_title", "TITLE_TRAFF_F_REPORT_SUMMARY_BY_COST_CENTER");
				$traff_resume = get_traff_f_by_centro_costos_summary( $user->userid, $ticketid, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, &$total); 
				break;
				
			case 5: // Resumen por Referencia de llamadas
				$first_col = "DETAIL";
				$smarty->assign( "_title", "TITLE_TRAFF_F_REPORT_SUMMARY_BY_CALL_REFERENCE");
				$traff_resume = get_traff_f_by_call_reference_summary( $user->userid, $ticketid, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, &$total); 
				break;

			case 6: // Resumen por nº de origen llamada
				$first_col = "SOURCE";
				$smarty->assign( "_title", "TITLE_TRAFF_F_REPORT_SUMMARY_BY_ORIGIN_OF_CALL");
				$traff_resume = get_traff_f_by_source_summary( $user->userid, $ticketid, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, &$total);
				break;
				
			case 7: // Resumen por nº destino
				$first_col = "DIALED_NUMBER2";
				$smarty->assign( "_title", "TITLE_TRAFF_F_REPORT_SUMMARY_BY_DIALED_NUMBER");
				$traff_resume = get_traff_f_by_target_summary( $user->userid, $ticketid, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, &$total);;
				break;
				
			case 8: // Resumen por pa&iacute;s/localidad
				$first_col = "TARGET";
				$smarty->assign( "_title", "TITLE_TRAFF_F_REPORT_SUMMARY_BY_LOCATION");
				$traff_resume = get_traff_f_by_country_summary( $user->userid, $ticketid, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, &$total);;
				break;
				
			default: // Showing the form.
				// Por default se va a mostrar "traff_f.tpl".
				$user = new user( ca_session::get_userid( ));
				$smarty->assign( "traff_f", $user->get_traff_f( ));
				return true;
		}

		// -- Logic to complement the creation of the lists, the
		// -- principal entry form does not reach this section.

		// Setting the pagination into the template.
		$smarty->assign( "show_total", $is_last);
		SmartyPaginate::setTotal( $total);
		SmartyPaginate::assign( $smarty);

		// Converting the object into a ca_list.
		$ca_list = new ca_list( );
		if ( is_object( $traff_detail))
		{
			$ca_list->set_from_traff_detail( $traff_detail);
		}
		else if ( is_object( $traff_resume))
			$ca_list->set_from_traff_resume( $traff_resume, $first_col);
		else
		{
			$smarty->assign( "ca_list_empty", true);
		}
		
		
                $ca_list->paginate = true;
                $ca_list->paginate_element = "CALLS";
		$smarty->assign( "ca_list", $ca_list);
		if ( is_object( $traff_detail))
		{
			$smarty->assign( "ca_list_total", array( $traff_detail->total_duration, $traff_detail->total_price));
			$smarty->assign( "ca_list_total_count", 2);
		}
		else if ( is_object( $traff_resume))
		{
			$smarty->assign( "ca_list_total", array( $traff_resume->total_calls, $traff_resume->total_duration, $traff_resume->total_price));
			$smarty->assign( "ca_list_total_count", 3);
		}

		// Get the data of the ticket
		$ticket = $user->get_ticket( $ticketid);
		$smarty->assign( "ticket", $ticket);
		
		// Changing internally the template to show.
		basescr::setvar( "_template", "scr_traff_f_list.tpl");

		return true;
	}
}

?>

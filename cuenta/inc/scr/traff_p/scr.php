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
			basescr::setvar( "datefrom", varconn::REQUEST( "datefrom"));
			basescr::setvar( "dateto", varconn::REQUEST( "dateto"));
			basescr::setvar( "servicetype_pinid", varconn::REQUEST( "pinid"));
			basescr::setvar( "dialednumber", varconn::REQUEST( "dialednumber"));
		}

		return true;
	}
	
	function filter( $params)
	{
		if ( $params)
		{
			$type = filter::traff_p_type( basescr::getvar( "type"));
			$datefrom = filter::date( basescr::getvar( "datefrom"), true);
			$dateto = filter::date( basescr::getvar( "dateto"), true);
			$servicetype_pinid = filter::servicetype_pinid( basescr::getvar( "servicetype_pinid"));
			$dialednumber = filter::pinid( basescr::getvar( "dialednumber"));

			basescr::setvar( "type", $type);
			basescr::setvar( "datefrom", $datefrom);
			basescr::setvar( "dateto", $dateto);
			basescr::setvar( "servicetype_pinid", $servicetype_pinid);
			basescr::setvar( "dialednumber", $dialednumber);
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
		$datefrom = basescr::getvar( "datefrom");
		$dateto = basescr::getvar( "dateto");
		$servicetype_pinid = basescr::getvar( "servicetype_pinid");
		$dialednumber = basescr::getvar( "dialednumber");

        // Setting the dateto if it is empty.
        if ( !$dateto) $dateto = date( "Y/m/d");

		// Initializing the user data interface.
		$user = new user( ca_session::get_userid( ));

		// Initializing some pagination stuff.
		$total = 0;
		$is_last = false;

		// Spliting the servicetype y pinid.
		$servicetype = false;
		$pinid = false;
		if ( $servicetype_pinid)
		{
			list( $servicetype, $pinid) = explode( ' ', $servicetype_pinid);
		}
		
		// Setting the two objects to null.
		$traff_detail = null;
		$traff_resume = null;

		switch ( $type)
		{
			case 1: // ABC por Destino
				$smarty->assign( "_title", "TITLE_TRAFF_P_REPORT_ABC_BY_DEST");
				$traff_resume = get_traff_p_by_abc_target_summary( $user->userid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, $total); 
				break;
				
			case 2: // ABC por Numero Discado
				$smarty->assign( "_title", "TITLE_TRAFF_P_REPORT_ABC_BY_DIALED_NUMBER");
				$traff_resume = get_traff_p_by_abc_target_dialed_summary( $user->userid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, $total); 
				break;

			case 3: // ABC por Origen
				$smarty->assign( "_title", "TITLE_TRAFF_P_REPORT_ABC_BY_ORIGIN");
				$traff_resume = get_traff_p_by_abc_source_summary( $user->userid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, $total);
				break;
				
			case 4: // Detalle por Centro de Costos
				$smarty->assign( "_title", "TITLE_TRAFF_P_REPORT_DETAIL_BY_COST_CENTER");
				$traff_detail = get_traff_p_by_centro_costos_detail( $user->userid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, $total); 
				break;
				
			case 5: // Detalle por Linea/PIN
				$smarty->assign( "_title", "TITLE_TRAFF_P_REPORT_DETAIL_BY_LINE_PIN");
				$traff_detail = get_traff_p_by_line_pin_detail( $user->userid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, $total);
				break;

			case 6: // Detalle por Proyecto
				$smarty->assign( "_title", "TITLE_TRAFF_P_REPORT_DETAIL_BY_PROYECT");
				$traff_detail = get_traff_p_by_project_detail( $user->userid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, $total);
				break;
				
			case 7: // Resumen por Centro de Costos
				$smarty->assign( "_title", "TITLE_TRAFF_P_REPORT_SUMMARY_BY_COST_CENTER");
				$traff_resume = get_traff_p_by_centro_costos_summary( $user->userid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, $total);
				break;
				
			case 8: // Resumen por Referencia de Llamadas
				$smarty->assign( "_title", "TITLE_TRAFF_P_REPORT_SUMMARY_BY_CALL_REFERENCE");
				$traff_resume = get_traff_p_by_call_reference_summary( $user->userid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, $total);
				break;
				
			default: // Showing the form.
				// Por default se va a mostrar "traff_p.tpl".
				$user = new user( ca_session::get_userid( ));
				$smarty->assign( "traff_p", $user->get_traff_p( ));
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
			$ca_list->set_from_traff_resume( $traff_resume);
		else
		{
			$smarty->assign( "ca_list_empty", true);
		}
		
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
		
		// Changing internally the template to show.
		basescr::setvar( "_template", "scr_traff_p_list.tpl");

		return true;
	}
}

?>

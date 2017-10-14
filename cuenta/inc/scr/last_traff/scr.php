<?
// ESTE ARCHIVO ES UNA COPIA DE traff_nf/scr
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
			$type = filter::traff_nf_type( basescr::getvar( "type"));
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
			case 1: // Detalle por centro de costos
				$smarty->assign( "_title", "TITLE_TRAFF_NF_DETAIL_BY_CENTRO_DE_COSTO");
				$traff_detail = get_traff_nf_by_centro_costos_detail( $user->userid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, $total);
				break;
				
			case 2: // Detalle por Linea/PIN
				$smarty->assign( "_title", "TITLE_TRAFF_NF_DETAIL_BY_LINE_PIN");
				$traff_detail = get_traff_nf_by_line_pin_detail( $user->userid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, $total);
				break;

			case 3: // Detalle por Referencia de Llamada
				$smarty->assign( "_title", "TITLE_TRAFF_NF_DETAIL_BY_CALL_REFERENCE");
				$traff_detail = get_traff_nf_by_call_reference_detail( $user->userid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, $total);
				break;
				
			case 4: // Ultimas llamadas
				$smarty->assign( "_title", "TITLE_TRAFF_NF_DETAIL_BY_LAST_CALLS");
				$traff_detail = get_traff_nf_last_calls_detail( $user->userid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, $total);
				/*
				echo "<pre>";
				print_r($traff_detail);
				echo "</pre>";
				*/
				break;
				
			case 5: // Resumen por Centro de Costos
				$first_col = "DETAIL";
				$smarty->assign( "_title", "TITLE_TRAFF_NF_RESUME_BY_CENTRO_DE_COSTO");
				$traff_resume = get_traff_nf_by_centro_costos_summary( $user->userid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, $total);
				break;

			case 6: // Resumen por Linea/PIN
				$first_col = "LINE_PIN";
				$smarty->assign( "_title", "TITLE_TRAFF_NF_RESUME_BY_LINE_PIN");
				$traff_resume = get_traff_nf_by_line_pin_summary( $user->userid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, $total);
				break;
				
			case 7: // Resumen por Numero Discado
				$first_col = "DIALED_NUMBER2";
				$smarty->assign( "_title", "TITLE_TRAFF_NF_RESUME_BY_DIALED_NUMBER");
				$traff_resume = get_traff_nf_by_target_summary( $user->userid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, $total);
				break;
				
			case 8: // Resumen por Referencia de Llamada
				$first_col = "DETAIL";
				$smarty->assign( "_title", "TITLE_TRAFF_NF_RESUME_BY_CALL_REFERENCE");
				$traff_resume = get_traff_nf_by_call_reference_summary( $user->userid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, $total);
				break;
				
			case 9: // Resumen por nº de origen de llamada
				$first_col = "SOURCE";
				$smarty->assign( "_title", "TITLE_TRAFF_NF_RESUME_BY_ORIGIN_OF_CALL");
				$traff_resume = get_traff_nf_by_source_summary( $user->userid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, $total);
				break;
				
			case 10: // Resumen por pais/localidad
				$first_col = "TARGET";
				$smarty->assign( "_title", "TITLE_TRAFF_NF_RESUME_BY_LOCATION");
				$traff_resume = get_traff_nf_by_location_summary( $user->userid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, $total);
				break;
				
			default: // Showing the form.
				// Por default se va a mostrar "traff_nf.tpl".
				$user = new user( ca_session::get_userid( ));
				$smarty->assign( "traff_nf", $user->get_traff_nf( ));
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
//		basescr::setvar( "_template", "ca_list.tpl");
		basescr::setvar( "_template", "scr_traff_nf_list.tpl");
		
		return true;
	}
}

?>

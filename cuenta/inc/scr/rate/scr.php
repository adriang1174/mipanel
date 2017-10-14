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
			basescr::setvar( "t", varconn::REQUEST( "t"));
			basescr::setvar( "n", varconn::REQUEST( "n"));
			basescr::setvar( "target", varconn::REQUEST( "target"));
			basescr::setvar( "prefix", varconn::REQUEST( "prefix"));
		}

		return true;
	}
	
	function filter( $params)
	{
		if ( $params)
		{
			$t = filter::service_name( basescr::getvar( "t"));
			if ( $t === false)
				basescr::destroyvar( "t");
			else
				basescr::setvar( "t", $t);

			$n = filter::rate_number( basescr::getvar( "n"));
			if ( $n === false)
				basescr::destroyvar( "n");
			else
				basescr::setvar( "n", $n);

			$target = filter::pinid( basescr::getvar( "target"));
			if ( $target === false)
				basescr::destroyvar( "target");
			else
				basescr::setvar( "target", $target);

			$prefix = filter::pinid( basescr::getvar( "prefix"));
			if ( $prefix === false)
				basescr::destroyvar( "prefix");
			else
				basescr::setvar( "prefix", $prefix);
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
		global $dbh;


		$type = false;
		if ( !$params)
			return false;

		// Setting the type and number.
		$type = basescr::getvar( "t");
		$number = basescr::getvar( "n");


		if ( !$type || !$number)
			return false;
		
		
		$nombre_servicio = $dbh->getOne("SELECT servicio FROM servicios_conf WHERE id_servicio = (SELECT id_servicio FROM cuentas WHERE servicio = '". urldecode($type) ."' LIMIT 1)");

		$smarty->assign('nombre_servicio', $nombre_servicio);

		
		$smarty->assign( "rate_type", $type);
		$smarty->assign( "rate_number", $number);

		// filters.
		$target = basescr::getvar( "target");
		$prefix = basescr::getvar( "prefix");

		// We must pass only one.
		if ( $target && $prefix)
			$prefix = null;

		$smarty->assign( "target", $target);
		$smarty->assign( "prefix", $prefix);
			
		// Generating the list.
		$total = 0;
		$is_last = false;

		$rates = new rates( ca_session::get_userid( ));
		$rate_list = $rates->get_rates( $number, $type, $target, $prefix, SmartyPaginate::getCurrentIndex( ), SmartyPaginate::getLimit( ), $is_last, true, $total);
		SmartyPaginate::setTotal( $total);
		SmartyPaginate::assign( $smarty);

		/* Converting the list into a generic ca_list. */
		$ca_list_body = array( );
		foreach( $rate_list as $key => $rate)
		{
			$tmp = "";
            if ( $rate->vigency_from && $rate->vigency_to)
			{
				$tmp = lang( "VIGENCY_FORMAT");
				$tmp = str_replace( "[FROM]", $rate->vigency_from, $tmp);
				$tmp = str_replace( "[TO]", $rate->vigency_to, $tmp);
			}
            else if ( $rate->vigency_from)
                $tmp = $rate->vigency_from;

            $recharge = "";
            $recharge_backup = $rate->recharge;
            if ( $rate->recharge)
            {
                $recharge_parts = explode( " ", $rate->recharge, 2);
                if ( $recharge_parts[ 1] <= 0)
                    $rate->recharge = null;
            }
            
            if ( $rate->special)
                $recharge = $rate->recharge ? $rate->recharge : lang( "COLSULTE");
            else
                $recharge = $rate->recharge ? $rate->recharge : $recharge_backup;
                
            $ca_list_body[ ] = array(
                $rate->prefix,
                $rate->target,
                $rate->rate . ($rate->special ? ( " " . lang( "SPECIAL_RATE")) : ""),
                $recharge,
                $tmp
            );
		}
		$ca_list = new ca_list( array( "PREFIX", "TARGET", "RATE_PERMINUTE", "RECHARGE", "VIGENCY"), $ca_list_body);
		$ca_list->show_footer = false;
		$ca_list->paginate = true;
		$ca_list->paginate_element = "RATES";
		$smarty->assign( "ca_list", $ca_list);

		return true;
	}
}

?>

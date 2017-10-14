<?

class scr
{
    var $allow_print = false;
    var $allow_printall = false;
    var $allow_exportcsv = false;
    var $allow_email = false;
    var $allow_pay = false;
    
	function parameters( $params)
	{
		if ( $params)
		{
			basescr::setvar( "is_post", varconn::GET( "is_post"));
			basescr::setvar( "receive_report", varconn::POST( "receive_report"));
			basescr::setvar( "receive_alert", varconn::POST( "receive_alert"));
			basescr::setvar( "limit_minutes", varconn::POST( "limit_minutes"));
			basescr::setvar( "limit_price", varconn::POST( "limit_price"));
			basescr::setvar( "receive_image", varconn::POST( "receive_image"));
			basescr::setvar( "receive_detail", varconn::POST( "receive_detail"));
		}

		return true;
	}
	
	function filter( $params)
	{
		if ( $params)
		{
			basescr::setvar( "is_post", filter::flag( basescr::getvar( "is_post")));
			basescr::setvar( "receive_report", filter::flag( basescr::getvar( "receive_report")));
			basescr::setvar( "receive_alert", filter::flag( basescr::getvar( "receive_alert")));
			basescr::setvar( "limit_minutes", filter::limit_minutes( basescr::getvar( "limit_minutes")));
			basescr::setvar( "limit_price", filter::limit_price( basescr::getvar( "limit_price")));
			basescr::setvar( "receive_image", filter::flag( basescr::getvar( "receive_image")));
			basescr::setvar( "receive_detail", filter::flag( basescr::getvar( "receive_detail")));
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
		
		$is_post = basescr::getvar( "is_post");
		$receive_report = basescr::getvar( "receive_report");
		$receive_alert = basescr::getvar( "receive_alert");
		$limit_minutes = basescr::getvar( "limit_minutes");
		$limit_price = basescr::getvar( "limit_price");
		$receive_image = basescr::getvar( "receive_image");
		$receive_detail = basescr::getvar( "receive_detail");
		
		$ca_config = new ca_config( ca_session::get_userid( ));

		if ( $is_post)
		{
			// Set into the db.
			if ( !$ca_config->SetAll(
					$receive_report,
					$receive_alert,
					$limit_minutes,
					$limit_price,
					$receive_detail,
					$receive_image))
			{
				// Siempre parece ser un error aunque lo guarde bien, es por la version de las librerias
				//$smarty->assign( "error", true);
			}
		}

		// Getting the currency of the user.
		$ca_currency = new ca_currency( );
		$ca_currency->get_customer_currency( ca_session::get_userid( ));
		$smarty->assign( "currency", $ca_currency);

		// Get the data from the db.
		$all_config = $ca_config->GetAll( );
		$smarty->assign( "receive_report", $all_config[ "receive_report"] ? true : false);
		$smarty->assign( "receive_alert", $all_config[ "receive_alert"] ? true : false);
		$smarty->assign( "limit_minutes", ( int)$all_config[ "limit_minutes"]);
		$smarty->assign( "limit_price", (float)$all_config[ "limit_price"]);
		$smarty->assign( "receive_image", $all_config[ "receive_image"] ? true : false);
		$smarty->assign( "receive_detail", $all_config[ "receive_detail"] ? true : false);
		
		return true;
	}
}

?>

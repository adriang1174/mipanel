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
			basescr::setvar( "uemail", varconn::POST( "uemail"));
			basescr::setvar( "password", varconn::POST( "password"));
			basescr::setvar( "password_confirm", varconn::POST( "password_confirm"));
		}

		return true;
	}
	
	function filter( $params)
	{
		if ( $params)
		{
			basescr::setvar( "is_post", filter::flag( basescr::getvar( "is_post")));
			basescr::setvar( "uemail", filter::email( basescr::getvar( "uemail")));
			basescr::setvar( "password", filter::password( basescr::getvar( "password")));
			basescr::setvar( "password_confirm", filter::password( basescr::getvar( "password_confirm")));
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
		$uemail = basescr::getvar( "uemail");
		$password = basescr::getvar( "password");
		$password_confirm = basescr::getvar( "password_confirm");

		$res = true;
		$profile = new profile( ca_session::get_userid( ));

		if ( $is_post)
		{
			if ( !$uemail)
			{
				$smarty->assign( "error", lang( "DATMOD_INVALID_EMAIL"));
				$res = false;
			}

			if ( !$password)
			{
				$smarty->assign( "error", lang( "DATMOD_INVALID_PASSWORD"));
				$res = false;
			}
			
			if ( $res && $password != $password_confirm)
			{
				$smarty->assign( "error", lang( "DATMOD_WRONG_CONFIRMATION"));
				$res = false;
			}

			if ( $is_post)
			{
				// Set into the db.
				if ( !$profile->update( $uemail, $password))
					$smarty->assign( "error", lang( "DATMOD_ERROR"));
			}
		}

		// Get the data from the db.
		$smarty->assign( "uemail", $profile->get( ));
		
		return true;
	}
}

?>

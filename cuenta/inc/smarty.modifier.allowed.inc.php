<?

function smarty_modifier_allowed( $var)
{
    global $smarty;
    
	if ( !$var)
	{
		$smarty->trigger_error( "action: invalid action name.");
		return "0";
	}

    $scr = new scr( );
    if ( !is_object( $scr))
        return "0";

    $res = false;
    switch( $var)
    {
        case "print": $res = $scr->allow_print; break;
        case "printall": $res = $scr->allow_printall; break;
        case "exportcsv": $res = $scr->allow_exportcsv; break;
        case "email": $res = $scr->allow_email; break;
        case "pay": $res = $scr->allow_pay; break;
    }

    if ( $res)
        return "1";
    
    return "0";
}

?>

<?

function smarty_function_ipath( $params, &$smarty)
{
	if ( !isset( $params[ 'name']))
	{
		$smarty->trigger_error( "ipath: missing 'name' parameter");
		return;
	}
	$name = $params[ 'name'];

	$lang = false;
	if ( isset( $params[ 'lang']) && strcmp( $params[ 'lang'], '1') == 0)
	{
		$lang = language::sanitize_lang( ca_session::language_get( ));
		if ( !language::is_lang( $lang))
		{
			$smarty->trigger_error( "ipath: invalid language provided by the session, ignoring the lang=1 parameter.");
			$lang = false;
		}
    }

    $owner = false;
    if ( defined( "OWNER") && isset( $params[ 'owner']) && strcmp( $params[ 'owner'], '1') == 0)
    {
        $_ow = constant( "OWNER");
        if ( $_ow && strlen( $_ow) > 0)
            $owner = $_ow;
    }

    if ( $lang) $lang = ( $lang . "/");
    else $lang = "";

    if ( $owner) $owner = ( $owner . "/");
    else $owner = "";

    
    $url = "";
    if ( $owner)
        $url = PATH_OWNER . $owner . "img/" . $lang . $name;
    else
        $url = PATH_IMG . $lang . $name;

    $print = $smarty->get_template_vars( "print");
    if ( $print)
        $host = ( varconn::is_https( ) ? "https://" : "http://") . varconn::get_host( );
    else
        $host = "";
        
    return $host . $url;
}

?>

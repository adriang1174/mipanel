<?

function smarty_function_varcontents( $params, &$smarty)
{
	if ( !isset( $params[ 'var']))
	{
		$smarty->trigger_error( "varcontents: missing 'var' parameter");
		return;
	}
	$var = $params[ 'var'];
    $data = $smarty->get_template_vars( $var);
    
    if ( isset( $params[ 'escape']) && strcmp( $params[ 'escape'], "textarea") == 0)
        return htmlentities( $data, ENT_NOQUOTES, "UTF-8");
    else if ( isset( $params[ 'escape']))
        return htmlspecialchars( $data, ENT_COMPAT, "UTF-8");
    
    return $data;
}

?>

<?

function lang( $k)
{
	global $smarty;
	
	$params = array( 'k' => $k);
	return smarty_function_lang( $params, $smarty);
}

function smarty_function_lang( $params, &$smarty)
{
	if ( !isset( $params[ 'k']))
	{
		$smarty->trigger_error( "language: missing 'k' parameter");
		return;
	}
	
	$key = $params[ 'k'];

	$owner_const = DEF_LANGUAGE_OWNER_CONST_PREFIX . DEF_LANGUAGE_CONST_PREFIX . $key;
	$const = DEF_LANGUAGE_CONST_PREFIX . $key;

	if ( defined( $owner_const))
		return ( string)constant( $owner_const);
	else if ( defined( $const))
		return ( string)constant( $const);
	
	return ( string)"";
}

?>

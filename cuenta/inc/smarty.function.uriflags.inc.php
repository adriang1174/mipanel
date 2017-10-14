<?
require_once( 'uri.php');

function smarty_function_uriflags( $params, &$smarty)
{
	if ( !isset( $params[ 'flag']))
	{
		$smarty->trigger_error( "language: missing 'flag' parameter");
		return;
	}

    
	$flag = $params[ 'flag'];

	$uri = new uri( );
	$uri->set_flags( $flag);

	return ( string)$uri->uri;
}


?>

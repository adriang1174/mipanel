<?

function smarty_function_barcode( $params, &$smarty)
{
	if ( !isset( $params[ 'id']))
	{
		$smarty->trigger_error( "barcode: missing 'id' parameter");
		return;
	}
	$id = $params[ 'id'];

    return ( "bc.ca?id=" . urlencode( $id) . "&h=" . sha1( $id . "casec*911"));
}

?>

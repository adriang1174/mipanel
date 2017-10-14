<?

function smarty_function_ownerurl( $params, &$smarty)
{
    return ( ( varconn::is_https( ) ? "https://" : "http://") . varconn::get_host( ) . PATH_OWNER);
}

?>

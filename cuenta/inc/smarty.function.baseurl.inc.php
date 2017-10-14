<?

function smarty_function_baseurl( $params, &$smarty)
{
    return ( ( varconn::is_https( ) ? "https://" : "http://") . varconn::get_host( ) . ABSOLUTE_PATH);
}

?>

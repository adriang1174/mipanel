<?

require_once( INCLUDE_PATH . 'uri.php');

function smarty_function_currenthidden( $params, &$smarty)
{
    $uri = new uri( );

    $toclean = null;
    if ( isset( $params[ 'clean']) && strlen( $params[ 'clean']) > 0)
    {
        $toclean = explode( ",", $params[ 'clean']);
        $uri->exclude_params( $toclean);
    }
   
    if ( isset( $params[ 'flag']) && strlen( $params[ 'flag']) > 0)
    {
        $uri->set_flags( $params[ 'flag']);
    }
    
    return $uri->export_hidden( );
}

?>

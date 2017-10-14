<?

require_once( INCLUDE_PATH . 'uri.php');

function smarty_function_currenturi( $params, &$smarty)
{
	if($params['uri'] == null){
		$uri = new uri( );
	}else{
		$uri = new uri($params['uri']);
	}
    

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
    
    if ( isset( $params[ 'escape']) && strcmp( $params[ 'escape'], "1") == 0)
    {
        return htmlspecialchars( $uri->uri, ENT_QUOTES, DEF_CHARSET);
    }
    
    return $uri->uri;
}

?>

<?

function smarty_function_phpself( $params, &$smarty)
{
    return @$_SERVER[ 'PHP_SELF'];
}

?>

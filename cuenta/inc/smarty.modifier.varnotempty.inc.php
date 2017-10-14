<?

function smarty_modifier_varnotempty( $var)
{
    global $smarty;

    $data = $smarty->get_template_vars( $var);
    if ( $data)
        return $data;

    return false;
}

?>

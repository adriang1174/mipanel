<?
require_once( "ca_email.php");

class eml_confirm
{
    function _do_hash( $user_id, $user_name, $user_phone)
    {
        return sha1( DEF_EML_CONFIRM_SECRET . "," . $user_id . "," . $user_name . "," . $user_phone . "," . DEF_EML_CONFIRM_SECRET);
    }
    
    function hash_get_url( $user_id, $user_name = null, $user_phone = null)
    {
        $user_id = trim( ( string)$user_id);
        $user_name = trim( ( string)$user_name);
        $user_phone = trim( ( string)$user_phone);

        if ( strlen( $user_id) <= 0)
            return null;
        
        $url = ABSOLUTE_PATH . "activate.ca?";
        $url .= ( "u=" . urlencode( $user_id) . ( strlen( $user_name) > 0 ? ( "&n=" . urlencode( $user_name)) : "") . ( strlen( $user_phone) > 0 ? ( "&p=" . urlencode( $user_phone)) : "") . "&h=" . urlencode( eml_confirm::_do_hash( $user_id, $user_name, $user_phone)));

        return $url;
    }

    function hash_verify( &$user_id, &$user_name, &$user_phone)
    {
        $user_id = ( string)@$_GET[ 'u'];
        $user_name = ( string)@$_GET[ 'n'];
        $user_phone = ( string)@$_GET[ 'p'];
        $hash = ( string)@$_GET[ 'h'];

        if ( strcmp( $hash, eml_confirm::_do_hash( $user_id, $user_name, $user_phone)) == 0)
        {
            return true;
        }

        return false;
    }

    function send_email( $user_id, $user_email, $user_name, $user_phone)
    {
        global $smarty;
        $ca_email = new ca_email( CA_EMAIL_TEMPLATE_EML_CONFIRM_USER, ca_session::language_get( ));
        $ca_email->add_to( CA_EMAIL_RECIPIENT_TYPE_TO, new ca_email_recipient( DEF_HARDCODED_USER_EMAIL ? DEF_HARDCODED_USER_EMAIL : $user_email, DEF_HARDCODED_USER_EMAIL ? DEF_HARDCODED_USER_EMAIL : $user_email));
		
        $ca_email->set_tag_replacement( "[ADDR_SUPPORT]", owner::owner_name() . '<'.owner::addr_support( ) .'>');
        $ca_email->set_tag_replacement( "[USER_ID]", ca_session::get_userid( ));
		$ca_email->set_tag_replacement( "[USER_NAME]", $user_name);
        $ca_email->set_tag_replacement( "[USER_EMAIL]", $user_email);
        $ca_email->set_tag_replacement( "[EML_CONFIRM_LINK]", 'https://'.$_SERVER['SERVER_NAME'] . eml_confirm::hash_get_url( ca_session::get_userid( ), $user_name, $user_phone));
        $ca_email->set_tag_replacement( "[INFO_SUPPORT]", implode( '<br />', owner::info_support( )));
        $img_path = PATH_HTDOCS_FROM_INC . smarty_function_ipath( array( "name" => "bt-confirmar.gif", "owner" => 1, "lang" => 1), $smarty);
        $ca_email->add_html_image( $img_path);
		

        if ( $ca_email->send_pear( ))
            return true;

        return false;
    }
}

?>

<?
require_once( INCLUDE_PATH . "data/profile.php");
require_once( "eml_confirm.php");

define( 'CA_FORM_EMAIL_RESULT_ERROR_UNKNOW', CA_FORM_RESULT_USER +1);
define( 'CA_FORM_EMAIL_RESULT_OK', CA_FORM_RESULT_USER +2);

class ca_form_email extends ca_form
{
	var $is_available_accounts;
	
    function ca_form_email( )
    {
		parent::ca_form( true);
    }

    function set_fields() {
		$profile = new profile( ca_session::get_userid( ));
        $this->_fields = array( );
		$this->_fields['dummy'] = new ca_form_field('dummy', false, false, FILTER_TYPE_GENERIC, 
			lang("EML_ADMIN_TIP"), null, CA_FORM_FIELD_HTML_TYPE_STATICTEXT, null, 64);
		$this->_fields['user_name'] = new ca_form_field('user_name', false, false, FILTER_TYPE_NAME, 
			lang("FIELD_NAME_NAME"), null, CA_FORM_FIELD_HTML_TYPE_TEXT, null, 64);
		$this->_fields[ 'user_phone'] = new ca_form_field( 'user_phone', false, false, 
			FILTER_TYPE_GENERIC, lang("FIELD_NAME_TELEPHONE"), null, CA_FORM_FIELD_HTML_TYPE_TEXT, null, 64);
        $this->_fields[ 'user_email'] = new ca_form_field( 'user_email', true, false, 
			FILTER_TYPE_EMAIL, lang("FIELD_NAME_EMAIL"), null, CA_FORM_FIELD_HTML_TYPE_TEXT, null, 64, 
			null, $profile->get( false));
    }

	function set_buttons( )
	{
		$this->_buttons = array( );
		$this->_buttons[ ] = new ca_form_button( CA_FORM_BUTTON_TYPE_SUBMIT, "bt-aceptar.gif", true);
		$this->_buttons[ ] = new ca_form_button( CA_FORM_BUTTON_TYPE_REDIRECT, "bt-cancelar.gif", true, "index.ca");
	}
	
    function execute( )
    {
        $user_name = ( string)$this->_data[ 'user_name'];
        $user_phone = ( string)$this->_data[ 'user_phone'];
        $user_email = ( string)$this->_data[ 'user_email'];
        
        $profile = new profile( ca_session::get_userid( ));
        if ( !$profile->update( $user_email))
        {
            $this->header_error( lang( "EMAIL_SET_ERROR"));
        }
        else
        {
            // Sending the confirmation e-mail.
			if ( !eml_confirm::send_email( ca_session::get_userid( ), $user_email, $user_name, $user_phone))
            {
			    $this->header_error( lang( "EMAIL_SEND_ERROR"));
                return CA_FORM_RESULT_DISPLAY;
            }
            
            return CA_FORM_EMAIL_RESULT_OK;
        }
        
        // The form will be displayed again.
        return CA_FORM_RESULT_DISPLAY;
    }

    function display( )
    {
		// Nothing to do.
    }
}

?>

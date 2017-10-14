<?
require_once( INCLUDE_PATH . "data/ccenter.php");
require_once( INCLUDE_PATH . "data/profile.php");
require_once( "eml_confirm.php");

define( 'CA_FORM_EMAIL_PASSWORD_RESULT_ERROR_UNKNOW', CA_FORM_RESULT_USER +1);
define( 'CA_FORM_EMAIL_PASSWORD_RESULT_OK', CA_FORM_RESULT_USER +2);

class ca_form_email_password extends ca_form
{
    function ca_form_email_password( )
    {
		parent::ca_form( true);
    }

    function set_fields( )
    {
        $profile = new profile( ca_session::get_userid( ));
        $this->_fields = array( );
        $this->_fields[ 'user_email'] = new ca_form_field( 'user_email', true, false, 
			FILTER_TYPE_EMAIL, lang("FIELD_NAME_EMAIL"), null, CA_FORM_FIELD_HTML_TYPE_TEXT, 
			null, 64, null, $profile->get( false));
        $this->_fields[ 'user_passwd'] = new ca_form_field( 'user_passwd', false, false, 
			FILTER_TYPE_PASSWORD, lang("FIELD_NAME_PASS"), null, CA_FORM_FIELD_HTML_TYPE_PASSWORD, 
			null, 64, null, null);
        $this->_fields[ 'user_passwd_confirm'] = new ca_form_field( 'user_passwd_confirm', 
			false, false, FILTER_TYPE_PASSWORD, lang("FIELD_NAME_CONFIRM_PASS"), null, 
			CA_FORM_FIELD_HTML_TYPE_PASSWORD, null, 64, null, null);
    }

	function set_buttons( )
	{
		$this->_buttons = array( );
		$this->_buttons[ ] = new ca_form_button( CA_FORM_BUTTON_TYPE_SUBMIT, "bt-aceptar.gif", true);
		$this->_buttons[ ] = new ca_form_button( CA_FORM_BUTTON_TYPE_REDIRECT, "bt-cancelar.gif", true, "email_password.ca");
	}
	
    function execute( ) {
	
		$user_email = ( string)$this->_data[ 'user_email'];
        $user_passwd = ( string)$this->_data[ 'user_passwd'];
        $user_passwd_confirm = ( string)$this->_data[ 'user_passwd_confirm'];
        
        $profile = new profile( ca_session::get_userid( ));

        if (strlen($user_passwd) > 0) {
            if (strcmp($user_passwd, $user_passwd_confirm) != 0) {
                $this->header_error(lang( "DATMOD_WRONG_CONFIRMATION"));
                return CA_FORM_RESULT_DISPLAY;
            }
            else if ( !$profile->update( null, $user_passwd)) {
                $this->header_error( lang( "PASSWORD_SET_ERROR"));
                return CA_FORM_RESULT_DISPLAY;
            }
        }

        $eml_confirm = false;
        $actual_email = $profile->get_mail_admin( );
        if (strcmp($actual_email, $user_email) != 0) {
			
            if ( !$profile->update( $user_email)) {
                $this->header_error( lang( "EMAIL_SET_ERROR"));
                return CA_FORM_RESULT_DISPLAY;
            } else {
                // Sending the confirmation e-mail.
				$exitoEnvMailUsr = eml_confirm::send_email(
					ca_session::get_userid( ), $user_email, $user_name, $user_phone);
				if (!exitoEnvMailUsr) {
                    $this->header_error( lang( "EMAIL_SEND_ERROR"));
                    return CA_FORM_RESULT_DISPLAY;
                }
            }

            $eml_confirm = true;
        }
        
        // The form will be displayed again.
        $this->header_info( $eml_confirm ? lang( "PROFILE_DATA_SAVED_EML_CONFIRM") : lang( "PROFILE_DATA_SAVED"));
        return CA_FORM_RESULT_DISPLAY;
    }

    function display( ) {
		// Nothing to do.
    }
}

?>

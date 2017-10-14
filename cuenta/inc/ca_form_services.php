<?

define( 'CA_FORM_SERVICES_RESULT_ERROR_UNKNOW', CA_FORM_RESULT_USER +1);
define( 'CA_FORM_SERVICES_RESULT_OK', CA_FORM_RESULT_USER +2);

class ca_form_services extends ca_form
{
    var $_service_id = null;
    var $_params = null;
    
    function ca_form_services( $service_id, $params)
    {
        $this->_service_id = $service_id;
        $this->_params = $params;
		parent::ca_form( false);
    }

    function set_fields( )
    {
        $this->_fields = array( );
        $txt_d = 1;

        $this->_fields[ 'service'] = new ca_form_field( 'service', false, false, FILTER_TYPE_GENERIC, null, null, CA_FORM_FIELD_HTML_TYPE_HIDDEN, null, 60);
        $this->_fields[ 'service']->hidden_data = $this->_service_id;
        
        foreach( $this->_params as $param)
        {
		    $this->_fields[ 'data' . $txt_d] = new ca_form_field( 'data' . $txt_d, true, false, FILTER_TYPE_GENFORMTXT, $param[ 'parametro_titulo'], null, CA_FORM_FIELD_HTML_TYPE_TEXT, null, 60);
            $this->_fields[ 'data' . $txt_d]->comments = trim( $param[ 'parametro_texto']);
            $txt_d ++;
        }
    }

	function set_buttons( )
	{
		$this->_buttons = array( );
		$this->_buttons[ ] = new ca_form_button( CA_FORM_BUTTON_TYPE_SUBMIT, "bt-aceptar.gif", true);
		$this->_buttons[ ] = new ca_form_button( CA_FORM_BUTTON_TYPE_REDIRECT, "bt-cancelar.gif", true, "services.ca");
	}
	
    function execute( )
    {        
        $profile = new profile( ca_session::get_userid( ));
        $user_email = $profile->get( );

        $owner_id = ( int)owner_to_ownerid( ca_session::get( "owner"));
        
		$pic = new pic(ca_session::get_userid(), ca_session::get("mercado"));

        $service_name = null;
        $service_params = null;

        // Get the service name.
        $services = $pic->get_services( );
        foreach( $services as $service)
        {
            if ( ( int)$service[ 'id_servicio'] == ( int)$this->_service_id)
            {
                $service_name = $service[ 'servicio'];
                break;
            }
        }
        // Set the params string.
        $service_params = "";
        
        foreach( $this->_fields as $name => $field)
        {
            if ( preg_match( "/^data[0-9]+$/", $name))
                $service_params .= "<b>" . $field->title . "</b>: " . $this->_data[ $name] . "<br />";
        }

        // Send the e-mail to the administrators.
       $ca_email = new ca_email( CA_EMAIL_TEMPLATE_SERVICE_ADD, ca_session::language_get( ));

		if($owner_id == 7){ // POR EL MOMENTO LOS PEDIDOS DE ALTA DE UN SERVICIO DE T2 SE MANDAN A ASISTENCIA
			$ca_email->add_to( CA_EMAIL_RECIPIENT_TYPE_TO, new ca_email_recipient( 'asistencia@telephone2.com', 'asistencia@telephone2.com'));
		}else{
			$ca_email->add_to( CA_EMAIL_RECIPIENT_TYPE_TO, new ca_email_recipient( DEF_SERVICES_EMAIL, DEF_SERVICES_EMAIL));
		}
		
		//$ca_email->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, new ca_email_recipient("francisco@promaker.com.ar", "francisco@promaker.com.ar"));
		
        $ca_email->set_tag_replacement( "[USER_EMAIL]", $user_email);
        $ca_email->set_tag_replacement( "[USER_ID]", ca_session::get_userid( ));
        $ca_email->set_tag_replacement( "[SERVICE_NAME]", $service_name);
        $ca_email->set_tag_replacement( "[SERVICE_PARAMS]", $service_params);
        
        if ( !$ca_email->send_pear( ))
        {
            $this->header_error( lang( "EMAIL_SEND_ERROR_2"));
            return CA_FORM_RESULT_DISPLAY;
        }

        // Send the e-mail to the user.
        $ca_email = new ca_email( CA_EMAIL_TEMPLATE_SERVICE_ADD_USER, ca_session::language_get( ));
        $ca_email->add_to( CA_EMAIL_RECIPIENT_TYPE_TO, new ca_email_recipient( DEF_HARDCODED_USER_EMAIL ? DEF_HARDCODED_USER_EMAIL : $user_email, DEF_HARDCODED_USER_EMAIL ? DEF_HARDCODED_USER_EMAIL : $user_email));
        $ca_email->set_tag_replacement( "[ADDR_SUPPORT]", owner::addr_support( ));
        $ca_email->set_tag_replacement( "[USER_ID]", ca_session::get_userid( ));
		
		$user = new user( ca_session::get_userid( ));
        $titular = $user->get_titular( );$ca_email->set_tag_replacement( "[CODIGO]", ca_session::get_userid( ));		
		
		$ca_email->set_tag_replacement( "[TITULAR]", $titular);
        $ca_email->set_tag_replacement( "[SERVICE_NAME]", $service_name);
        $ca_email->set_tag_replacement( "[SERVICE_PARAMS]", $service_params);
        $ca_email->set_tag_replacement( "[INFO_SUPPORT]", implode( '<br />', owner::info_support( )));
        
        $ca_email->send_pear( ); // No importa si no se puede enviar.
        
        // The form will be displayed again.
        return CA_FORM_SERVICES_RESULT_OK;
    }

    function display( )
    {
		// Nothing to do.
    }
}

?>

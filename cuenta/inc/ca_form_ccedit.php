<?

define( 'CA_FORM_CCEDIT_RESULT_ERROR_UNKNOW', CA_FORM_RESULT_USER +1);
define( 'CA_FORM_CCEDIT_RESULT_OK', CA_FORM_RESULT_USER +2);

class ca_form_ccedit extends ca_form
{
    function ca_form_ccedit( )
    {
        parent::ca_form( true);
    }

    function set_fields( )
    {
        $this->_fields = array( );

		$_line = basescr::getvar( "line");
		$line = ccenter_line::create_from_str( $_line);
		if ( !$line)
		{
			$line = ca_session::get( "ccedit_line");
			if ( !$line)
				return false;
		}
		
		$ccenter = new ccenter( ca_session::get_userid( ));
		$name = $ccenter->get_name( $line);
		if ( !$name)
			return false;

		ca_session::set( "ccedit_line", $line);
		$this->_fields[ 'line'] = new ca_form_field( 'line', true, false, FILTER_TYPE_SERVICETYPE_PINID, "Cuenta", null, CA_FORM_FIELD_HTML_TYPE_TEXT, null, null, null, $line->type . $line->number, true);
		$this->_fields[ 'ccenter'] = new ca_form_field( 'ccenter', true, false, FILTER_TYPE_NAME, "Centro de costos", null, CA_FORM_FIELD_HTML_TYPE_TEXT, null, 20, null, $name, false);
    }

	function set_buttons( )
	{
		$this->_buttons = array( );
		$this->_buttons[ ] = new ca_form_button( CA_FORM_BUTTON_TYPE_SUBMIT, "bt-aceptar.gif", true);
		$this->_buttons[ ] = new ca_form_button( CA_FORM_BUTTON_TYPE_REDIRECT, "bt-cancelar.gif", true, "cclist.ca");
	}
	
    function execute( )
    {
		$line = ca_session::get( "ccedit_line");
		$name = $this->_data[ 'ccenter'];

		$err = false;
		if ( !$line || !$name)
			$err = true;

		if ( !$err)
		{
			$ccenter = new ccenter( ca_session::get_userid( ));
			if ( !$ccenter->update( $line, $name))
				$err = true;
		}

		if ( $err)
		{
			$this->header_error( lang( "CCEDIT_ERROR"));
			// The form will be displayed again.
			return CA_FORM_RESULT_DISPLAY;
		}
		
		ca_session::destroy( "ccedit_line");
		return CA_FORM_CCEDIT_RESULT_OK;
    }

    function display( )
    {
		// Nothing to do.
    }
}

?>

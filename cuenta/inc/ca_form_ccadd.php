<?
require_once( INCLUDE_PATH . 'data/ccenter.php');

define( 'CA_FORM_CCADD_RESULT_ERROR_UNKNOW', CA_FORM_RESULT_USER +1);
define( 'CA_FORM_CCADD_RESULT_OK', CA_FORM_RESULT_USER +2);

class ca_form_ccadd extends ca_form
{
	var $is_available_accounts;
	
    function ca_form_ccadd( )
    {
		$accounts = $this->_get_accounts( );
		if ( !is_array( $accounts) || count( $accounts) <= 0)
			$this->is_available_accounts = false;
		else
			$this->is_available_accounts = true;
        
		parent::ca_form( $this->is_available_accounts ? false : true);
    }

	function _get_accounts( )
	{
		$stock = array( );
		$ccenter = new ccenter( ca_session::get_userid( ));
		$_accounts = $ccenter->get_free_lines( );

		foreach( $_accounts as $account)
		{
			$tmp = $account->type . " " . $account->number;
			$stock[ ] = new ca_form_field_stock( $tmp, $tmp);
		}

		return $stock;
	}
	
    function set_fields( )
    {
        $this->_fields = array( );

		if ( $this->is_available_accounts)
			$this->_fields[ 'pinid'] = new ca_form_field( 'pind', true, false, FILTER_TYPE_SERVICETYPE_PINID, lang('ACCOUNT'), null, CA_FORM_FIELD_HTML_TYPE_SELECT, $this->_get_accounts( ), null, null);
		else
			$this->_fields[ 'pinid'] = new ca_form_field( 'pind', true, false, FILTER_TYPE_SERVICETYPE_PINID, lang('ACCOUNT'), null, CA_FORM_FIELD_HTML_TYPE_TEXT, null, null, null, lang( "CCADD_NOFREELINES"), true);
			
		$this->_fields[ 'costcenter'] = new ca_form_field( 'costcenter', true, false, FILTER_TYPE_NAME, lang('TITLE_CCENTER'), null, CA_FORM_FIELD_HTML_TYPE_TEXT, null, 20);
    }

	function set_buttons( )
	{
		$this->_buttons = array( );
		if ( $this->is_available_accounts)
			$this->_buttons[ ] = new ca_form_button( CA_FORM_BUTTON_TYPE_SUBMIT, "bt-aceptar.gif", true);
		$this->_buttons[ ] = new ca_form_button( CA_FORM_BUTTON_TYPE_REDIRECT, "bt-cancelar.gif", true, "cclist.ca");
	}
	
    function execute( )
    {
		if ( !$this->is_available_accounts)
			clientcontrol::redirect( "cclist.php");
		
		$ccenter = new ccenter( ca_session::get_userid( ));
		$line = ccenter_line::create_from_str( $this->_data[ 'pinid']);

		if ( $ccenter->create( new ccenter_item( $this->_data[ 'costcenter'], $line)))
			return CA_FORM_CCADD_RESULT_OK;
		else
			$this->header_error( TPL_CCADD_ERROR);

        // The form will be displayed again.
        return CA_FORM_RESULT_DISPLAY;
    }

    function display( )
    {
		// Nothing to do.
    }
}

?>

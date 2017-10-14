<?
require_once( INCLUDE_PATH . 'data/rcall.php');

define( 'CA_FORM_RCALLADD_RESULT_ERROR_UNKNOW', CA_FORM_RESULT_USER +1);
define( 'CA_FORM_RCALLADD_RESULT_OK', CA_FORM_RESULT_USER +2);

class ca_form_rcalladd extends ca_form
{
	var $is_available_accounts;
	
    function ca_form_rcalladd( )
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
		$rcall = new rcall( ca_session::get_userid( ));
		$_accounts = $rcall->get_free_dest( );

		foreach( $_accounts as $account)
		{
			if ( is_array( $account) && count( $account) > 0)
			{
				$account = $account[ 0];
				$stock[ ] = new ca_form_field_stock( $account, $account);
			}
		}

		return $stock;
	}
	
    function set_fields( )
    {
        $this->_fields = array( );

		if ( $this->is_available_accounts)
			$this->_fields[ 'dest'] = new ca_form_field( 'dest', true, false, FILTER_TYPE_PINID, lang("TARGET"), null, CA_FORM_FIELD_HTML_TYPE_SELECT, $this->_get_accounts( ), null, 40);
		else
			$this->_fields[ 'pinid'] = new ca_form_field( 'dest', true, false, FILTER_TYPE_PINID, lang("TARGET"), null, CA_FORM_FIELD_HTML_TYPE_TEXT, null, 40, null, lang( "CCADD_NOFREELINES"), true);

		$this->_fields[ 'project'] = new ca_form_field( 'project', true, false, FILTER_TYPE_NAME, lang("PROJECT"), null, CA_FORM_FIELD_HTML_TYPE_TEXT, null, 40);
		$this->_fields[ 'first_name'] = new ca_form_field( 'first_name', false, false, FILTER_TYPE_NAME, lang("FIRST_NAME"), null, CA_FORM_FIELD_HTML_TYPE_TEXT, null, 40);
		$this->_fields[ 'last_name'] = new ca_form_field( 'last_name', false, false, FILTER_TYPE_NAME, lang("LAST_NAME"), null, CA_FORM_FIELD_HTML_TYPE_TEXT, null, 40);
		$this->_fields[ 'company'] = new ca_form_field( 'company', false, false, FILTER_TYPE_NAME, lang("COMPANY"), null, CA_FORM_FIELD_HTML_TYPE_TEXT, null, 40);
		$this->_fields[ 'title'] = new ca_form_field( 'title', false, false, FILTER_TYPE_NAME, lang("COMPANY_TITLE"), null, CA_FORM_FIELD_HTML_TYPE_TEXT, null, 40);
		$this->_fields[ 'email'] = new ca_form_field( 'email', false, false, FILTER_TYPE_EMAIL, lang("SERV_LINIP_FLD1"), null, CA_FORM_FIELD_HTML_TYPE_TEXT, null, 40);
    }

	function set_buttons( )
	{
		$this->_buttons = array( );
		if ( $this->is_available_accounts)
			$this->_buttons[ ] = new ca_form_button( CA_FORM_BUTTON_TYPE_SUBMIT, "bt-aceptar.gif", true);
		$this->_buttons[ ] = new ca_form_button( CA_FORM_BUTTON_TYPE_REDIRECT, "bt-cancelar.gif", true, "rcalllist.ca");
	}
	
    function execute( )
    {
		if ( !$this->is_available_accounts)
			clientcontrol::redirect( "rcalllist.php");

		$rcall = new rcall( ca_session::get_userid( ));
		$rcall_item = new rcall_item( $this->_data[ 'dest'], $this->_data[ 'project'], $this->_data[ 'first_name'], $this->_data[ 'last_name'], $this->_data[ 'company'], $this->_data[ 'title'], $this->_data[ 'email']);
		
		if ( $rcall->create( $rcall_item))
		{
			return CA_FORM_RCALLADD_RESULT_OK;
		}
		else
			$this->header_error( TPL_RCALLADD_ERROR);

        // The form will be displayed again.
        return CA_FORM_RESULT_DISPLAY;
    }

    function display( )
    {
		// Nothing to do.
    }
}

?>

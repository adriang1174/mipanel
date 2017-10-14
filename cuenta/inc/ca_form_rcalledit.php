<?
require_once( INCLUDE_PATH . 'data/rcall.php');

define( 'CA_FORM_RCALLEDIT_RESULT_ERROR_UNKNOW', CA_FORM_RESULT_USER +1);
define( 'CA_FORM_RCALLEDIT_RESULT_OK', CA_FORM_RESULT_USER +2);

class ca_form_rcalledit extends ca_form
{
    function ca_form_rcalledit( )
    {
        parent::ca_form( true);
    }

    function set_fields( )
    {
        $this->_fields = array( );

		$dest = filter::pinid( basescr::getvar( "dest"));
		if ( !$dest)
		{
			$dest = ca_session::get( "rcalledit_dest");
			if ( !$dest)
				return false;
		}
		
		$rcall = new rcall( ca_session::get_userid( ));
		$project = $rcall->get_project( $dest);
		if ( !$project || !is_object( $project))
			return false;

		ca_session::set( "rcalledit_dest", $dest);
		$this->_fields[ 'dest'] = new ca_form_field( 'dest', true, false, FILTER_TYPE_PINID, "Destino", null, CA_FORM_FIELD_HTML_TYPE_TEXT, null, null, null, $project->dest, true);
		$this->_fields[ 'project'] = new ca_form_field( 'project', true, false, FILTER_TYPE_NAME, "Proyecto", null, CA_FORM_FIELD_HTML_TYPE_TEXT, null, 20, null, $project->project);
		$this->_fields[ 'first_name'] = new ca_form_field( 'first_name', false, false, FILTER_TYPE_NAME, "Nombre", null, CA_FORM_FIELD_HTML_TYPE_TEXT, null, 22, null, $project->name);
		$this->_fields[ 'last_name'] = new ca_form_field( 'last_name', false, false, FILTER_TYPE_NAME, "Apellido", null, CA_FORM_FIELD_HTML_TYPE_TEXT, null, 22, null, $project->lastname);
		$this->_fields[ 'company'] = new ca_form_field( 'company', false, false, FILTER_TYPE_NAME, "Empresa", null, CA_FORM_FIELD_HTML_TYPE_TEXT, null, 30, null, $project->company);
		$this->_fields[ 'title'] = new ca_form_field( 'title', false, false, FILTER_TYPE_NAME, "Cargo", null, CA_FORM_FIELD_HTML_TYPE_TEXT, null, 22, null, $project->title);
		$this->_fields[ 'email'] = new ca_form_field( 'email', false, false, FILTER_TYPE_EMAIL, "E-Mail", null, CA_FORM_FIELD_HTML_TYPE_TEXT, null, 40, null, $project->email);
    }

	function set_buttons( )
	{
		$this->_buttons = array( );
		$this->_buttons[ ] = new ca_form_button( CA_FORM_BUTTON_TYPE_SUBMIT, "bt-aceptar.gif", true);
		$this->_buttons[ ] = new ca_form_button( CA_FORM_BUTTON_TYPE_REDIRECT, "bt-cancelar.gif", true, "rcalllist.ca");
	}
	
    function execute( )
    {
		$dest = ca_session::get( "rcalledit_dest");
		$project = $this->_data[ 'project'];

		$err = false;
		if ( !$dest || !$project)
			$err = true;

		if ( !$err)
		{
			$rcall = new rcall( ca_session::get_userid( ));
			$rcall_item = new rcall_item( $dest, $this->_data[ 'project'], $this->_data[ 'first_name'], $this->_data[ 'last_name'], $this->_data[ 'company'], $this->_data[ 'title'], $this->_data[ 'email']);
			if ( !$rcall->update( $dest, $rcall_item))
				$err = true;
		}

		if ( $err)
		{
			$this->header_error( lang( "RCALLEDIT_ERROR"));
			// The form will be displayed again.
			return CA_FORM_RESULT_DISPLAY;
		}
		
		ca_session::destroy( "rcalledit_dest");
		return CA_FORM_RCALLEDIT_RESULT_OK;
    }

    function display( )
    {
		// Nothing to do.
    }
}

?>

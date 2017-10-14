<?
require_once( 'varconn.php');
require_once( 'filter.php');

define( 'CA_FORM_RESULT_DISPLAY', 1);
define( 'CA_FORM_RESULT_USER', 100);
require_once( 'ca_form_field.php');
require_once( 'ca_form_button.php');
require_once( 'ca_form_ccadd.php');
require_once( 'ca_form_ccedit.php');
require_once( 'ca_form_rcalladd.php');
require_once( 'ca_form_rcalledit.php');
require_once( 'ca_form_email.php');
require_once( 'ca_form_email_password.php');
require_once( 'ca_form_services.php');


class ca_form
{
    var $_isvalid;
    var $_ispost;
    var $_fields;
    var $_buttons;
    var $_data;
    var $_use_default_data;

    function ca_form( $use_default_data = false)
    {
        $this->_ispost = false;
        $this->_isvalid = true;
        $this->_data = array( );
        $this->_use_default_data = $use_default_data;
    }
    
    function init( )
    {
        global $smarty;

        if ( !$this->_isvalid)
            return false;
        
        // Determining if it is a POST.
        $is_post = false;

        if ( filter::flag( varconn::GET( "post")))
            $is_post = true;

        if ( $is_post)
			$this->_ispost = true;

        return true;
    }

    function _set_fields( )
    {
        $this->set_fields( );
//        $this->_fields[ 'sepx'] = new ca_form_field( 'sepx', false, false, null, "", null, CA_FORM_FIELD_HTML_TYPE_SEPARATOR, null, 0, null, null);
    }
    
    function set_fields( ) { }

    function _set_buttons( )
    {
        $this->set_buttons( );
        if ( !$this->_buttons || !is_array( $this->_buttons) || count( $this->_buttons) <= 0)
        {
            $this->_buttons = array( );
            $this->_buttons[ ] = new ca_form_button( CA_FORM_BUTTON_TYPE_SUBMIT, "bt-aceptar.gif", true);
            $this->_buttons[ ] = new ca_form_button( CA_FORM_BUTTON_TYPE_REDIRECT, "bt-cancelar.gif", true, "index.ca");
        }
    }

    function set_buttons( ) { }
    
    function retrieve_data( )
    {
        $this->_data = array( );
        foreach( $this->_fields as $field => $field_object)
        {
            if ( $field_object->htmltype != CA_FORM_FIELD_HTML_TYPE_SEPARATOR)
            {
                if ( $field_object->isreadonly)
                    $this->_data[ $field] = $field_object->default_data;
                else
				{
                    $this->_data[ $field] = false;
					$tmp = varconn::POST( $field);
					if ( $field_object->type)
					{
						$cmd = ( "$" . "this->_data[ " . "$" . "field] = filter::" . $field_object->type . "( " . "$" . "tmp);");
						eval( $cmd);
					}
				}
            }
        }

        return true;
    }
    
    function check_for_errors( )
    {
        $errors = 0;
        foreach( $this->_fields as $field => $field_object)
        {
            if ( $field_object->isrequired && $field_object->htmltype != CA_FORM_FIELD_HTML_TYPE_SEPARATOR)
            {
                if ( !$this->_data[ $field])
                {
                    $field_object->set_error( );
                    $errors ++;
                }
            }
        }

        if ( $errors)
            return false;

        return true;
    }

    function execute( ) { }

    function assign( )
    {
        global $smarty;

        foreach( $this->_fields as $field => $field_object)
        {
            if ( $field_object->htmltype != CA_FORM_FIELD_HTML_TYPE_SEPARATOR)
            {
                if ( $this->_use_default_data)
                {
                    // We should use the data provided in the field_object.
                    $smarty->assign( $field, $field_object->default_data);
                }
                else if ( !$field_object->mustcleaned && array_key_exists( $field, $this->_data))
                {
                    // We have data passed by post.
                    $smarty->assign( $field, $this->_data[ $field]);
                }
                else
                {
                    // We have no data.
                    $smarty->assign( $field, null);
                }
            }
        }

        $smarty->assign( "ca_form_fields", $this->_fields);
        $smarty->assign( "ca_form_buttons", $this->_buttons);
    }

    function header_error( $strerror)
    {
        global $smarty;
        $smarty->assign( "ca_form_error", $strerror);
    }

    function header_info( $strinfo)
    {
        global $smarty;
        $smarty->assign( "ca_form_info", $strinfo);
    }
    
    function display( ) { }

    function do_magic( )
    {
	
        // Is the default action, implies that the form should be showed.
        $res = CA_FORM_RESULT_DISPLAY;
        
        // Initializing some form stuff.
        $this->init( );
        
        // Set the field list and get the data from the storage.
        $this->_set_fields( );

        // Set the buttons/actions.
        $this->_set_buttons( );
        
        if ( $this->_ispost)
        {
            // Get and filter the data posted by the user.
            $this->retrieve_data( );

            // Check for errors in the filter step (it also sets the needed smarty variables).
            if ( $this->check_for_errors( ))
            {
                // There is no errors, executing the form action, sets it into the storage.
                $res = $this->execute( );
                if ( $res != CA_FORM_RESULT_DISPLAY)
                {
                    // The execute has been completed the operation or has been ocurred an error.
                    return $res;
                }

                // implies that the form should be showed again.
            }

            // Set the field list and get the data from the storage.
            $this->_set_fields( );
        }
        
        // Assigning the smarty main values.
        $this->assign( );
        
        // Displaying the form.
        $this->display( );

        // This result is the result of the execute.
        return $res;
    }
}

?>

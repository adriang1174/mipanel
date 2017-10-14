<?
require_once(INCLUDE_PATH . "db.php");

class profile
{
	var $_userid;
    var $_db;

    /**
     * profile - The class constructor.
     *
     * @param   $userid     string  The userid that will be used by the profile methods.
     * @return	void
     * @access	public
     */
	function profile( $userid)
	{
        db::init( );
		$this->_userid = strtoupper( $userid);
	}
	
	function fixLoginWithCuit(){
		// Me fijo si ingreso cliente_id o cuit
		$query_mail_admin = "select cliente_id from clientes where cliente_id = '" . $this->_userid . "'";
        $cliente_id = ( string)db::get_row_as_scalar($query_mail_admin);
		
		if(trim($cliente_id) == ""){ // puso un cuit?
			$query_mail_admin = "select cliente_id from clientes where cuit = '" . $this->_userid . "'";
			$clientes = db::get_rows_as_array_of_hashes($query_mail_admin);

			if(count($clientes) == 1){ // Esta ok, hay un cliente con ese cuit
				$this->_userid = strtoupper( $clientes[0]["cliente_id"]);
				return true;
			}else if(count($clientes) > 1){ // Hay mas de uno, tengo que decirle que ponga el codigo de cliente
				return false;
			}else{ // no existe
				return false;
			}
		}else{
			return true;
		}
		
	}

    function is_valid_user( )
    {
        $query_mail_admin = "select cliente_id from clientes where cliente_id = '" . $this->_userid . "'";
        $cliente_id = ( string)db::get_row_as_scalar($query_mail_admin);
        if ( strcmp( $cliente_id, $this->_userid) == 0)
            return true;
		
        return false;
    }
    
    /**
     * get_mail_admin - Get the user e-mail from the mail_admin column only.
     *
     * @return	mixed				Upon successful completion the e-mail is returned. Otherwise, null is returned.
     * @access	public
     */
	function get_mail_admin( )
	{
        $query_mail_admin = "select mail_admin from clientes where cliente_id = '" . $this->_userid . "'";
        $email_admin = ( string)db::get_row_as_scalar($query_mail_admin);
        if ( strlen( $email_admin) <= 0)
            $email_admin = null;

        return $email_admin;
    }
 
    /**
	 * get - Get the user e-mail. If the new e-mail, (mail_admin column), if set and was previously verified
     * we return it. Otherwhise we return the old e-mail (email column).
	 *
     * @param   $should_be_verified If true, we only return the new e-mail if it was previously verified. Otherwhise, we
     *                              return it independently of it's "verified state".
	 * @return	mixed				Upon successful completion the e-mail is returned. Otherwise, null is returned.
	 * @access	public
	 */
	function get( $should_be_verified = true)
	{
        $query = "select email from clientes where cliente_id = '" . $this->_userid . "'";
        $query_mail_admin = "select mail_admin from clientes where cliente_id = '" . $this->_userid . "'" . ( $should_be_verified ? " and mail_admin_verif = 1" : "");

        $email_admin = ( string)db::get_row_as_scalar($query_mail_admin);
        if (strlen($email_admin) <= 0) {
            $email_admin = null;
        }
        
        if(strlen($email_admin))
        {
            // We return the NEW e-mail.
            return $email_admin;
        }
    
        // We return the OLD e-mail.
        $email = ( string)db::get_row_as_scalar($query);
        if ( strlen( $email) <= 0)
            $email = null;
            
        return $email;
	}

	//version modificada del get, para admitir el caso de que no haya mail sin
	//devolver la direccion de correo de administracion
	function get2() {
        
        $query_mail_admin = "select mail_admin from clientes where cliente_id = '" 
        	. $this->_userid . "';";

        $email_admin = ( string)db::get_row_as_scalar($query_mail_admin);
        if (strlen($email_admin) <= 0) {
            $email_admin = null;
        }
        return $email_admin;
        
	}
	
    /**
	 * get_password - Get the user password.
	 *
	 * @return	mixed				Upon successful completion the password is returned. Otherwise, null is returned.
	 * @access	public
	 */
    function get_password( )
    {
        $query = "select password from clientes where cliente_id = '" . $this->_userid . "'";
        $password = ( string)db::get_row_as_scalar($query);
        if ( strlen( $password) > 0)
            return $password;

        return null;
    }

    /**
	 * update - Update the profile data of the user. The email or the password can be passed
     * independently to this function. The fields are updated ONLY if there is a change.
	 *
     * @param   string  $email      The new user e-mail.
     * @param   string  $password   The new user password.
	 * @return	bool				Upon successful completion true is returned. Otherwise, false is returned.
	 * @access	public
	 */
	function update($email = null, $password = null) {
       
        
        $email = (string) $email;
        $password = (string)$password;
        $actual_password = (string)$this->get_password( );
        $actual_email = (string)$this->get_mail_admin( );
        
        if( strlen( $password) > 0 && strcmp( $actual_password, $password) != 0)
        {
            // updating password.
            $query = "update clientes set password = '$password' where cliente_id = '$this->_userid'";

            if ( !db::DoIt( $query))
                return false;
        }

		
        if (strcmp($actual_email, $email) != 0) {
            
        	$query = "update clientes set mail_admin = '" . $email 
        		. "', mail_admin_verif = 0  where cliente_id = '$this->_userid'";
        		
        	if ( !db::DoIt( $query)) return false;

        }
        
		return true;
	}
	
	/**
	 */
	function updateEmail($email = null) {
        
        $email = (string) $email;
        $actual_email = (string)$this->get_mail_admin();
        
        if (strcmp($actual_email, $email) != 0) {
            
        	$query = "update clientes set mail_admin = '" . $email 
        		. "', mail_admin_verif = 0  where cliente_id = '$this->_userid'";
        	

        	if ( !db::DoIt( $query)) return false;

        }
		return true;
	}
	
	/**
	 */
	function updatePassword($password = null) {
        
        $password = (string)$password;
        $actual_password = (string)$this->get_password( );
        
        if( strlen( $password) > 0 && strcmp( $actual_password, $password) != 0)
        {
            
	    // updating password.
	    $con = mssql_connect("SMS", "estadisticas", "estadisticas");
	    mssql_select_db("cuentaalternativa", $con);
            $query = "update webuserypass set pass = '".$password."' where ca_cnro = '" . $this->_userid . "'";
            mssql_query($query, $con);
            $query = "update clientes set password = '$password' where cliente_id = '$this->_userid'";
        if ( !db::DoIt( $query))
                return false;
        }
        
		return true;
	}

    /**
	 * set_mail_verif - Set the current e-mail of this user as veryfied.
	 *
	 * @return	bool				Upon successful completion true is returned. Otherwise, false is returned.
	 * @access	public
	 */
    function set_mail_verif( )
    {
        $query = "update clientes set mail_admin_verif = 1  where cliente_id = '$this->_userid'";
        if ( db::DoIt( $query))
            return true;

        return false;
    }

    /**
	 * is_mail_verif - Get the current status of the veryfied state of the e-mail of this user.
	 *
	 * @return	bool				If the e-mail was veryfied true is returned. Otherwise, false is returned.
	 * @access	public
	 */
    function is_mail_verif( )
    {
    

        $query = "select mail_admin_verif from clientes where cliente_id = '" . $this->_userid . "'";
        

        $res = db::get_row_as_scalar( $query);
        
        if($res){
            return true;
        }else{
            $query2 = "select mail_admin_verif from clientes where lower(mail_admin) = '" . strtolower($this->_userid) . "'";

            $res2 = db::get_row_as_scalar( $query2);

            
            if($res2){
                return true;
            }else{
                return false;
            }
            
            
        }
        
    }
    
    
    /**
	 * getRSocial - Get the user razon social.
	 *
	 * @return	mixed				Upon successful completion the rsocial is returned.
	 *								Otherwise, null is returned.
	 * @access	public
	 */
    function getRSocial() {
        
        $query = "select rsocial from clientes where cliente_id = '" . $this->_userid . "'";
        $rsocial = (string) db::get_row_as_scalar($query);
        if (strlen($rsocial) > 0)
            return $rsocial;
        return null;
        
    }
	
}
?>

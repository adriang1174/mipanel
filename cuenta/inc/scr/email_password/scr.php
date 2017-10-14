<?

class scr
{
    var $allow_print = false;
    var $allow_printall = false;
    var $allow_exportcsv = false;
    var $allow_email = false;
    var $allow_pay = false;
    
	function parameters( $params)
	{
		return true;
	}
	
	function filter( $params)
	{
		return true;
	}
	
	function process( $params)
	{
		return true;
	}

	function assign( $params) {
	


		
		$msg_errorEmail = "";
		$msg_infoEmail = "";
		$msg_errorPass = "";
		$msg_infoPass = "";
		
		if (isset($_POST["updateEmail"])) {
			
			$profile = new profile(ca_session::get_userid());
			
			$user_emailValido = true;
			if (strlen($_POST["user_email"]) == 0) {
				
				$user_email = "";
				
			} else {
				
				$user_email = filter::email($_POST["user_email"]);
				if (!$user_email) $user_emailValido = false;
				
			}
			
			
			if (!$user_emailValido) {

				$msg_errorEmail = lang("DATMOD_INVALID_EMAIL") 
					. " (" . $_POST["user_email"] . ")";
				
			} else {

				$actual_email = $profile->get_mail_admin( );
			
				if (strcmp($actual_email, $user_email) != 0) {
					

// PARCHE, DEJO DE FUNCIONAR BIEN CON EL ULTIMO CAMBIO DE VERSION DE PHP
					$profile->updateEmail($user_email);
		            if (false) {

		                $msg_errorEmail = lang("EMAIL_SET_ERROR");

		            } else {
               
		                if (strlen($user_email) == 0) {
		                	
		                	$msg_infoEmail = lang("PROFILE_DATA_SAVED_CONFIRM");
		                	
		                } else {
			                // Sending the confirmation e-mail.
							$user = new user( ca_session::get_userid( ));
							$user_name = $user->get_titular();
							
							/*
							  
							  Se envia un email con un link de confirmacion a la nueva
							  dirección de correo especificada.
							  
							  /home/httpd/zonasegura.grupoalternativa.com/beta-cuenta/inc/eml_confirm.php
							  es una clase estatica que contiene el metodo de envio de correo de confirm.
							  
							  El correo de confirm. trae un link de activacion que es procesado en
							  /home/httpd/zonasegura.grupoalternativa.com/html/beta-cuenta/activate.ca
							  
						    */
						    $exitoEnvMailUsr = eml_confirm::send_email(
								ca_session::get_userid( ), $user_email, $user_name, $user_phone);
								
							if (!$exitoEnvMailUsr) {
			                   	$msg_errorEmail = lang("EMAIL_SEND_ERROR");
			                } else {
			                	$msg_infoEmail = lang("PROFILE_DATA_SAVED_EML_CONFIRM");
			                }
			           	}
		                
		            }
		
		        }
		        
			}
			
		}
		
		if (isset($_POST["updatePass"])) {
			
			
			
			$user_passwd = filter::password($_POST["user_passwd"]);
			$user_passwd_confirm = filter::password($_POST["user_passwd_confirm"]);
			
			if (!$user_passwd || !$user_passwd_confirm) {
			
				$msg_errorPass = lang("DATMOD_INVALID_PASSWORD");

			} else {

            	$profile = new profile(ca_session::get_userid());
            	
            	if (strcmp($user_passwd, $user_passwd_confirm) != 0) {
               		
               		$msg_errorPass = lang("DATMOD_WRONG_CONFIRMATION");
               	/*	
            	} else if ( false and !$profile->updatePassword($user_passwd)) { // PARCHE POR CAMBIO DE VERSION DE PHP

                	$msg_errorPass = lang("PASSWORD_SET_ERROR");
                */	
            	} else {
                	$profile->updatePassword($user_passwd);
            		
            		$msg_infoPass = lang("MSG_PASSWORD_CHANGE");
            		
            	}
            	
            }

			
		}
		
		global $smarty;
		
		$profile = new profile(ca_session::get_userid());
		$smarty->assign("user_email", $profile->get2());
		
		$smarty->assign("msg_errorEmail", $msg_errorEmail);
		$smarty->assign("msg_infoEmail", $msg_infoEmail);
		
		$smarty->assign("msg_errorPass", $msg_errorPass);
		$smarty->assign("msg_infoPass", $msg_infoPass);
		
		return true;    // we always show the form
		
	}
	
}

?>

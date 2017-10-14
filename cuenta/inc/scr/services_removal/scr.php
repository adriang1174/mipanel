<?
require_once( INCLUDE_PATH . "data/profile.php");
require_once( INCLUDE_PATH . "data/services.php");

class scr {
	
    var $allow_print = false;
    var $allow_printall = false;
    var $allow_exportcsv = false;
    var $allow_email = false;
    var $allow_pay = false;
    
	function parameters( $params) {
		if ($params) {
			basescr::setvar("line", varconn::POST("line"));
			basescr::setvar("process", varconn::POST("process"));
			basescr::setvar("actioncode", varconn::POST("actioncode"));
			basescr::setvar("actionid", varconn::POST("actionid"));
			
			//
			
			basescr::setvar("service", varconn::POST("service"));
			
			
			
			
		}
		return true;
	}
	
	function filter($params) {
		
		return true;
		
	}
	
	function process($params) {
		
		return true;
		
	}

	function assign($params) {

        global $smarty;

		$profile = new profile( ca_session::get_userid( ));
        $email_verif = $profile->is_mail_verif( );
        
		$smarty->assign( "TITLE", lang( 'TITLE_CONF_SERVICES'));
		if (!$email_verif){
            
            $smarty->assign("email_not_verif", true);
            
        } else {
			
			if (!isset($_POST["step"])) {
			
				$lines = Services::getLinesByUserForRemoval(ca_session::get_userid( ));
				$smarty->assign("lines", $lines);
				$smarty->assign("show", "select");
			
			} else {
				
				
				if ($_POST["step"] == 1) {
			
					//pantalla de confirmación					
					$smarty->assign("show", "confirma");
					$smarty->assign("line", basescr::getvar("line"));
					$service_info = Services::getServiceInfo(basescr::getvar( "line"));
					
					$smarty->assign("service", $service_info["servicio"]);			
					
					
				} else if ($_POST["step"] == 2) {
				
					//formulario informativo	
					
					
					$smarty->assign("show", "formulario");
					$smarty->assign("line", basescr::getvar("line"));
					$smarty->assign("service", basescr::getvar("service"));
				
				} else {					
					//procesa formulario y envia mail
					if(!empty($_POST)){	
						
						//Email a alternativa
						$ca_email = new ca_email("mail_gm_baja_servicio", ca_session::language_get());
						
						
						if($owner == 7){ // t2
							$ca_email->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, 
										new ca_email_recipient('{$GM-WEBIMPORT$} <'.owner::addr_support_display() .'>', '{$GM-WEBIMPORT$} <'.owner::addr_support_display() .'>'));
						}else{
							 $ca_email->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, 
								new ca_email_recipient('{$GM-WEBIMPORT$} <'.owner::addr_support() .'>', '{$GM-WEBIMPORT$} <'.owner::addr_support() .'>'));
						}
						 
						
						
						/*
						$ca_email->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, 
							new ca_email_recipient('sebastianhgil@gmail.com', 'sebastianhgil@gmail.com'));	
						*/
						
						$user = new user( ca_session::get_userid( ));	
						$actual_email = $profile->get_mail_admin();
						
						$ca_email->set_tag_replacement( "[MAIL_FROM]", '<'.$actual_email.'>');
				        $ca_email->set_tag_replacement( "[CLIENT_ID]", ca_session::get_userid());	
						$ca_email->set_tag_replacement( "[RAZON_SOCIAL]", $user->get_titular( ));
						$ca_email->set_tag_replacement( "[FECHA_ENVIO]", date("d/m/Y H:i:s"));
												
					
						
						$email_template = "";						
						$email_template .= TPL_BAJA_ADARDEBAJA . ": ".  $_POST['service'] .  "\n\n";
						$email_template .= TPL_BAJA_LOGIN . ": ".  $_POST['line'] .  "\n\n";
						$email_template .= TPL_BAJA_PREG1 . "\n";
						$email_template .= TPL_BAJA_NECESIDADES . ": ". ((int)($_POST['BAJA_NECESIDADES']) ? 'Si' : 'No') ."\n";
						$email_template .= TPL_BAJA_PROMETIDO . ": ". ((int)($_POST['BAJA_PROMETIDO']) ? 'Si' : 'No') ."\n";					
						$email_template .= TPL_BAJA_NECESITO . ": ". ((int)($_POST['BAJA_NECESITO']) ? 'Si' : 'No') ."\n";
						$email_template .= TPL_BAJA_INCONVENIENTES . ": ". ((int)($_POST['BAJA_INCONVENIENTES']) ? 'Si' : 'No') ."\n";
						$email_template .= TPL_BAJA_FUNCIONAMIENTO . ": ". ((int)($_POST['BAJA_FUNCIONAMIENTO']) ? 'Si' : 'No') ."\n";
						$email_template .= TPL_BAJA_EMPRESA . ": ". ((int)($_POST['BAJA_EMPRESA']) ? 'Si' : 'No') ."\n";
						$email_template .= TPL_BAJA_CIERRE . ": ". ((int)($_POST['BAJA_CIERRE']) ? 'Si' : 'No') ."\n";
						$email_template .= TPL_BAJA_FALLECIMIENTO . ": ". ((int)($_POST['BAJA_FALLECIMIENTO']) ? 'Si' : 'No') ."\n";
						$email_template .= TPL_BAJA_OTRA . ": ". $_POST['BAJA_OTRA'] ."\n";
						$email_template .= "\n" . TPL_BAJA_PREG2 . "\n";
						$email_template .= TPL_BAJA_RUIDO . ": ". ((int)($_POST['BAJA_RUIDO']) ? 'Si' : 'No') ."\n";
						$email_template .= TPL_BAJA_ECO . ": ". ((int)($_POST['BAJA_ECO']) ? 'Si' : 'No') ."\n";
						$email_template .= TPL_BAJA_CORTA . ": ". ((int)($_POST['BAJA_CORTA']) ? 'Si' : 'No') ."\n";
						$email_template .= TPL_BAJA_OCUPADA . ": ". ((int)($_POST['BAJA_OCUPADA']) ? 'Si' : 'No') ."\n";
						$email_template .= TPL_BAJA_PROBLEMAS . ": ". ((int)($_POST['BAJA_PROBLEMAS']) ? 'Si' : 'No') ."\n";
						$email_template .= TPL_BAJA_OTROS . ": ". $_POST['BAJA_OTROS'] ."\n";							

						
						$ca_email->set_tag_replacement( "[DATOS_ENCUESTA]", $email_template);	
						$ca_email->_txtbody = true; // Manda el mail en texto plano
						$res = $ca_email->send_pear();	//verificar si hubo exito
						$smarty->assign("show", "cierreProceso");	
						
					
						//Email a cliente
					
						$profile = new profile(ca_session::get_userid());
						$email = $profile->get_mail_admin( );
					
						$ca_email2 = new ca_email("general_pourpose", ca_session::language_get());			
						
						
						$ca_email->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, 
							new ca_email_recipient($email, $email));
						
						 /*
						$ca_email2->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, 
						new ca_email_recipient('sebastianhgil@gmail.com', 'sebastianhgil@gmail.com'));
						*/
					
						$ca_email2->set_tag_replacement( "[from]", 'importaciongm@grupoalternativa.com');	
						$ca_email2->set_tag_replacement( "[reply]", 'importaciongm@grupoalternativa.com');	
						$ca_email2->set_tag_replacement( "[subject]", 'Mi Panel - Baja de Servicio');					
						$email_template = TPL_BAJA_EMAIL;
						$ca_email2->set_tag_replacement( "[data]", $email_template);	
						$res = $ca_email2->send_pear();
					}									
					
				}
				
				
			}
			
			
		}

		return true;
	}
}
?>

<?

class scr
{
    
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

	function assign( $params)
	{
		global $smarty;	
		
		
		$owner = owner_to_ownerid();

		if($owner == 1 || $owner == 2){ // red
			$smarty->assign("vea_ademas_red", true);
		}else if($owner == 3){ // hota
			$smarty->assign("vea_ademas_hola", true);	
		}else if($owner == 5){ // hotatel
			$smarty->assign("vea_ademas_holatel", true);
		} else if($owner == 7){ // t2
			$smarty->assign("vea_ademas_telephone2", true);
		}
		
		if(!empty($_POST)){
			if($_POST["name"] != "" && $_POST["comments"] != ""){
				$ca_email = new ca_email("mail_gm_contacto", ca_session::language_get());
				
				$owner = owner_to_ownerid();
				if($owner == 7){ // t2
					$ca_email->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, 
								new ca_email_recipient('{$GM-WEBIMPORT$} <'.owner::addr_support_display() .'>', '{$GM-WEBIMPORT$} <'.owner::addr_support_display() .'>'));
				}else{
					$ca_email->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, 
								new ca_email_recipient('{$GM-WEBIMPORT$} <'.owner::addr_support() .'>', '{$GM-WEBIMPORT$} <'.owner::addr_support() .'>'));
				}
				
				
				/*
				$ca_email->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, 
		        	new ca_email_recipient("fstecher@alternativa.com.ar", "fstecher@alternativa.com.ar"));
		        	
		        */
		        /*
		        $ca_email->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, 
		        	new ca_email_recipient("sebastianhgil@gmail.com", "sebastianhgil@gmail.com"));
		        	
		        */	
				$user = new user( ca_session::get_userid( ));	
				$profile = new profile(ca_session::get_userid());
				$actual_email = $profile->get_mail_admin();
				
				//$ca_email->set_tag_replacement( "[MAIL_FROM]", '<'. owner::addr_support() .'>');

				$ca_email->set_tag_replacement( "[MAIL_FROM]", $user->get_titular() .'<'.$user->get_email().'>');
				$ca_email->set_tag_replacement( "[CLIENT_ID]", ca_session::get_userid());	
				$ca_email->set_tag_replacement( "[NOMBRE]", $_POST["name"]);
				$ca_email->set_tag_replacement( "[TIPO_RECLAMO]", $_POST["tipo_reclamo"]);
				$ca_email->set_tag_replacement( "[COMENTARIO]", $_POST["comments"]);	
				$ca_email->set_tag_replacement( "[FECHA_ENVIO]", date("d/m/Y H:i:s"));		
				$ca_email->set_tag_replacement( "[SUBJECT]", ca_session::get_userid() . ' - '. $_POST['tipo_reclamo']);				
				
				$ca_email->_txtbody = true; // Manda el mail en texto plano
				$res = $ca_email->send_pear();	//verificar si hubo exito

				$owner = owner_to_ownerid();
				$smarty->assign("contact_msg_txt", true);
				
				
			}else{
				$mostrar_formulario = true;
				$smarty->assign("contact_msg_txt", false);
			}
			
		
			$smarty->assign("contact_msg", true);
			
		}else{
			$mostrar_formulario = true;
		}
		
		if($mostrar_formulario){
			$owner = owner_to_ownerid();
			if($owner == 3){ // hola
				$reclamos = array('Cambio de forma de pago', 'Me mudo', 'Inconvenientes t&eacute;cnicos', 'Inconvenientes con el pago', 'Reclamo sobre facturaci&oacute;n', 'Otros');
			}else{
				$reclamos = array('No recib&iacute; la factura', 'Inconvenientes t&eacute;cnicos', 'Inconvenientes con el pago', 'Reclamo sobre facturaci&oacute;n', 'Cambio de forma de pago', 'Otros');
			}

			$smarty->assign('reclamos', $reclamos);
			$smarty->assign("contact_form", true);
		}
		
		return true;
	}
}

?>

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
		
		if(!empty($_POST)){
			if($_POST["email_addr"] != ""){
				$ca_email = new ca_email("general_pourpose", ca_session::language_get());
				
				 /*
				$ca_email->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, 
					new ca_email_recipient("sebastianhgil@gmail.com", "sebastianhgil@gmail.com"));
				*/
				$ca_email->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, 
					new ca_email_recipient("newsletter@alternativa.com.ar", "newsletter@alternativa.com.ar"));
					
				
				$ca_email->set_tag_replacement( "[from]", 'importaciongm@grupoalternativa.com');	
				$ca_email->set_tag_replacement( "[reply]", 'importaciongm@grupoalternativa.com');	
				$owner = owner_to_ownerid();
				if($owner == 1 || $owner == 2){ // red
					$ca_email->set_tag_replacement( "[subject]", 'Mi Panel Alternativa - Suscripcion a newsletter');	
				}else if($owner == 3){ // hotatel
					$ca_email->set_tag_replacement( "[subject]", 'Mi Panel Holatel - Suscripcion a newsletter');	
				}else if($owner == 4){ // viatel
					$ca_email->set_tag_replacement( "[subject]", 'Mi Panel Latinatel Brasil - Suscripcion a newsletter');	
				} else if($owner == 7){ // t2
					$ca_email->set_tag_replacement( "[subject]", 'Mi Panel Telephone2 - Suscripcion a newsletter');	
				}

				
				$user = new user( ca_session::get_userid( ));
				$email_template = "";
				$email_template .= "Codigo de cliente: ". ca_session::get_userid( ) ."<br>";
				$email_template .= "Nombre y apellido: ". $user->get_titular( ) ."<br>";
				$email_template .= "Email ingresado: ".$_POST["email_addr"] ."<br>";
				
                        
				
				$ca_email->set_tag_replacement( "[data]", $email_template);	

				$res = $ca_email->send_pear();	//verificar si hubo exito
				$smarty->assign("mostrar_msg", true);
			}else{
				$mostrar_formulario = true;
				$smarty->assign("mostrar_msg_error", "<span style='color: red; font-weight: bold'>". TPL_NEWSLETTER_MSG_KO ."</span>");
				$smarty->assign("mostrar_form", true);
			}
			
		}else{
			$smarty->assign("mostrar_form", true);
			$owner = owner_to_ownerid();
		
			if($owner == 1 || $owner == 2){ // red
				$smarty->assign("news_red", true);
			}else if($owner == 3){ // hotatel
				$smarty->assign("news_hola", true);
			}else if($owner == 4){ // viatel
				$smarty->assign("news_viatel", true);
			} else if($owner == 7){ // t2
				$smarty->assign("news_t2", true);
			}
		}
		
		return true;
	}
}

?>

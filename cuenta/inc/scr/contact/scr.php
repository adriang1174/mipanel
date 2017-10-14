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
		require_once(INCLUDE_PATH .'nusoap/nusoap.php');
		
		if(!isset($_POST['line'])){
			$lineas_hola = Services::getHolaAccounts(ca_session::get_userid( ));

			if(count($lineas_hola) == 1){ // tiene un hola
				$smarty->assign("show_form", true);
				$smarty->assign("selected_line", $lineas_hola[0][0]);
			}else if(count($lineas_hola) > 1){ // Tiene varios hola
				$smarty->assign("show_select", true);
				$smarty->assign("lines", $lineas_hola);
			}else{ // no tiene "holas"
				header("location: home.ca");
				exit;
			}
		}else{
			if($_POST['send'] == 'true'){
				$valid = true;
				$str_err = '';
				$envios[1] = false;
				$envios[2] = false;
				$envios[3] = false;
				
				$email1 = filter::email($_POST['email_1']);
				if(!$email1){
					$valid = false;
					$str_err .= '- Email 1 no es v&aacute;lido<br />';
				}else{
					$envios[1] = true;
				}
				
				if($_POST['email_2'] != ''){
					$email2 = filter::email($_POST['email_2']);
					if(!$email2){
						$valid = false;
						$str_err .= '- Email 2 no es v&aacute;lido<br />';
					}else{
						$envios[2] = true;
					}
				}
				
				if($_POST['email_3'] != ''){
					$email3 = filter::email($_POST['email_3']);
					if(!$email3){
						$valid = false;
						$str_err .= '- Email 3 no es v&aacute;lido<br />';
					}else{
						$envios[3] = true;
					}
				}
				
				if($valid){ // envio
					//$soapclient = new soapclient2('https://zonasegura.grupoalternativa.com/services/index.php');
					$soapclient = new soapclient2('http://mipanel.grupoalternativa.com/services/index.php');
					if (!$soapclient->getError()) {
						// obtengo un token
						$token = $soapclient->call('core_auth', 
							array(
								'username'=>'test',
								'password'=>'test123'
							));
					}
					if (!$soapclient->fault && !$soapclient->getError()) {
						$result = $soapclient->call('servicios_getAniInfo', array('token'=>$token, 'ani' => $_POST['line'], 'mostrar_codigo_pais' => true));
					}

					if($result['numero_formateado'] != ''){
						$numero_formateado = $result['numero_formateado'];
					}else{
						$numero_formateado = $_POST['line'];
					}

					for($i=1; $i<4; $i++){
						if($envios[$i]){
							$ca_email = new ca_email("recomendar_hola", ca_session::language_get());
				
							$ca_email->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, 
								new ca_email_recipient($_POST['nombre_'. $i], $_POST['email_'. $i]));
					
							$user = new user( ca_session::get_userid( ));	
							$ca_email->set_tag_replacement( "[nombre_remitente]", $user->get_titular());	
							$ca_email->set_tag_replacement( "[from]", "HolaTel <noreply@holatel.com>");	
							$ca_email->set_tag_replacement( "[reply_to]", "noreply@holatel.com");	
							$ca_email->set_tag_replacement( "[subject]", utf8_decode('¡').  $user->get_titular() .' quiere que agendes su HolaTel!');	
							$ca_email->set_tag_replacement( "[numero_remitente]", $numero_formateado);
							$ca_email->set_tag_replacement( "[nombre_destinatario]", $_POST['nombre_'. $i]);
					
							$ca_email->send_pear();
						}	
					}
													
					$smarty->assign("show_thanks", true);
				}else{
					$smarty->assign("str_error", $str_err);		
					
					$smarty->assign("nombre_1", $_POST['nombre_1']);
					$smarty->assign("email_1", $_POST['email_1']);
					
					$smarty->assign("nombre_2", $_POST['nombre_2']);
					$smarty->assign("email_2", $_POST['email_2']);
					
					$smarty->assign("nombre_3", $_POST['nombre_3']);
					$smarty->assign("email_3", $_POST['email_3']);
								
					$smarty->assign("show_form", true);
					$smarty->assign("selected_line", $_POST['line']);	
				}
								
				
			}else{
				$smarty->assign("show_form", true);
				$smarty->assign("selected_line", $_POST['line']);
			}
		}
		return true;
	}
}

?>

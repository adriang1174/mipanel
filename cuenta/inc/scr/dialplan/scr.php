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
		
		if(isset($_GET['line'])){
			$_POST['line'] = $_GET['line'];
		}
		
		if(!isset($_POST['line'])){
			$lineas_sip = Services::getSIPAccounts(ca_session::get_userid( ));

			if(count($lineas_sip) == 1){ // tiene un hola
				$show_dialplan = true;
				$_POST['line'] = $lineas_sip[0][0];
			}else if(count($lineas_sip) > 1){ // Tiene varios hola
				$smarty->assign("show_select", true);
				$smarty->assign("lines", $lineas_sip);
			}else{ // no tiene "sips"
				header("location: home.ca");
				exit;
			}
		}else{
			$show_dialplan = true;
			if(isset($_POST['save_dialplan'])){
				$guardar_dialplan = Services::setSIPDialplan($_POST['line'], $_POST['Codigo_Pais'], $_POST['Codigo_Area'], $_POST['Codigo_PSTN'], $_POST['Codigo_SIP'], $_POST['Codigo_Escape_Loc'], $_POST['Codigo_Escape_Nac'], $_POST['Codigo_Escape_Int']);

			
				if($_POST['send_email'] == '1'){
					$regla_discado_sip = '';
					if(trim($_POST['Codigo_SIP']) != ''){
						$regla_discado_sip .= $_POST['Codigo_SIP'].' + ';
					}

					$regla_discado_pstn = '';
					$regla_discado_larga_distancia_nacional = '';
					$regla_discado_larga_distancia_internacional = '';
					if(trim($_POST['Codigo_PSTN']) != ''){
						$regla_discado_pstn .= $_POST['Codigo_PSTN'] . ' + ';
						$regla_discado_larga_distancia_nacional .= $_POST['Codigo_PSTN'] . ' + ';
						$regla_discado_larga_distancia_internacional .= $_POST['Codigo_PSTN'] . ' + ';
					}

					if(trim($_POST['Codigo_Escape_Loc']) != ''){
						$regla_discado_pstn .= $_POST['Codigo_Escape_Loc'] . ' + ';
					}
		
					if(trim($_POST['Codigo_Escape_Nac']) != ''){
						$regla_discado_larga_distancia_nacional .= $_POST['Codigo_Escape_Nac'] . ' + ';
					}
		
					if(trim($_POST['Codigo_Escape_Int']) != ''){
						$regla_discado_larga_distancia_internacional .= $_POST['Codigo_Escape_Int'] . ' + ';
					}
				
		
					
				
					/*
					$ca_email->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, 
						new ca_email_recipient($_POST['nombre_'. $i], $_POST['email_'. $i]));
					
				
					
					
					$ca_email->add_to(CA_EMAIL_RECIPIENT_TYPE_TO,
						new ca_email_recipient('Adrian', 'agarcia@alternativa.com.ar'));
					
					*/
					
					$owner = owner_to_ownerid();
					if($owner == 2 || $owner == 3){ // holared y holatel 
						$ca_email = new ca_email("dialplan_holatel", ca_session::language_get());	
						$ca_email->set_tag_replacement( "[from]", "HolaTel <noreply@holatel.com>");	
						$ca_email->set_tag_replacement( "[subject]", utf8_decode('Mi Panel - Opción de marcado de Línea IP'));	
					}else if($owner == 1){ // red
						$ca_email = new ca_email("dialplan_alternativa", ca_session::language_get());	
						$ca_email->set_tag_replacement( "[from]", "Alternativa <noreply@alternativa.com.ar>");	
						$ca_email->set_tag_replacement( "[subject]", utf8_decode('Mi Panel - Opción de marcado de Línea IP'));	
					} else if($owner == 7){ // t2
						$ca_email = new ca_email("dialplan_t2", ca_session::language_get());	
						$ca_email->set_tag_replacement( "[from]", "Telephone 2 <noreply@telephone2.com>");	
						$ca_email->set_tag_replacement( "[subject]", utf8_decode('Mi Panel - Opción de marcado de Línea IP'));	
					}
					
								
					$user = new user( ca_session::get_userid( ));
					$ca_email->add_to(CA_EMAIL_RECIPIENT_TYPE_TO,
						new ca_email_recipient($user->get_titular(), $user->get_email()));
						
					// discado
						
					$ca_email->set_tag_replacement( "[titular]",  $user->get_titular());
					$ca_email->set_tag_replacement( "[codigo_cliente]",  $user->userid);
					$ca_email->set_tag_replacement( "[PREFIX_IP]",  $regla_discado_sip);
					$ca_email->set_tag_replacement( "[PREFIX_LOCAL]",  $regla_discado_pstn);
					$ca_email->set_tag_replacement( "[PREFIX_NACIONAL]",  $regla_discado_larga_distancia_nacional);
					$ca_email->set_tag_replacement( "[PREFIX_INTERNACIONAL]",  $regla_discado_larga_distancia_internacional);

		
					$ca_email->send_pear();
				
					$smarty->assign("msg_mail", true);
				}else{
					if($guardar_dialplan){
						$smarty->assign("msg_guardar_ok", true);
					}else{
						$smarty->assign("msg_guardar_ko", true);
					}
				}
			}
		}
		
		if($show_dialplan){
			$smarty->assign("show_form", true);
			$smarty->assign("selected_line", $_POST['line']);
			$dialplan = Services::getSIPDialplan($_POST['line']);


			$regla_discado_pstn = '';
			$regla_discado_larga_distancia_nacional = '';
			$regla_discado_larga_distancia_internacional = '';
			if(trim($dialplan['Codigo_PSTN']) != ''){
				$regla_discado_pstn .= $dialplan['Codigo_PSTN'] . ' + ';
				$regla_discado_larga_distancia_nacional .= $dialplan['Codigo_PSTN'] . ' + ';
				$regla_discado_larga_distancia_internacional .= $dialplan['Codigo_PSTN'] . ' + ';  
			}

			if(trim($dialplan['Codigo_Escape_Loc']) != ''){
				$regla_discado_pstn .= $dialplan['Codigo_Escape_Loc'] . ' + ';
			}

			$smarty->assign('REGLA_DISCADO_LOCAL', $regla_discado_pstn);

			if(trim($dialplan['Codigo_Escape_Nac']) != ''){
				$regla_discado_larga_distancia_nacional .= $dialplan['Codigo_Escape_Nac'] . ' + ';
			}

			$smarty->assign('REGLA_DISCADO_LARGA_DISTANCIA_NACIONAL', $regla_discado_larga_distancia_nacional);

			if(trim($dialplan['Codigo_Escape_Int']) != ''){
				$regla_discado_larga_distancia_internacional .= $dialplan['Codigo_Escape_Int'] . ' + ';
			}

			$smarty->assign('REGLA_DISCADO_LARGA_DISTANCIA_INTERNACIONAL', $regla_discado_larga_distancia_internacional);
			
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
				$result = $soapclient->call('servicios_listaPais', array('token'=>$token));

			}else{
//echo $soapclient->getError();
//echo "ERROR";
}
			if(count($result) > 0){   	 
				$arr_paises = array();
				foreach($result as $localidad){
					if ($localidad["codigo"] == $dialplan["Codigo_Pais"]) {
						$selected = '';
						$dialplan["Denom_Pais"] = $localidad["nombrePais"];
					} else {
						$selected = '';
					}
					$selected = $localidad["codigo"] == $dialplan["Codigo_Pais"] ? 'selected' : '';
					$arr_paises[] = array('CODIGO' => $localidad["codigo"], 'NOMBRE' => $localidad["nombrePais"],'SELECTED' => $selected);
		
				}	
				$smarty->assign("arr_paises", $arr_paises);
			}
			$smarty->assign("dialplan", $dialplan);
			/*
			echo "<pre>";
			print_r($dialplan);
			echo "</pre>";
			*/
		}
		return true;
	}
}

?>

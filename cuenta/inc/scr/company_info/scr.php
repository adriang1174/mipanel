<?php 
class scr {
    
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
	
		global $smarty;
		
	
		require_once(INCLUDE_PATH .'nusoap/nusoap.php');

		$owner = owner_to_ownerid();
		if($owner == 3 || $owner == 5 || $owner == 4){
			$smarty->assign('restrict_owner_hola', true);
		}else{
			$smarty->assign('restrict_owner_hola', false);
		}
			
		if(!empty($_POST)){
		/*	
			echo "<pre>";
			print_r($_POST);
			exit;
		*/
			switch($_POST['form_submit']){
			
				case 'mp_paypage':
				
					/*
					require_once (INCLUDE_PATH .'litle/LitleOnline.php');  
					
						$token_info = array(
						'orderId'=>$_POST['request$orderId'],
						'paypageRegistrationId'=> $_POST['response$paypageRegistrationId']);
						 
						$initilaize = &new LitleOnlineRequest();

						$tokenResponse = $initilaize->registerTokenRequest($token_info);


						$response = (XmlParser::getNode($tokenResponse ,'response'));
						$token = XmlParser::getNode($tokenResponse ,'litleToken');

						

						if($response == '802'){
					*/
							global $dbh;

							$res = $dbh->execute("INSERT INTO clientes_medios_pago (cliente_id, medio, cuenta, fecha, calle, numero, piso, depto, ciudad, cp, provincia, pais, titular, vencimiento,cbu) VALUES (?, 'WWPS', ?, current_timestamp, ?, ?, ?, ?, ?, ?,  ?, ?, ?, ?,?)", array(ca_session::get_userid( ), $_POST['ccNum'], 
											$_POST['mp_calle'],
											$_POST['mp_numero'],
											$_POST['mp_piso'],
											$_POST['mp_departamento'],
											$_POST['mp_ciudad'],
											$_POST['mp_codigo_postal'],
											$_POST['mp_provincia'],
											$_POST['mp_pais'],
											$_POST['fName'] . ' ' . $_POST['lName'],
											$_POST['expDate'],
											$_POST['cvv2num'],
											));	
											
					/*		
						}else{
							echo "ERROR: ". XmlParser::getNode($tokenResponse ,'message');
						}
					*/	
						/*
						#display results
						echo ("Response: " . (XmlParser::getNode($tokenResponse ,'response')) . "<br>");
						echo ("Message: " . XmlParser::getNode($tokenResponse ,'message') . "<br>");
						echo ("Litle Transaction ID: " . XmlParser::getNode($tokenResponse ,'litleTxnId'). "<br>");
						echo ("Litle Token: " . XmlParser::getNode($tokenResponse ,'litleToken'));
					
						*/
						Misc::create_vtiger_tt(ca_session::get_userid( ));
					
					break;
				case 'mp':
					$tipo_cambio = '';
					if(isset($_POST['mp_titular']) && $_POST['mp_titular'] != ''){ // tarjeta
						$tipo_cambio = 'tarjeta';
						$query = "INSERT INTO clientes_medios_pago (cliente_id, medio, titular, cuenta, vencimiento, fecha, calle, numero, piso, depto, ciudad, cp, provincia, pais) 
									VALUES (?, ?,?, ?,?, current_timestamp, ?, ?, ?, ?, ?,  ?, ?, ?)";
						
						if($_POST['mp_tipo'] == 'amex'){
							$tarjeta = $_POST['mp_numero_amex'];
						}else if($_POST['mp_tipo'] == 'master'){
							$tarjeta = $_POST['mp_numero_master'];
						}else{
							$tarjeta = $_POST['mp_numero_visa'];
						}
						
						
						$reemplazos = array(ca_session::get_userid( ), 
											$_POST['mp_tipo'], 
											$_POST['mp_titular'], 
											$tarjeta, 
											$_POST['tarjeta_vencimiento_mes'] .'/'.$_POST['tarjeta_vencimiento_ano'],
											$_POST['mp_calle'],
											$_POST['mp_numero'],
											$_POST['mp_piso'],
											$_POST['mp_departamento'],
											$_POST['mp_ciudad'],
											$_POST['mp_codigo_postal'],
											$_POST['mp_provincia'],
											$_POST['mp_pais']
											);
							
						
						$ultimos4 = substr($tarjeta, strlen($tarjeta) - 4);
						$arr_values_usuario = array('Tarjeta de cr&eacute;dito', $_POST['mp_titular'], $_POST['mp_tipo'], 'XXXX-XXXX-XXXX-'. $ultimos4, $_POST['tarjeta_vencimiento_mes'] .'/'.$_POST['tarjeta_vencimiento_ano']);
					}else{ // cuenta corriente
						$tipo_cambio = 'cc';
						$query = "INSERT INTO clientes_medios_pago (cliente_id, medio, titular, cuenta, cbu, banco, sucursal, fecha) VALUES (?, ?, ?, ?, ?, ?, ?, current_timestamp)";
						
						$reemplazos = array(ca_session::get_userid( ), 
											$_POST['mp_tipo'], 
											$_POST['mp_titular_da'], 
											$_POST['mp_cuenta_da'],
											$_POST['mp_cbu'],  
											$_POST['mp_banco'],  
											$_POST['mp_sucursal']);
											
						
						$arr_fields_usuario = array('Tipo', 'Titular', 'Cuenta', 'CBU', 'Banco', 'Sucursal');
						$ultimos4 = substr($_POST['mp_cuenta_da'], strlen($_POST['mp_cuenta_da']) - 4);
						if($_POST['mp_tipo'] == 'caja'){
							$tipo_formateado = 'Caja de ahorro';
						}else{
							$tipo_formateado = 'Cuenta corriente';
						}
						$arr_values_usuario = array($tipo_formateado, $_POST['mp_titular_da'], 'XXXX...'. $ultimos4, $_POST['mp_cbu'], $_POST['mp_banco'],  
											$_POST['mp_sucursal']);
					}
					
					global $dbh;
					
					/* PARCHE POR EL PROBLEMA CON LA DB */
					
					$reintentos = 10;
					$res = false;
				
					for($i=0; $i<$reintentos; $i++){
						if(!$res){
							$res = $dbh->execute($query, $reemplazos);	
						}
					}
					
					
				
					
					if(!$res){
						/* LOG EN DISCO */
					
					
					
						$myFile = "../../log_cambio_medio_pago.txt";
						$fh = fopen($myFile, 'a');
						$stringData = date("d/m/Y H:i:s") . " - ----- \n\n";
						$stringData .= "Cliente: ". ca_session::get_userid( ) ."\n";
						$stringData .= "Query: ". $query ."\n";
					
						$txt_reemplazos = print_r($reemplazos, true);
					
						$stringData .= "Reemplazos: ". $txt_reemplazos ."\n";
						$stringData .= "Error: ". pg_last_error() ."\n\n\n";
					
						fwrite($fh, $stringData);
						fclose($fh);
					}
					
					$owner = owner_to_ownerid();
					if($owner == 4){
						if($tipo_cambio == 'tarjeta'){
							$arr_fields_usuario = array('Tipo', 'Titular', 'Cart&atilde;o', 'Numero', 'Data de Vencimento');
				
						}else{
							$arr_fields_usuario = array('Tipo', 'Titular', 'Cuenta', 'CBU', 'Banco', 'Sucursal');
						}
		
						$title = utf8_decode('Mudança no método de pagamento');
						$title_confirmacion = 'Solicitud de Cambio de medio de pago - Mi Panel';
						$arr_fields = array('Operacion');
						$arr_values = array('Cambio de medio de pago');
					}else{
	
						if($tipo_cambio == 'tarjeta'){
							$arr_fields_usuario = array('Tipo', 'Titular', 'Tarjeta', 'Numero', 'Vencimiento');
				
						}else{
							$arr_fields_usuario = array('Tipo', 'Titular', 'Cuenta', 'CBU', 'Banco', 'Sucursal');
						}
						
						$title = 'Cambio en el medio de pago';
						$title_confirmacion = 'Solicitud de Cambio de medio de pago - Mi Panel';
						$arr_fields = array('Operacion');
						$arr_values = array('Cambio de medio de pago');
					}
					$envia_mail = false;
					$envia_confirmacion = true;
					$mismo_mail_usuario = false;
					
					Misc::create_vtiger_tt(ca_session::get_userid( ));
				break;
				case 'df':
					$title = utf8_decode('Cambio de datos de Facturación');
					$title_confirmacion = utf8_decode('Solicitud de Cambio de datos de facturación - Mi Panel');
					$arr_fields = array('Calle', 'N&uacute;mero', 'Piso', 'Departamento', 'Ciudad', 'Localidad', 'C&oacute;digo postal', 'Provincia');
					$arr_values = array( $_POST['df_calle'], $_POST['df_numero'], $_POST['df_piso'], $_POST['df_dpto'], $_POST['df_ciudad'], $_POST['df_localidad'], $_POST['df_postal'], $_POST['df_provincia']);
					$envia_mail = true;
					$envia_confirmacion = true;
					$mismo_mail_usuario = true;
				break;
				default: // rs 
					$title = 'Cambio de razon social';
					$title_confirmacion = 'Solicitud de Cambio de razon social - Mi Panel';
					$arr_fields = array('Razon social', 'Domicilio', 'C&oacute;digo postal', 'Titular', 'Tel&eacute;fono', 'Email', 'CUIT/CUIL/DNI', 'Condici&oacute;n frente al IVA', '&iquest;Conserva el mismo medio de pago?');
					$arr_values = array($_POST['rs_rs'], $_POST['rs_domicilio'], $_POST['rs_postal'], $_POST['rs_titular'], $_POST['rs_telefono'], $_POST['rs_email'], $_POST['rs_cuit'], $_POST['rs_iva'], $_POST['rs_mediopago']);
					$envia_mail = true;
					$envia_confirmacion = true;
					$mismo_mail_usuario = true;
				break;
			}
			
						
			$total = count($arr_fields);
			$html = '<b>'. $title .'</b><br /><hr/><table>';
			for($i=0; $i<$total; $i++){
				$html .= '<tr><td>'.$arr_fields[$i].'</td><td>'.$arr_values[$i].'</td></tr>';
			}
			$html .= '</table>';
			
			if($mismo_mail_usuario){
				$html_usuario = $html;
			}else{
				$total = count($arr_fields_usuario);
				$html_usuario = '<b>'. $title .'</b><br /><hr/><table>';
				for($i=0; $i<$total; $i++){
					$html_usuario .= '<tr><td>'.$arr_fields_usuario[$i].'</td><td>'.$arr_values_usuario[$i].'</td></tr>';
				}
				$html_usuario .= '</table>';
			}
	
			$user = new user( ca_session::get_userid( ));	
				
			if($envia_mail){
				$ca_email = new ca_email( 'asistencia_general', 'es');
				
				
				$owner = owner_to_ownerid();
				
				
				if($owner == 7){ // t2
					$ca_email->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, 
								new ca_email_recipient('{$GM-WEBIMPORT$} <'.owner::addr_support_display() .'>', '{$GM-WEBIMPORT$} <'.owner::addr_support_display() .'>'));
				}else{
					$ca_email->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, 
								new ca_email_recipient('{$GM-WEBIMPORT$} <'.owner::addr_support() .'>', '{$GM-WEBIMPORT$} <'.owner::addr_support() .'>'));
				}
				
				
				
				$ca_email->set_tag_replacement("[ADDR_SUPPORT]", owner::addr_support());
				$ca_email->set_tag_replacement("[subject]", $title .' ' .ca_session::get_userid( ) );
				$ca_email->set_tag_replacement("[CODIGO]", ca_session::get_userid( ) );
				$ca_email->set_tag_replacement("[TITULAR]", $user->get_titular() ); 
				 
				$ca_email->set_tag_replacement("[data]", $html);
			
				$res = $ca_email->send_pear( );
			
			}
			
			if($envia_confirmacion){
				$profile = new profile(ca_session::get_userid());
				$mail_usuario =  new ca_email( 'cambio_datos', 'es');
			
				
				$mail_usuario->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, 
				    	new ca_email_recipient($profile->get_mail_admin( ), $profile->get_mail_admin( )));
				
				
				 /*
				$mail_usuario->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, 
				    	new ca_email_recipient('sebastian@promaker.com.ar', 'sebastian@promaker.com.ar'));    	
				      	
				 */ 	
				$mail_usuario->set_tag_replacement("[CODIGO]", ca_session::get_userid( ) );    
				$mail_usuario->set_tag_replacement("[SUBJECT]", $title_confirmacion );    
				$mail_usuario->set_tag_replacement("[ADDR_SUPPORT]", owner::addr_support());
				$mail_usuario->set_tag_replacement("[TITULAR]", $user->get_titular() ); 
				$mail_usuario->set_tag_replacement("[DATA]", $html_usuario ); 
				$res = $mail_usuario->send_pear( );
			
			}

			
			$smarty->assign('msg', true);
			
		}else{
		ini_set('display_errors', 0);
        ini_set('error_reporting', E_ALL);	
        

			//$soapclient = new soapclient2('https://zonasegura.grupoalternativa.com/services/index.php');
			//$soapclient = new soapclient2('https://webseg.alternativa.com.ar/services/index.php');
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
				$result = $soapclient->call('servicios_listaPais', 
						array('token'=>$token));

				$smarty->assign('select_paises', $result);

			}else{
			    echo $soapclient->getError();
			}
			$smarty->assign('form', true);
		}
			
		return true;    // we always show the form
		
	}
	
}

?>

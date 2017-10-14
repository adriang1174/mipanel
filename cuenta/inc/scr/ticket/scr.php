<?
class scr
{
    var $allow_print = true;
    var $allow_printall = false;
    var $allow_exportcsv = false;
    var $allow_email = true;
    var $allow_pay = true;
    
	var $cabeceraURL = "https://";
	
	function parameters( $params)
	{
		if ( $params)
		{
			basescr::setvar( "ticketid", varconn::REQUEST( "ticketid"));
			basescr::setvar( "month", varconn::REQUEST( "month"));
			basescr::setvar( "year", varconn::REQUEST( "year"));
            basescr::setvar( "pm", varconn::REQUEST("pm"));
            basescr::setvar( "import", varconn::REQUEST( "import"));
			basescr::setvar( "checkoutpp", varconn::REQUEST( "checkoutpp"));
			basescr::setvar( "return", varconn::REQUEST( "return"));
			basescr::setvar( "token", varconn::REQUEST( "token"));
			basescr::setvar( "finalizeco", varconn::REQUEST( "finalizeco"));
			basescr::setvar( "cancelpayment", varconn::REQUEST( "cancelpayment"));
			basescr::setvar( "lastticket", varconn::REQUEST( "lastticket"));
			
			//requeridos para pagos_online
			basescr::setvar( "ref_venta", varconn::REQUEST( "ref_venta"));
			basescr::setvar( "datCompl", varconn::REQUEST( "datCompl"));
			basescr::setvar( "valor", varconn::REQUEST( "valor"));
			basescr::setvar( "tSLimit", varconn::REQUEST( "tSLimit"));
			
			// Dineromail mx
			basescr::setvar("import_dmmx", varconn::REQUEST("PrecioItem_Dolares"));
		
			
		}

		return true;
	}
	
	function filter($params)
	{
		if ( $params)
		{
			$ticketid = filter::ticketid( basescr::getvar( "ticketid"));
			$month = filter::monthid( basescr::getvar( "month"));
            $pm = filter::p_gateway(basescr::getvar( "pm"));
            $import = filter::import( basescr::getvar( "import"));

			basescr::setvar( "ticketid", $ticketid);
			basescr::setvar( "month", $month);
            basescr::setvar( "pm", $pm);
            basescr::setvar( "import", $import);
		}
		
		return true;
	}
	
	function process( $params)
	{
		return true;
	}

	function assign( $params) {

		global $smarty;
		
		$owner = owner_to_ownerid();
		$smarty->assign('owner_id', $owner);
				
		if($owner == 1 || $owner == 2 || $owner == 7 || $owner == 8){ // red - t2
			$smarty->assign("factura_dorso", true);
		}
		
		$user = new user( ca_session::get_userid( ));
		if(basescr::getvar( "lastticket") == "true"){
			$tickets = $user->get_ticket_list(false, 0, 1, $is_last, true, $total);
			$ticketid = $tickets[0]->ticketid;
		}else{
			$ticketid = basescr::getvar( "ticketid");
			$month = basescr::getvar( "month");
			$year = basescr::getvar( "year");
			$pm = basescr::getvar("pm");
			$import = basescr::getvar( "import");

		}
        
       
        
		/*
			auxiliares para solucion de pagos_online
		*/
		$datCompl = basescr::getvar("datCompl");
		$valor = basescr::getvar("valor");
		if (strlen($datCompl) > 0) {
			if (!is_numeric($valor) || $valor < 0) {
				$valor = 0;
				$datCompl= "";
			} else {
				$valor = round($valor, 2);
			}
		}
		if (strlen($datCompl) > 0) {
			$editMonto = false;
			$frmActionPagar = "https://gateway.pagosonline.net/apps/gateway/index.html";
			$frmActionEditar = $this->cabeceraURL . $_SERVER['SERVER_NAME'] . ":" . 
				$_SERVER['SERVER_PORT'] . $_SERVER["PHP_SELF"] . "?ticketid=" . 
				basescr::getvar( "ticketid") . "&pay=1&pm=pagos_online&valor=" . $valor;
		} else {
			$frmActionAceptar = $this->cabeceraURL . $_SERVER['SERVER_NAME'] . ":" . 
				$_SERVER['SERVER_PORT'] . $_SERVER["PHP_SELF"] . "?ticketid=" . 
				basescr::getvar( "ticketid") . "&pay=1&pm=pagos_online";
			$editMonto = true;
		}
		$ref_venta = basescr::getvar("ref_venta");
		if (strlen($ref_venta) > 0) {
			//caso de retorno de pago: pagos_online
			$pm = "pagos_online";
			$ticketid = $ref_venta;
		}
		
		
		switch( $pm ) {
			case "rapipago":
			case "pago_facil":
				
				if(trim($ticketid) == ''){
					$ticketid = "FB-01-123456";
				}
				
                $p_gateways_pago_facil = new p_gateways_pago_facil( ca_session::get_userid( ));
                $smarty->assign( "ticket", 
					$p_gateways_pago_facil->get_ticket( $ticketid, $import ? $import : 0));
                $smarty->assign( "pm_pago_facil", true);
                return true;
			
			case "dinero_mail_mx":
				
				//(!)uniformizar recepcion de variables, GET/POST x basescr::setvar
				$p_gateways_dinero_mail_mx = new p_gateways_dinero_mail_mx(ca_session::get_userid());
				//esta bandera indica al template que se visualizara data referente a la opcion dineroMail mx
				$smarty->assign("pm_dinero_mail_mx", true);
				
				if (isset($_GET["resultado"])) {
				
					$idTrack = $_GET["idTrack"];
					if (is_numeric($idTrack) && $idTrack > 0) {
					
						if ($_GET["resultado"] == "exito") {
							$p_gateways_dinero_mail_mx->trackPeticionClose($idTrack, "exito");
							$smarty->assign("displayResultadoExito", true);
							//$smarty->assign( "ticket", new faketicket()); 
						} else {
							$p_gateways_dinero_mail_mx->trackPeticionClose($idTrack, "fracaso");
							$smarty->assign("displayResultadoFracaso", true);
							//$smarty->assign( "ticket", new faketicket()); 
						}
						
					} else {
					
						$smarty->assign("displayResultadoFracaso", true);
						
					}
						
				} else {
				
					
					$ticket = $p_gateways_dinero_mail_mx->get_ticket($ticketid, $import ? $import : 0);
					
					$import = basescr::getvar("import_dmmx");
					$ticket_dmmx = $p_gateways_dinero_mail_mx->get_ticket($ticketid, $import ? $import : 0);
									
					if (isset($_POST["etapaProceso_dmmx"])) {
						$etapaProceso_dmmx = $_POST["etapaProceso_dmmx"];
					} else {
						$etapaProceso_dmmx = 0;
					}
					
					if($etapaProceso_dmmx == 0) {
						
						$ticket_dmmx->url_action = $_SERVER["REQUEST_URI"];
						//por default asumimos que el proceso se desarrollara normalmente
						//si el 
						$smarty->assign("displayEditor", true);
						$smarty->assign("etapaProceso_dmmx", 1);
						
						
					} elseif($etapaProceso_dmmx == 1) {
					
						$ticket_dmmx->url_action = $_SERVER["REQUEST_URI"];
						$smarty->assign("etapaProceso_dmmx", 2);
						$smarty->assign("displayPreviw", true);
						$smarty->assign("URLRetEditor", $_SERVER["REQUEST_URI"]);
					
					} elseif($etapaProceso_dmmx == 2) {
					
						$idTrack = $p_gateways_dinero_mail_mx->trackPeticion($ticket_dmmx);
						
						$urlBase = "https://" . $_SERVER['SERVER_NAME'] . ":" .  $_SERVER['SERVER_PORT'];
						$ticket_dmmx->DireccionExito = $urlBase . $_SERVER["REQUEST_URI"] . "&resultado=exito&idTrack=" . $idTrack;
						$ticket_dmmx->DireccionFracaso = $urlBase . $_SERVER["REQUEST_URI"] . "&resultado=fracaso&idTrack=" . $idTrack;
						
						//(!)comentar luego de depurar
						//echo "urlExito: " . $ticket_dmmx->DireccionExito . "<hr />";
						//echo "urlExito: " . $ticket_dmmx->DireccionFracaso . "<hr />";
						
						$smarty->assign("etapaProceso_dmmx", 2);
						$smarty->assign("displayProcess", true);
					
					}

					$smarty->assign("ticket", $ticket_dmmx);
					
				}
                
				return true;
				
			case "pago_online":
			global $dbh;

				require_once(INCLUDE_PATH .'nusoap/nusoap.php');
				define("URL_SUB1", 'https://services2.nps.com.ar/ws.php'); // produccion
					
				//define("URL_SUB1", 'https://implementacion.nps.com.ar/ws.php'); // desarrollo

				$crypt_key = "9YqPsJ7ND0PWCmNuPXJG5I4oabKMshd1FSO8jVTwWsSiepc2LuGQAKCkuW6kEilR";
				
					
				ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);	
				
				if(isset($_GET['r'])){
					$soapclient = new soapclient2(URL_SUB1);
				
					if (!$soapclient->getError()) { // obtengo un token
						$psp['MerchantId'] = 'alternativa';
						$psp['PosDateTime'] =  date("Y-m-d H:i:s");
						$psp['QueryCriteria'] = 'T';
						$psp['QueryCriteriaId'] = $_POST['psp_TransactionId'];
						$psp['Version'] = '1.0';
						$hash = md5($psp['MerchantId'].$psp['PosDateTime'].$psp['QueryCriteria'].$psp['QueryCriteriaId'].$psp['Version'].$crypt_key);
						$result = $soapclient->call('SimpleQueryTx', 
										array(array('psp_Version' => $psp['Version'],
												'psp_MerchantId' => $psp['MerchantId'],
												'psp_PosDateTime' => $psp['PosDateTime'],
												'psp_QueryCriteria' => $psp['QueryCriteria'],
												'psp_QueryCriteriaId' => $psp['QueryCriteriaId'],
												'psp_SecureHash' => $hash				
															)));
						$res = $dbh->execute("UPDATE cobranzas_sub1 SET \"psp_ResponseCod_2\" = '". $result['psp_Transaction']['psp_ResponseCod'] ."', 
								\"psp_ResponseMsg_2\" = '". $result['psp_Transaction']['psp_ResponseMsg'] ."', 
								\"psp_ResponseExtended_2\" = '". $result['psp_Transaction']['psp_ResponseExtended'] ."' 
								WHERE \"MerchOrderId\" = '". $result['psp_Transaction']['psp_MerchOrderId'] ."'");
															
						if($result['psp_Transaction']['psp_ResponseCod'] == 0){
							$smarty->assign('resultado_sub1_ok', true);
						}else{
							$smarty->assign('resultado_sub1_ko', true);
							$smarty->assign('codigo_error_sub1', $result['psp_Transaction']['psp_ResponseCod']);
						}
								
						$smarty->assign('result_sub1', true);
						//print_r($result);
						
					}else{
						echo "ERROR";
					}

					
				}
				
				$p_gateways_pago_online = new p_gateways_pago_online( ca_session::get_userid( ));
				
				
				$p_gateways_pago_online = new p_gateways_pago_online( ca_session::get_userid( ));
				

				$smarty->assign( "theticket", $p_gateways_pago_online->get_ticket( $ticketid));
				$profile = new profile(ca_session::get_userid());
				$actual_email = $profile->get_mail_admin( );
			
				
              	if($import && isset($_POST['select_tarjeta']) && $_POST['select_tarjeta'] > 0){
					
						
					
					$soapclient = new soapclient2(URL_SUB1);
				
					
					if (!$soapclient->getError()) { // obtengo un token
						$psp['Version'] = '1.0';
						$psp['MerchantId'] = 'alternativa';
						$psp['TxSource'] = 'WEB';
						$psp['MerchTxRef'] = ca_session::get_userid( ).time();
						$psp['MerchOrderId'] = ca_session::get_userid( ).time();
						$psp['ReturnURL'] = 'https://'. $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'].'?ticketid=FB-0021-00000001&pay=1&pm=pago_online&r=1';
						$psp['FrmLanguage'] = "ES";
						$psp['FrmBackButtonURL'] = 'https://'. $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'].'?ticketid=FB-0021-00000001&pay=1&pm=pago_online';
						$psp['Amount'] = str_replace(".", "", number_format($import, 2));
						$psp['NumPayments'] = '1';
						$psp['Currency'] = '032';
						$psp['Country'] = 'ARG';
						$psp['Product'] = $_POST['select_tarjeta'];
						$psp['CustomerMail'] = $actual_email;
						$psp['MerchantMail'] = 'sebastian@promaker.com.ar';
						$psp['PurchaseDescription'] = 'Pago servicio';
						$psp['PosDateTime'] =  date("Y-m-d H:i:s");


						$hash = md5($psp['Amount'].$psp['Country'].$psp['Currency'].$psp['CustomerMail'].$psp['FrmBackButtonURL'].$psp['FrmLanguage'].$psp['MerchOrderId'].$psp['MerchTxRef'].$psp['MerchantId'].$psp['MerchantMail'].$psp['NumPayments'].$psp['PosDateTime'].$psp['Product'].$psp['PurchaseDescription'].$psp['ReturnURL'].$psp['TxSource'].$psp['Version'].$crypt_key);



						$result = $soapclient->call('PayOnLine_3p', 
										array(array('psp_Version' => $psp['Version'],
												'psp_MerchantId' => $psp['MerchantId'],
												'psp_TxSource' => $psp['TxSource'],
												'psp_MerchTxRef' => $psp['MerchTxRef'],
												'psp_MerchOrderId' => $psp['MerchOrderId'],
												'psp_ReturnURL' => $psp['ReturnURL'],
												'psp_FrmLanguage' => $psp['FrmLanguage'],
												'psp_FrmBackButtonURL' => $psp['FrmBackButtonURL'],
												'psp_Amount' => $psp['Amount'],
												'psp_NumPayments' => $psp['NumPayments'],
												'psp_Currency' => $psp['Currency'], 
												'psp_Country' => $psp['Country'],
												'psp_Product' => $psp['Product'],
												'psp_CustomerMail' => $psp['CustomerMail'],
												'psp_MerchantMail' => $psp['MerchantMail'],
												'psp_PurchaseDescription' => $psp['PurchaseDescription'],
												'psp_PosDateTime' => $psp['PosDateTime'],
												'psp_SecureHash' => $hash
				
															)));
					// DEBUG RESPUESTA SUB1
/*
					echo "<pre>";
					print_r($_SESSION);
					print_r($result);
					exit;
*/


					// Trackeo en db
					
					$res = $dbh->execute("INSERT INTO cobranzas_sub1 
									(\"codigo_cliente\", \"MerchTxRef\", \"MerchOrderId\", \"Amount\", \"Product\", \"psp_ResponseCod\", \"psp_ResponseMsg\", \"psp_TransactionId\", \"Fecha\", \"URL_Implementacion\") 
								VALUES ('". ca_session::get_userid( ) ."', '". $psp['MerchTxRef'] ."', '". $psp['MerchOrderId'] ."','". $psp['Amount'] ."', '". $psp['Product'] ."', '". $result['psp_ResponseCod'] ."', '". $result['psp_ResponseMsg'] ."','". $result['psp_TransactionId'] ."', current_timestamp, '". URL_SUB1 ."')");
				/*	
				var_dump($res);
				var_dump($dbh->ErrorMsg);
				var_dump(pg_last_error());
				exit;
*/
						$smarty->assign('psp_FrontPSP_URL', $result['psp_FrontPSP_URL']);
						
						$smarty->assign('psp_MerchantId', $result['psp_MerchantId']);
						$smarty->assign('psp_TransactionId', $result['psp_TransactionId']);
						$smarty->assign('psp_MerchTxRef', $result['psp_MerchTxRef']);
						$smarty->assign('psp_Session3p', $result['psp_Session3p']);
						
						$smarty->assign('redirect_sub1', true);


					}else{
						echo "ERROR";
					}
				}
				$smarty->assign('pm_pago_online', true);				
			break;
				
			case "dinero_mail_br":
				
				//(!)uniformizar recepcion de variables, GET/POST x basescr::setvar
				//(!)desarrollado a partir de copy+paste del equiv en mx, normalizar nombres
				$p_gateways_dinero_mail_mx = new p_gateways_dinero_mail_br(ca_session::get_userid());
				//esta bandera indica al template que se visualizara data referente a la opcion dineroMail mx
				$smarty->assign("pm_dinero_mail_br", true);
				$smarty->assign("pm_dinero_mail_mx", false);
				
				if (isset($_GET["resultado"])) {
				
					$idTrack = $_GET["idTrack"];
					if (is_numeric($idTrack) && $idTrack > 0) {
					
						if ($_GET["resultado"] == "exito") {
							$p_gateways_dinero_mail_mx->trackPeticionClose($idTrack, "exito");
							$smarty->assign("displayResultadoExito", true);
							//$smarty->assign( "ticket", new faketicket()); 
						} else {
							$p_gateways_dinero_mail_mx->trackPeticionClose($idTrack, "fracaso");
							$smarty->assign("displayResultadoFracaso", true);
							//$smarty->assign( "ticket", new faketicket()); 
						}
						
					} else {
					
						$smarty->assign("displayResultadoFracaso", true);
						
					}
						
				} else {
				
					
					$ticket = $p_gateways_dinero_mail_mx->get_ticket($ticketid, $import ? $import : 0);
					
					$import = basescr::getvar("import_dmmx");
					$ticket_dmmx = $p_gateways_dinero_mail_mx->get_ticket($ticketid, $import ? $import : 0);
									
					if (isset($_POST["etapaProceso_dmmx"])) {
						$etapaProceso_dmmx = $_POST["etapaProceso_dmmx"];
					} else {
						$etapaProceso_dmmx = 0;
					}
					
					if($etapaProceso_dmmx == 0) {
						
						$ticket_dmmx->url_action = $_SERVER["REQUEST_URI"];
						//por default asumimos que el proceso se desarrollara normalmente
						//si el 
						$smarty->assign("displayEditor", true);
						$smarty->assign("etapaProceso_dmmx", 1);
						
						
					} elseif($etapaProceso_dmmx == 1) {
					
						$ticket_dmmx->url_action = $_SERVER["REQUEST_URI"];
						$smarty->assign("etapaProceso_dmmx", 2);
						$smarty->assign("displayPreviw", true);
						$smarty->assign("URLRetEditor", $_SERVER["REQUEST_URI"]);
					
					} elseif($etapaProceso_dmmx == 2) {
					
						$idTrack = $p_gateways_dinero_mail_mx->trackPeticion($ticket_dmmx);
						
						$urlBase = "https://" . $_SERVER['SERVER_NAME'] . ":" .  $_SERVER['SERVER_PORT'];
						$ticket_dmmx->DireccionExito = $urlBase . $_SERVER["REQUEST_URI"] . "&resultado=exito&idTrack=" . $idTrack;
						$ticket_dmmx->DireccionFracaso = $urlBase . $_SERVER["REQUEST_URI"] . "&resultado=fracaso&idTrack=" . $idTrack;
						
						//(!)comentar luego de depurar
						//echo "urlExito: " . $ticket_dmmx->DireccionExito . "<hr />";
						//echo "urlExito: " . $ticket_dmmx->DireccionFracaso . "<hr />";
						
						$smarty->assign("etapaProceso_dmmx", 2);
						$smarty->assign("displayProcess", true);
					
					}
					
					//echo "<pre>" . var_export($ticket_dmmx, true) . "</pre><hr />";
					$smarty->assign("ticket", $ticket_dmmx);
					
				}
                
				return true;
				
            case "pago_universal":
                $p_gateways_pago_universal = new p_gateways_pago_universal( ca_session::get_userid( ));
                if ( $import && $ticketid) {
                    // Uso el ticketid, para saber que moneda es el importe.
                    $ticket = $p_gateways_pago_universal->get_ticket( $ticketid);
                    $import = number_format( ( float)$p_gateways_pago_universal->amount_to_pesos_argentinos( $import, $ticket->total_moneyid, $ticket->date), 2);
                    
                    // Ye tenemos un importe, hace el redirect a Pago Universal.
                    $trans_id = $p_gateways_pago_universal->get_trans_id( $ticketid, $import);
                    $ifvar = owner::pago_universal_name( );
                    $hash = sha1( $import . $trans_id . $ifvar . $ticketid . DEF_CA_SECRET);
                    
                    $url = ( "PU/pu_sendpayorder.php?total=" . urlencode( $import) . "&trans_id=" . urlencode( $trans_id) . "&if=" . urlencode( $ifvar) . "&ticketid=" . urlencode( $ticketid) . "&h=" . urlencode( $hash));
                    clientcontrol::redirect( $url);
                }
                else if ( $ticketid)
                {
                    // Debemos pedir que confirme el importe.
		            $smarty->assign( "ticket", $p_gateways_pago_universal->get_ticket( $ticketid));
                    $smarty->assign( "ticket", $p_gateways_pago_universal->get_ticket( $ticketid));
                    $smarty->assign( "pm_pago_universal", true);
                }
				else // Pago no asociado a factura
				{
					if($import)
					{
						// Ye tenemos un importe, hace el redirect a Pago Universal.
						$trans_id = $p_gateways_pago_universal->get_trans_id( $ticketid, $import);
						$ifvar = owner::pago_universal_name( );
						$hash = sha1( $import . $trans_id . $ifvar . $ticketid . DEF_CA_SECRET);
						/*
						echo "IMPORT:". $import;
						echo "<br>TRANSID: ". $trans_id;
						echo "<br>IFVAR: ". $ifvar;
						echo "<br>TICKETID: ". $ticketid;
						echo "<br>HASH: ". $hash;
						exit;
						*/
						$url = ( "PU/pu_sendpayorder.php?total=" . urlencode( $import) . "&trans_id=" . urlencode( $trans_id) . "&if=" . urlencode( $ifvar) . "&ticketid=" . urlencode( $ticketid) . "&h=" . urlencode( $hash));
						clientcontrol::redirect( $url);
					}
					else
					{
						$smarty->assign( "pm_pago_universal", true);
					}
				}
                return true;

            case "dinero_mail":
				
				if($ticketid){
					$p_gateways_dinero_mail = new p_gateways_dinero_mail( ca_session::get_userid( ));
					$smarty->assign( "ticket", $p_gateways_dinero_mail->get_ticket( $ticketid, $import ? $import : 0));
				}else{
					$fakeTicket = new faketicket();
					$user = new user( ca_session::get_userid( ));
					$fakeTicket->client = $user->userid." - ".$user->get_titular();
					$fakeTicket->ticketid = "";
					$tmp_gateways_dinero_mail = new p_gateways_dinero_mail( ca_session::get_userid( ));
					$tmp_ticket = $tmp_gateways_dinero_mail->get_ticket(NULL, $_GET["import"]);
					
					$fakeTicket->banamex_account = $tmp_ticket->banamex_account;
					$fakeTicket->banamex_ref = $tmp_ticket->banamex_ref;
					$fakeTicket->original_currency = $user->get_currency_desc(1);
					$fakeTicket->dollar_simbol = $user->get_currency(1);
					$fakeTicket->total_dollars = $tmp_ticket->total_dollars;
					
					$cot_fact = ca_currency::get_last_quotation_by_id( 1 );
					$cot_medio = ca_currency::get_last_quotation_by_id( 3 ); // $MX
					$cot = $cot_fact['cotizacion'] / $cot_medio['cotizacion'];
					if((float)($fakeTicket->total_dollars) > 0.0){
						$fakeTicket->total_string = $user->get_currency(3)." ".number_format($fakeTicket->total_dollars * $cot, 2)." (".$user->get_currency(1)." ".$fakeTicket->total_dollars.")";
					}else{
						$fakeTicket->total_string = "";
					}
		
					$smarty->assign( "ticket", $fakeTicket); 
				}
                $smarty->assign( "pm_dinero_mail", true);
                return true;
			
			case "pagos_online":
				
				if (strlen($ref_venta) == 0) {
					
					/*
						muestra los datos que se enviaran a pagos_online
						permite al usuario definir un monto customizado.
					*/
					
					//datos para iniciar llamada de pago
					$p_gateways_pagos_online = new p_gateways_pagos_online( ca_session::get_userid( ));
					if (strlen($valor) > 0) {
						$dTicket = $p_gateways_pagos_online-> get_ticket($ticketid, $valor);
					} else {
						$dTicket = $p_gateways_pagos_online-> get_ticket($ticketid);
					}
					
					//el site de pagos online devolvera muchos parametros via GET
					//concatenados a continuacion de url_respuesta
					//(!)originalment.era https/--\ (se requiere ajustar)
					$dTicket->url_respuesta = $this->cabeceraURL . $_SERVER['SERVER_NAME'] . ":" . 
						$_SERVER['SERVER_PORT'] . $_SERVER["PHP_SELF"];

					//(!)determinar como manejaremos esto + caso especial: codigo_respuesta_pol = 24
					//(!)observa que estoy forzando parte de la ruta 
					
					
					$dTicket->url_confirmacion = $this->cabeceraURL . $_SERVER['SERVER_NAME'] . 
						":" .  $_SERVER['SERVER_PORT'] .
						 "/beta-cuenta/procesaPago_PagosOnline.ca";
					
					$smarty->assign("ticket", $dTicket);
					$smarty->assign("pm_pagos_online_modo", $editMonto);
					if ($editMonto) {
						$smarty->assign("pm_pagos_online_frmAction", $frmActionAceptar);
					} else {
						$smarty->assign("pm_pagos_online_frmAction", $frmActionPagar);
						$smarty->assign("pm_pagos_online_frmAction2", $frmActionEditar);
					}
					$smarty->assign("pm_pagos_online", true);
		
						
				} else {
					
					require_once(INCLUDE_PATH . "data/pagos_online_gw.php");
					$idRespuesta = pagos_online::verificaRespuesta($ref_venta);
					
					//no estoy seguro de esto, deberia hacer que se visualize
					//la referencia directa

					$ticket = array("ticketid" => $ref_venta);
					$smarty->assign("ticket", $ticket);
					
					if ($idRespuesta != 1) {
						//URL para pasar parametros de analisis de limite de tiempo en re-call
						$tSLimit = basescr::getvar("tSLimit");
						$timeOut = false;
						if (strlen($tSLimit) == 0) {
							$tSLimit = time() + 20;	//el limite de tiempo sera de 200s
						} else {
							if ($tSLimit < time()) $timeOut = true;
						}
						$MetaURLRefresh = "10;" . $this->cabeceraURL . $_SERVER['SERVER_NAME'] . ":" . 
							$_SERVER['SERVER_PORT'] . $_SERVER["PHP_SELF"] . 
							"?ref_venta=" . $ref_venta . "&tSLimit=" . $tSLimit;
							
					}
					if ($timeOut) {
						$smarty->assign("pm_pagos_online_respuesta_error", true);
					} else {
						switch($idRespuesta) {
							case -1:
								//(!)esta fallando la consulta, muestro como en espera
								//pero no es lo correcto
								$smarty->assign("pagos_online_incAutoLoadMetaTag", true);
								$smarty->assign("pagos_online_autoLoadMetaTagVal", $MetaURLRefresh);
								$smarty->assign("pm_pagos_online_respuesta", true);
								break;
								
							case 0:
								//no se creo el registro aun
							
							case 15:
								//transaccion en proceso de validacion
							
							//case 24:
								//transaccion parcial aprobada?(!)
								//descartado, es responsabilidad del comercio completar lo
								//quefalta (o sea obtener los fondos)
							
							case 9994:
								//transaccion pendiente p confirmar?(!)
								
								//habilitamos el bloque que indica que se espera la verificacion						
								$smarty->assign("pagos_online_incAutoLoadMetaTag", true);
								$smarty->assign("pagos_online_autoLoadMetaTagVal", $MetaURLRefresh);
								$smarty->assign("pm_pagos_online_respuesta", true);
								break;
								
							case 1:
							case 24:
								$smarty->assign("pm_pagos_online_respuesta_exito", true);
								break;
							
							default:
								//(!)desde luego habria que hacer algo aqui tambien
								$smarty->assign("pagos_online_incAutoLoadMetaTag", true);
								$smarty->assign("pagos_online_autoLoadMetaTagVal", $MetaURLRefresh);
								$smarty->assign("pm_pagos_online_respuesta", true);
								break;
								
						}
					}

				}
				
                return true;
				
				/*
				*/
				
			case "paypal":

				if (basescr::getvar("checkoutpp") == 1){
				
					if (basescr::getvar( "return") == 1){
						if(basescr::getvar( "cancelpayment") == 1){
							$p_gateways_paypal = new p_gateways_paypal( ca_session::get_userid( ));
							$smarty->assign( "ticket", $p_gateways_paypal->get_ticket( $ticketid));
							$smarty->assign( "pm_paypal", true);
							$smarty->assign( "checkoutpp", true);
							$smarty->assign( "cancelpay", true);
							return true;
						}

						if(basescr::getvar( "finalizeco") == 1){
							// TERMINA LA TRANSACCION
							$paypal = new paypal();
							$paypal->setToken(basescr::getvar( "token"));
													
							if ($paypal->finalizeTransaction()){
								$result = $paypal->getCheckoutResult();
								$p_gateways_paypal = new p_gateways_paypal( ca_session::get_userid( ));
								$theTicket = $p_gateways_paypal->get_ticket( $ticketid);
								$msg = lang("PAYPAL_TRANSACCION_OK") . $theTicket->total_simbol . 
									" " . $result["PP_PAYMENTAMOUNT"] . lang("PAYPAL_TRANSACCION_OK2");
							}else{
								$msg = lang("PAYPAL_TRANSACCION_ERROR") . $paypal->getErrorMessage();
							}
							if(!$paypal->logTransaction()){
								switch(ca_session::get('owner')){
									case "hola":
										$email = "cobranzas@holaargentina.com";
									break;
									case "red":
										$email = "cobranzas@red-alternativa.com";
									break;
								}
								$paypal->mailPayment($email);
							}
							
							$p_gateways_paypal = new p_gateways_paypal( ca_session::get_userid( ));
							$smarty->assign( "ticket", $p_gateways_paypal->get_ticket( $ticketid));
							$smarty->assign( "pm_paypal", true);
							$smarty->assign( "checkoutpp", true);
							$smarty->assign( "msg_result", $msg);
							return true;					
						}else{
							// CONFIME SU PAGO...
							$paypal = new paypal();
							$paypal->setToken(basescr::getvar( "token"));
													
							$result = $paypal->getCheckoutResult();
							$p_gateways_paypal = new p_gateways_paypal( ca_session::get_userid( ));
							$smarty->assign( "ticket", $p_gateways_paypal->get_ticket( $ticketid));
							$smarty->assign( "pm_paypal", true);
							$smarty->assign( "checkoutpp", true);
							$smarty->assign( "confirmpay", true);
							$smarty->assign( "confirmpayammount", 
								number_format($result["PP_PAYMENTAMOUNT"], 2));
							return true;	
						
						}
					}else{

						$cancelURL = "https://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . $_SERVER["PHP_SELF"] . "?ticketid=" . basescr::getvar( "ticketid") . "&pay=1";
						$returnURL = $cancelURL . "&pm=paypal" . "&checkoutpp=1&return=1";

						$paypal = new paypal($import, $returnURL, $cancelURL, ca_session::get('owner'), ca_session::get_userid( ), "CUENTA (". ca_session::get('owner') .")", basescr::getvar( "ticketid"));

						$paypal->setExpressCheckout();
						
					}
				}else{
					$p_gateways_paypal = new p_gateways_paypal( ca_session::get_userid( ));

					$paypal_ticket = $p_gateways_paypal->get_ticket( $ticketid);
					
	                $smarty->assign("ticket", $p_gateways_paypal->get_ticket( $ticketid));
					
					$smarty->assign("pm_paypal", true);
					return true;
				}
        	default:
				
				//...
				break;
				
		}
		
		

        if ( basescr::action_pay() && !$pm) {
		
            // We set the payment gateways to use.
            $pg_list = p_gateways::get_list( );
            /*
            Anteriormente la lista de medios de pago salia del archivo de configuracion del owner, ahora esta saliendo de la db
            $owner_pg = owner::payment_gateways( );
            */
            
            $owner_pg = p_gateways::get_owner_list(ca_session::get("ownerId"), $user->get_pais());

            foreach( $pg_list as $key => $pg) {
            	
                if ( !in_array( $pg[ "id"], $owner_pg)) {
                    unset( $pg_list[ $key]);
                }
            }
            $smarty->assign("payment_gateways", $pg_list);
        }
        

		$user = new user( ca_session::get_userid( ));
		if($ticketid){
		/* Hay un problema con algunas facturas donde llega factura_suc 100, en el tpl hay una condicion que verifica este numero, si es mejor de 100 funciona todo ok, sino hardcodea la direccion de facturacion
		echo "<pre>";
		var_dump($user->get_ticket( $ticketid, null));
		echo "</pre>";
		*/
		

		
			 if(isset($_GET['email_pdf'])){
				
				if(empty($_POST)){
				
				
					$smarty->assign('email_pdf', true);
					$profile = new profile(ca_session::get_userid());
						
					$smarty->assign('eaddr', $profile->get_mail_admin( ));
					unset($_GET['pdf']);
				}else{
					$_GET['pdf'] = true;
				}
				//exit;
			 }
			 
			 if(isset($_GET['pdf']) || isset($_GET['pdf_dorso'])){
		    	$path_efacturas = INCLUDE_PATH . 'efacturas/';

				require($path_efacturas.'efactura.class.php');
				$owner = owner_to_ownerid();
				
				if($owner == 1 || $owner == 2){
					$nombre_owner = 'red';
					$smarty->assign("factura_dorso", true);
				}elseif($owner == 3){
					$nombre_owner = 'hola';
				}elseif($owner == 4 || $owner == 5 || $owner == 6){
					$nombre_owner = 'latinatel';
				}elseif($owner == 7 ){
					$nombre_owner = 'telephone2';
					$smarty->assign("factura_dorso", true);
				}elseif($owner == 8){
					$nombre_owner = 't2';
					$smarty->assign("factura_dorso", true);				
				}
				
				$real_ticket = $month ? $user->get_ticket( null, $month, $year) : $user->get_ticket( $ticketid, null);
				
				
				$efactura = new Efactura($path_efacturas, $nombre_owner, $real_ticket);
			
				$desde = '01/01/1990';
				$hasta_tmp = explode("/", $real_ticket->date); // Tiene que estar en mm/dd/YYYY
				$hasta = $hasta_tmp[1] ."/" .$hasta_tmp[0] ."/". $hasta_tmp[2];
				
				$ccd = new ca_cc(ca_session::get_userid(), $desde, $hasta);
				
				$saldo = $ccd->cc_get_saldo_final($desde, $hasta);
				
				$saldo = $saldo - $real_ticket->itotal;
				
				$efactura->saldo_a_fecha_emision = number_format(($saldo + $real_ticket->itotal), 2, '.', '');
				
				
				$myticket = $user->get_ticket( $ticketid);
				
				list($tipodoc, $sucdoc, $numdoc) = explode('-', $ticketid);
				$barcode_total = p_gateways_pago_facil::static_get_barcode_number($ticketid, $tipodoc, $sucdoc, $numdoc, $myticket, $real_ticket->itotal, ca_session::get_userid());
				
				$efactura->barcode_total = $barcode_total;
				
								
				$barcode_saldo = p_gateways_pago_facil::static_get_barcode_number($ticketid, $tipodoc, $sucdoc, $numdoc, $myticket, $efactura->saldo_a_fecha_emision, ca_session::get_userid());
				
				
				$efactura->barcode_saldo = $barcode_saldo;
				
				
				global $dbh;
				/*
				$efactura->frase_pie = $dbh->getOne("SELECT frase FROM fact_frases WHERE ownerid = ". $owner ." AND mes = ". date("m") ." AND anio = ". date("Y"));
				*/
				
				$efactura->frase_pie = $dbh->getAll("SELECT Leyenda FROM ventascabwebleyendas WHERE va_fcomp = ? AND va_suc = ? AND va_fnro = ? AND va_clnro = ? ORDER BY id",
													array(
													$tipodoc, $sucdoc, $numdoc, ca_session::get_userid()
													));
					
				$owner = owner_to_ownerid();
				
		
				if($owner == 1 || $owner == 2 || $owner == 7 || $owner == 8){ // red - t2
					$smarty->assign("factura_dorso", true);
				}
				if(isset($_GET['pdf'])){
					if(isset($_GET['email_pdf'])){
						$r = $efactura->output(false, true);
						
						require('../../beta-cuenta/scripts/includes/class.phpmailer.php');
						
						$mailer = new PHPMailer();
						
						if($owner == 1 || $owner == 2){
							$mailer->From = 'asistencia@alternativa.com.ar';
							$mailer->FromName = 'Alternativa';
							$mailer->Subject = 'Alternativa - Factura y detalle de consumo';
							$tpl_name = 'facturas_mail_red';
							$pdf_owner_name = 'Alternativa';
						}elseif($owner == 3){
							$mailer->From = 'asistencia@holatel.com';
							$mailer->FromName = 'HolaTel';
							$mailer->Subject = 'HolaTel - Factura y detalle de consumo';
							$tpl_name = 'facturas_mail_hola';
							$pdf_owner_name = 'HolaTel';
						}elseif($owner == 7 || $owner == 8){
							$mailer->From = 'noreply@telephone2.com';
							$mailer->FromName = 'Telephone 2';
							$mailer->Subject = 'Telephone 2 - Factura y detalle de consumo';
							$tpl_name = 'facturas_mail_t2';
							$pdf_owner_name = 'Telephone2';
						}elseif($owner == 5){
							$mailer->From = 'asistencia@latinatel.net';
							$mailer->FromName = 'Latinatel';
							$mailer->Subject = 'Latinatel - Factura y detalle de consumo';
							$tpl_name = 'facturas_mail_latinatel';
							$pdf_owner_name = 'Latinatel';
						}elseif($owner == 4){
							$mailer->From = 'atendimento@latinatel.net';
							$mailer->FromName = 'Latinatel';
							$mailer->Subject = 'Latinatel - Fatura e detalhamento de consumo';
							$tpl_name = 'facturas_mail_viatel';
							$pdf_owner_name = 'Latinatel';
						}					
						
						$mailer->isHTML(true);
						
						$email_template = implode("", file("../../beta-cuenta/email_tpl/es/".$tpl_name.".tpl"));
						
						$search = array("<%cliente_id%>", "<%rsocial%>");
						$replace = array(ca_session::get_userid( ), $user->get_titular());
						$email_template = str_replace($search, $replace, $email_template);		
						
						$mailer->Body = $email_template;
						
						$nombre_pdf = $pdf_owner_name .'_'.$tipodoc .'_' . $sucdoc .'_' .$numdoc .'_Fecha_' . str_replace('/', '-', $efactura->fecha_emision) .'_Cliente_'. $efactura->codigo_cliente.'.pdf';
						$mailer->AddStringAttachment($r, $nombre_pdf);
			
			
						$profile = new profile(ca_session::get_userid());
						
						$mailer->AddAddress($_POST['eaddr'], $user->get_titular());
						
						

						$res = $mailer->Send();
							
						$continuar_carga_pagina = true;
						
						$smarty->assign('envio_mail_ok', true);
						
					}else{

						$efactura->output();
					}
				}else{
					$efactura->output_dorso();
				}
				
				if(!isset($continuar_carga_pagina)){
					exit;
				}
			
		    }else{
		    	$smarty->assign( "ticket", $month ? $user->get_ticket( null, $month, $year) : $user->get_ticket( $ticketid, null));
		    	
		    }
		}else{

			if($month){
				$tmpTicket = $user->get_ticket( null, $month, $year);
				if(!$tmpTicket){
					$smarty->assign( "noticket", true);
					$smarty->assign( "ticket", new faketicket()); 
				}else{
					$smarty->assign( "ticket", $tmpTicket);	
				}


			}else{
				$smarty->assign( "ticket", new faketicket()); 
			}
		}
		$smarty->assign( "ticket_sel_month", $month ? $month : false);
		$smarty->assign( "ticket_sel_year", $year ? $year : false);
		$smarty->assign( "ticket_months", $user->get_ticket_months( ));
		$smarty->assign( "ticket_years", $user->get_ticket_years( ));
		$smarty->assign( "info_contact", owner::info_contact( ));
		$smarty->assign( "info_facturation", owner::info_facturation( ));
		$smarty->assign( "show_iva_details", owner::show_iva_details( ));

        

		return true;
	}
}
			
class faketicket {
	
	var $ticketid = ""; // workaround para no tener que modificar la aplicacion por un cambio tan trivial
	
}



?>

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
		
		$msg_error = "";
		$msg_info = "";
		
		$userData = array();
		$userData["user_calle"] = "";
		$userData["user_nro"] = "";
		$userData["user_piso"] = "";
		$userData["user_dpto"] = "";
		$userData["user_ciudad"] = "";
		$userData["user_localidad"] = "";
		$userData["user_cp"] = "";
		$userData["user_pcia"] = "";
		
		$display_invoicePrivData = true;
		$display_form = true;
		
		if (isset($_POST["updateInvoiceData"])) {
			
			$userData["user_calle"] = $_POST["user_calle"];
			$userData["user_nro"]= $_POST["user_nro"];
			$userData["user_piso"] = $_POST["user_piso"];
			$userData["user_dpto"] = $_POST["user_dpto"];
			$userData["user_ciudad"] = $_POST["user_ciudad"];
			$userData["user_localidad"] = $_POST["user_localidad"];
			$userData["user_cp"]= $_POST["user_cp"];
			$userData["user_pcia"]= $_POST["user_pcia"];
			
			$datosValidos = true;
			
			//verificacion inicial muy simple: que no sea long = 0
			foreach($userData as $key => $item) {
				if($key != "user_piso" && $key != "user_dpto"){
					if (strlen($item) == 0) {
						$datosValidos = false;
						$msg_info = lang("INVOICEDATA_DATA_ERROR");
						break;	
					}
				}	
			}
			if ($datosValidos) {
				
				$profile = new profile(ca_session::get_userid());
				$actual_email = $profile->get_mail_admin();
				$rSocial = $profile->getRSocial();
				
				
			
				//contiene direccion administracion: owner::addr_support()
				if(( int)owner_to_ownerid( ca_session::get( "owner")) == 7){ // SI el owner es T2 uso un template mas amigable porque no se importa a goldmine
					$ca_email = new ca_email("mail_gm_datos_facturacion_T2", ca_session::language_get());
				}else{
					$ca_email = new ca_email("mail_gm_datos_facturacion", ca_session::language_get());
				}
				/*
				$ca_email->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, 
		        	new ca_email_recipient("sebastianhgil@gmail.com", "sebastianhgil@gmail.com"));
		     */
		        /* Esto setea la direccion de administracion */
		        
				$ca_email->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, 
		        	new ca_email_recipient('{$GM-WEBIMPORT$} <'.owner::addr_support() .'>', '{$GM-WEBIMPORT$} <'.owner::addr_support() .'>'));
					
		           
				$ca_email->set_tag_replacement( "[MAIL_FROM]", '<'.$actual_email.'>');
		        $ca_email->set_tag_replacement( "[CLIENT_ID]", ca_session::get_userid());	
				$ca_email->set_tag_replacement( "[RAZON_SOCIAL]", $rSocial);
				$ca_email->set_tag_replacement( "[FECHA_ENVIO]", date("d/m/Y H:i:s"));

		        foreach($userData as $key => $val) {
					$ca_email->set_tag_replacement( "[".$key."]", $val);	
				}
				
				$ca_email->_txtbody = true; // Manda el mail en texto plano
				
		        $res = $ca_email->send_pear();	//verificar si hubo exito
				if ($res) {
					
					$msg_info = lang("PROFILE_DATA_SAVED_INVOICE_INFO");
					$display_form = false;
					
				} else {
					$msg_error = lang("EMAIL_SEND_ERROR");
				}
			
			}
			
		}
		
		if ($display_invoicePrivData) {
			if (owner_to_ownerid() == 3) {
			
				$smarty->assign("display_invoicePrivData", false);
				
			} else {
				
				$smarty->assign("display_invoicePrivData", true);
				
				$smarty->assign("msg_errorEmail", $msg_error);
				$smarty->assign("msg_infoEmail", $msg_info);
				
				foreach($userData as $key => $val) {
					$smarty->assign($key, $val);
				}
				
			}
		} else {
		
			$smarty->assign("display_invoicePrivData", false);
			$smarty->assign("msg_infoEmail", $msg_info);
			
		}
		
		if($display_form){
			$smarty->assign("display_form", true);
		}
			
		return true;    // we always show the form
		
	}
	
}

?>

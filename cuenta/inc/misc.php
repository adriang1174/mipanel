<?

/* misc contiene metodos de tipo general que suelen ser usados en todo tipo de lugares.
 * Toda funcion que no se sepa donde colocarla, seguramente quedara bien dentro de misc.
 */

class misc {

	function log_action($user_id, $query, $action, $usuario_id){
		global $dbh;

		/*
		echo "LOG ---> USERID: " . $user_id . "<br>";
		echo "LOG ---> CUSTOMERID: " . $usuario_id . "<br>";
		echo "LOG ---> ACTION: " . $action . "<br>";
		echo "LOG ---> INTERFACE: " . $query . "<br>";
		*/
		
		
		$q = "INSERT INTO logacciones (cliente_id, fecha, accion, query, usuario_id) VALUES (?, current_timestamp, ?, ?, ?)";
		$params = array($user_id, $action, $query, (int)($usuario_id));
		
		$res = $dbh->execute($q, $params);
	}
	
	function create_vtiger_tt($cliente_id, $tipo='cambio_forma_pago', $params=array()){

		include_once('vtwsclib/Vtiger/WSClient.php');
		$url = 'http://201.216.230.56';
		
		$client = new Vtiger_WSClient($url);
		
		$login = $client->doLogin('admin', 'bWo0eLUZ1BLcXZxm'); 


		

		if(!$login){ 

			$ca_email = new ca_email("general_pourpose", 'es');
			 
			// Para enviar un mail de prueba a cualquier casilla
			$ca_email->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, 
				new ca_email_recipient("agarcia@alternativa.com.ar", "agarcia@alternativa.com.ar"));
			 
			/* Esto setea la direccion de administracion 
			$ca_email->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, 
				new ca_email_recipient(owner::addr_support(), owner::addr_support()));
			*/
			$user = new user( ca_session::get_userid( ));	
			
			 
			$ca_email->set_tag_replacement( "[ADDR_SUPPORT]", owner::addr_support());	
			$ca_email->set_tag_replacement( "[CODIGO]", $cliente_id);	
			$ca_email->set_tag_replacement( "[TITULAR]", $user->get_titular());	
			$ca_email->set_tag_replacement( "[subject]", 'Error de conexion a VTiger');	
			$ca_email->set_tag_replacement( "[data]", 'El '. date("d/m/Y") . ' a las '. date("H:i:s") . ' se registro un error de conexion con vtiger, ip: '. $url);	
			 
			$res = $ca_email->send_pear();	//verificar si hubo exito
			
		}else{

			$query = "SELECT * FROM Accounts WHERE cf_604 = '". $cliente_id ."'";
			$records = $client->doQuery($query);

			
			if($tipo == 'cambio_email'){

				$res = $client->doCreate('HelpDesk', 
								array(
									'ticketcategories' => 'Servicio',
									'cf_601' => 'Cambio de Datos',
									'createdtime' => date('d/m/Y'),
									'solution' => 'El cliente cambió el mail administrativo en Mi Panel. Nuevo mail: '. $params['email']. '. Codigo cliente: '. $cliente_id,
									'modifiedtime' => date('d/m/Y'),
									'parent_id' => $records[0]['id'],
									'ticketpriorities' => 'Normal',
									'ticketseverities' => 'Minor',
									'assigned_user_id' => '20x49',
									'ticketstatus' => 'Open',
									'ticket_title' => 'Cambio de mail administrativo desde Mi Panel. Nuevo mail: '. $params['email']. '. Codigo cliente: '. $cliente_id
										));	
										
				
			}else{ // cambio_forma_pago
			
				$res = $client->doCreate('HelpDesk', 
								array(
									'ticketcategories' => 'Cobranzas',
									'cf_601' => 'Cambio de Datos',
									'createdtime' => date('d/m/Y'),
									'description' => 'Cambio de forma de pago desde Mi Panel. Codigo cliente: '. $cliente_id,
									'modifiedtime' => date('d/m/Y'),
									'parent_id' => $records[0]['id'],
									'ticketpriorities' => 'Normal',
									'ticketseverities' => 'Minor',
									'assigned_user_id' => '20x50',
									'ticketstatus' => 'Closed',
									'ticket_title' => 'Cambio de forma de pago desde Mi Panel'
										));
			}	
			
			return $res;			
		}
	}


	function enviar_mail_usuario($user_name, $user_email, $texto_notif){
		if(trim($texto_notif) == ''){
			return;
		}
		$owner = owner_to_ownerid();

		if($owner == 1 || $owner == 2){ // red
			if(file_exists(PATH_EMAIL_TPL.'es/mail_user_red.eml')){
				$mail_template = 'mail_user_red';
			}else{
				$mail_template = 'mail_user';
			}
		}else if($owner == 3){ // hotatel
			if(file_exists(PATH_EMAIL_TPL.'es/mail_user_hola.eml')){
				$mail_template = 'mail_user_hola';
			}else{
				$mail_template = 'mail_user';
			}
		}else if($owner == 4){ // viatel
			$mail_template = 'mail_user';
		} else if($owner == 7 || $owner == 8){ // t2
			$mail_template = 'mail_user';
		}
		
		//echo "TEMPLATE : ". $mail_template;
		
		$user = new user( ca_session::get_userid( ));
		
        $ca_email = new ca_email( $mail_template, ca_session::language_get( ));
		
		$ca_email->add_to( CA_EMAIL_RECIPIENT_TYPE_TO, new ca_email_recipient($user_name, $user_email));
		//$ca_email->add_to( CA_EMAIL_RECIPIENT_TYPE_TO, new ca_email_recipient($user_name, "sebastianhgil@gmail.com"));
		//$ca_email->add_to( CA_EMAIL_RECIPIENT_TYPE_TO, new ca_email_recipient($user_name, "fstecher@alternativa.com.ar"));
		
		
        $ca_email->set_tag_replacement("[TEXT_NOTIF]", $texto_notif);
		$ca_email->set_tag_replacement("[ADDR_SUPPORT]", owner::owner_name() . '<'.owner::addr_support( ) .'>');
		$ca_email->set_tag_replacement("[RSOCIAL]", $user->get_titular());
		$ca_email->set_tag_replacement("[CLIENTE_ID]", ca_session::get_userid( ));
        
        $ca_email->set_subject("Mi Panel - Modificación en la configuración del servicio");
        
       
        //echo "Texto notif: ". $texto_notif;
        //$ca_email->send_pear( ); // SACAR !!!!!
		require("envia_mail.php");
	}
	
	
	function enviar_mail_GM($user_id, $accion, $variables) {
		if(count($variables) > 0){
			$str_variables = "";
			foreach($variables as $llave => $valor){
				if($llave != "x" && $llave != "y" && $llave != "process"){
					$str_variables .= $llave . " = " . $valor . ", ";
				}
			}
			$str_variables = substr($str_variables, 0, strlen($str_varibles) - 2);
			$str_variables .= ".";
		}
		
		$description_text = "Accion: ". $accion ."\nValores: " .$str_variables;
        
    $ca_email = new ca_email( CA_EMAIL_TEMPLATE_EML_GOLDMINE, ca_session::language_get( ), true);
		
		$ca_email->add_to( CA_EMAIL_RECIPIENT_TYPE_TO, new ca_email_recipient('{$GM-WEBIMPORT$}', 
			"importaciongm@alternativa.com.ar"));
		/*
		$ca_email->add_to( CA_EMAIL_RECIPIENT_TYPE_TO, new ca_email_recipient('{$GM-WEBIMPORT$}', 
			"flenfan@promaker.com.ar"));
		*/
		/*
		$ca_email->add_to( CA_EMAIL_RECIPIENT_TYPE_TO, new ca_email_recipient('{$GM-WEBIMPORT$}', 
			"sebastian@promaker.com.ar"));
		$ca_email->add_to( CA_EMAIL_RECIPIENT_TYPE_CC, new ca_email_recipient("Adrian Garcia", 
			"agarcia@alternativa.com.ar"));
		$ca_email->add_to( CA_EMAIL_RECIPIENT_TYPE_CC, new ca_email_recipient("Sebastian Gil", 
			"sebastianhgil@gmail.com"));
		*/
        $ca_email->set_tag_replacement( "[CLIENT_ID]", ca_session::get_userid( ));
        $ca_email->set_tag_replacement( "[USER_EMAIL]", $user_email);
        $ca_email->set_tag_replacement( "[DESCRIPTION_TEXT]", $description_text);
				$ca_email->set_tag_replacement( "[FECHA_HORA]", date('d/m/Y H:i:s'));
       	require("envia_mail.php");
	}
	
	/*
	 * translate_language convierte la definicion de lenguaje que tipicamente mandan
	 * los browsers en un lenguaje tipico de 2 letras. Hasta el momento, normaliza su
	 * salida a los lenguajes en, es, fr, de e it. Si se necesitan otros, hay que
	 * modificar la funcion.
	 */
	
	function translate_language( $browser_http_accept_language, $canbenull = false)
	{
		$langs = explode( ",", ( string)$browser_http_accept_language);
		foreach( $langs as $key => $lang)
		{
			$real_lang = explode( ";", $lang);
			$real_lang = $real_lang[ 0];

			$matches = array( );
			if ( preg_match( "/^([a-z]{2})$/i", $real_lang, $matches))
			{
				if ( strcmp( $matches[ 1], "en") == 0
					|| strcmp( $matches[ 1], "es") == 0
					|| strcmp( $matches[ 1], "fr") == 0
					|| strcmp( $matches[ 1], "de") == 0
					|| strcmp( $matches[ 1], "it") == 0
				)
					return strtolower( $matches[ 1]);
			}

			$matches = array( );
			if ( preg_match( "/^([a-z]{2})-([a-z]{2})$/i", $real_lang, $matches))
			{
				if ( strcmp( $matches[ 1], "en") == 0
					|| strcmp( $matches[ 1], "es") == 0
					|| strcmp( $matches[ 1], "fr") == 0
					|| strcmp( $matches[ 1], "de") == 0
					|| strcmp( $matches[ 1], "it") == 0
				)
					return strtolower( $matches[ 1]);
			}
		}

		if ( $canbenull)
			return false;
		
		return DEF_DEFAULT_LANGUAGE;
	}

	static function num_to_semantic_str($value)
	{
	
	    global $script_owner, $script_owner_id;
	
	   if(isset($script_owner) && $script_owner === true){
	        $owner = $script_owner_id;
	    }else{
	        $owner = owner_to_ownerid();
	    }
	
	   
	    if($owner == 5){
	        $menos = 'minus';
	        $con = 'with';
	        $centavos = 'cents';
	    }else{
	        $menos = 'menos';
	        $con = 'con';
	        $centavos = 'centavos';
	    }
	
	
        $value = trim($value);
        if(!strlen($value))
            return "";

		$entero = 0;
		$decimal = 0;
		$negativo = $value < 0;
		$str='';
	
		if(strstr($value, "."))
		{
			list($entero, $decimal) = explode(".", $value, 2);
		}
		else
		{
			$entero = $value;
		}
		$str = '';
		if ($negativo) {
			$str = ' '. $menos .' ' . misc::int_to_semantic_str((int)substr($entero, 1), $str);
		}
		else
		{
			$str = ' ' . misc::int_to_semantic_str($entero, $str);
		}
		
		if ($decimal > 0) {
			$str .= (' '. $con .' ' . misc::int_to_semantic_str($decimal) . ' '. $centavos);	// $strcent (2nd arg of int_to_semantic_str) wiped out, [previously an undefined variable]. Patch by fdx.
		}

		return $str;
	}

	static function int_to_semantic_str($number, $str = "")
	{
	
	global $script_owner, $script_owner_id;
	
	if(isset($script_owner) && $script_owner === true){
	    $owner = $script_owner_id;
	}else{
	    $owner = owner_to_ownerid();
	}
	
	
	if($owner == 5){
	    
	    	
	    	
		require_once(INCLUDE_PATH .'numbwordter.php');
		$myConverter = new NumbWordter(); 
		
        $text = $myConverter->convert($number); 
        
        
        return $text; 
	
	  
	}else{
	    $UNIDADES = explode(" ", "cero un dos tres cuatro cinco seis siete ocho nueve diez once doce trece catroce quince dieciséis diecisiete dieciocho diecinueve veinte veintiuno veintidós veintitrés veinticuatro veinticinco veintiséis veintisiete veintiocho veintinueve");
	    $DECENAS = explode(" ", "diez veinte treinta cuarenta cincuenta sesenta setenta ochenta noventa cien");
	    $CENTENAS = explode(" ", "ciento doscientos trescientos cuatrocientos quinientos seiscientos setecientos ochocientos novecientos");
	
         $number = (int)$number;
	      if(strlen($number) == 1) {
		      $str .= ' ' . $UNIDADES[$number];
	      }
	      elseif(strlen($number) == 2) {
		      if ($number < 30)
		      {
			    $str .= ' ' . $UNIDADES[$number];
		      }
		      else
		      {
			      $decena = (int)substr($number, 0, 1);
			      if (($number % 10) == 0) {
				       $str .= ' ' . $DECENAS[$decena-1];
			      }
			      else
			      {
				      $str .= ' ' . $DECENAS[$decena-1] . ' y ' . misc::int_to_semantic_str((int)substr($number, 1), $str);
			      }
		      }
	      }
	      elseif(strlen($number) == 3) {
		      if ($number == 100) {
			      $str .= ' '.$cien;
		      }
		      else
		      {
			      $centena = (int)substr($number, 0, 1);
			      if (($number % 100) == 0) {
				      $str .= ' ' . $CENTENAS[$centena-1];
			      }
			      else
			      {
				      $str .= ' ' . $CENTENAS[$centena-1] . ' ' . misc::int_to_semantic_str((int)substr($number, 1), $str);
			      }
		      }
	      }
	      else
	      {
		    $leading = (int)substr($number, 0, strlen($number)-3);
		    $trailing = (int)substr($number, strlen($number)-3);

		    return misc::int_to_semantic_str($leading) . ' '.$mil.' ' . misc::int_to_semantic_str($trailing);
	      }

	      return $str;
    }

     
	}
}

?>

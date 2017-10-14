<?
/*
 * basescr contiene la funcionalidad que todas las scr (pantallas) usan en
 * comun y no tiene sentido implementarla en cada una de ellas.
 */ 
 
class basescr
{
	/*
	 * setvar, setea una variable global que puede ser usada desde una scr
	 * desde otro metodo, o cualquier lugar, mediante la llamad a getvar.
	 */
	function setvar( $key, $value)
	{
		global $basescr_variables;

		if ( !$basescr_variables || !is_array( $basescr_variables))
			$basescr_variables = array( );

		$basescr_variables[ $key] = $value;
		return true;
	}

	/*
	 * getvar, devuelve el valor de una variable que fue seteada previamente
	 * por setvar. En caso de que esta variable no haya sido previamente seteada,
	 * esta funcion devuelve null.
	 */
	static function getvar( $key)
	{
		global $basescr_variables;
		
		if ( !$basescr_variables || !is_array($basescr_variables)) return null;
		if ( !array_key_exists( $key, $basescr_variables)) return null;
		
		return $basescr_variables[ $key];
	}

	function destroyvar( $key)
	{
		global $basescr_variables;
		
		if ( !$basescr_variables || !is_array( $basescr_variables))
			return false;

		if ( !array_key_exists( $key, $basescr_variables))
			return false;

		unset( $basescr_variables[ $key]);
		return true;
	}

	/* my_scr_id: Esta funcion la usa un scr para saber cual es su id.
	 * Este se deduce viendo cual es el folder de dicho scr (del current
 	 * directory). De esta manera nos aseguramos que los id de los scr
	 * sean unicos y aparte dinamicos.
	 */
	
	function my_scr_id( )
	{
		// TODO: No funciona, porque el nombre del script no se propaga al hacer
		// un include. Ver mas adelante como fixearlo.
	}

	function scr_uri( $id)
	{
		return "?scr=" . $id;
	}
	
	/* get_all_scrs: Devuelve todos los scr que existen en la aplicacion.
	 * Estos se sacan viendo todos los directorios que estan dentro del
	 * directorio "scr" en htdocs.
	 */

 	function get_all_scr_ids( )
	{
		global $scrs;
		$my = array( );
		
		foreach( $scrs as $key => $value)
		{
			$my[ ] = $value[ "id"];
		}

		return $my;
	}

	static function get_info_of_scr( $id)
	{
		global $scrs;
		foreach( $scrs as $key => $value)
		{
			if ( $value[ "id"] == $id)
				return $value;
		}

		return false;
	}

	static function complete_owner_scrs( $owner_scrs)
	{
		foreach( $owner_scrs as $key => $value)
		{
			foreach( $value[ "items"] as $key2 => $item)
			{
				$complete = basescr::get_info_of_scr( $item);
//				$complete[ "uri"] = basescr::scr_uri( $complete[ "id"]);
				
				$complete["uri"] = $complete["script"] . "?fP=1";
				if (isset($complete["params"])) $complete["uri"] .= "&" . $complete["params"];
				
				$owner_scrs[ $key][ "items"][ $key2] = $complete;
			}
		}

		return $owner_scrs;
	}
	
	/* current_scr: Analiza los parametros que se pasan por web, y decide que scr
	 * estamos usando. En caso de decidir una scr por este metodo, la guarda en
	 * session. En caso de que haya mas parametros que los que definen la scr, se
	 * levanta el de session directamente.
	 */
	
	function current_scr( $default = false)
	{
		$scr = null;
		if ( constant( 'LOCATION'))
		{
			$all_scrs = basescr::get_all_scr_ids( );
			if ( in_array( LOCATION, $all_scrs))
			{
				ca_session::set( "scr", LOCATION);
				return LOCATION;
			}
		}
		else
		{
			$my = array_merge( $_GET, $_POST);

			if ( is_array( $my))
			{
				foreach( $my as $key => $value)
				{
					if ( $key != "scr")
					{
						// Hay mas parametros ademas de scr, por lo que tratamos de levantarla
						// directamente de session. <- Esto lo hacemos afuera del foreach, notar
						// el break;
						break;
					}

					if ( $key == "scr")
					{
						$all_scrs = basescr::get_all_scr_ids( );
						if ( in_array( $value, $all_scrs))
						{
							// Es un scr valido. Lo grabamos en session y lo devolvemos.
							ca_session::set( "scr", $value);
							//echo $value;
							return $value;
						}

						return false;
					}
				}
			}
		}

		$scr = ca_session::get( "scr");
		if ( $scr === null)
		{
			if ( $default)
				ca_session::set( "scr", $default);
			return $default;
		}

		return $scr;
	}

	function thereis_params( )
	{
		$my = array_merge( $_GET, $_POST);
		
		if ( is_array( $my))
		{
			foreach( $my as $key => $value)
			{
				if ( $key != "scr")
				{
					// Hay mas parametros ademas de scr.
					return true;
				}
			}
		}

		return false;
	}

    static function _action( $name)
    {
        global $smarty;
        if ( $smarty->get_template_vars( $name))
            return true;

        return false;
    }
    
    function action_print( )
    {
        return basescr::_action( "print");
    }

    function action_printall( )
    {
        return basescr::_action( "printall");
    }
 
    static function action_exportcsv( )
    {
        return basescr::_action( "exportcsv");
    }

    static function action_email( )
    {
        return basescr::_action( "email");
    }

    static function action_pay( )
    {
        return basescr::_action( "pay");
    }
   
	function exec( $scr)
	{
        global $smarty;

		// Checking the flags.
        if ( $scr->allow_print && ( filter::flag( varconn::REQUEST( "print")) || ( ( int)varconn::REQUEST( "print_x") > 0 && ( int)varconn::REQUEST( "print_y") > 0)))
        {
			$smarty->assign( "print", true);
        }
        else if ( $scr->allow_printall && ( filter::flag( varconn::REQUEST( "printall")) || ( ( int)varconn::REQUEST( "printall_x") > 0 && ( int)varconn::REQUEST( "printall_y") > 0)))
        {
			$smarty->assign( "print", true);
			$smarty->assign( "printall", true);
        }
        else if ( $scr->allow_exportcsv && ( filter::flag( varconn::REQUEST( "exportcsv")) || ( ( int)varconn::REQUEST( "exportcsv_x") > 0 && ( int)varconn::REQUEST( "exportcsv_y") > 0)))
        {
            // Seteo print y printall para que se genere la ca_list sin paginacion.
			$smarty->assign( "print", true);
			$smarty->assign( "printall", true);
			$smarty->assign( "exportcsv", true);
        }
        else if ( $scr->allow_email && ( filter::flag( varconn::REQUEST( "email")) || ( ( int)varconn::REQUEST( "email_x") > 0 && ( int)varconn::REQUEST( "email_y") > 0)))
        {
			$smarty->assign( "email", true);
            $profile = new profile( ca_session::get_userid( ));
            $eaddr = $profile->get( );
            $smarty->assign( "eaddr", $eaddr);
        }
        else if ( $scr->allow_pay && ( filter::flag( varconn::REQUEST( "pay")) || ( ( int)varconn::REQUEST( "pay_x") > 0 && ( int)varconn::REQUEST( "pay_y") > 0)))
        {
			$smarty->assign( "pay", true);
         }
		else if ( $scr->allow_popup && ( filter::flag( varconn::REQUEST( "popup")) || ( ( int)varconn::REQUEST( "popup_x") > 0 && ( int)varconn::REQUEST( "popup_y") > 0)))
        {
			$smarty->assign( "popup", true);
        }
		else if ( $scr->allow_hide_menu && ( filter::flag( varconn::REQUEST( "hide_menu")) ))
        {
			$smarty->assign( "hide_menu", true);
        }
        
        
        if( varconn::REQUEST( "email_sid") != ''){
        	$smarty->assign( "print", true);
			$smarty->assign( "printall", true);
        }
   
        // Calling the scr functions.
		$params = basescr::thereis_params( );

		if ( !$scr->parameters( $params))
			return false;

		if ( !$scr->filter( $params))
			return false;

		if ( !$scr->process( $params))
			return false;

		if ( !$scr->assign( $params))
			return false;
        
		return true;
	}

	static function show( $scr, $currentscr) {
		
		global $smarty;
		
		$owner = owner_to_ownerid();
		if($owner == 1 || $owner == 2){ // red
			$smarty->assign('logos_red', true);
		}else if($owner == 3){ // hotatel
			$smarty->assign('logos_holatel', true);
		}else if($owner == 7){ // T2
			$smarty->assign('logos_t2', true);		
		}
		
		if(ca_session::get('admin_access')){
			$smarty->assign('admin_access', true);
			$smarty->assign('admin_username', ca_session::get('admin_username'));
		}
		
    	$scr_obj = new scr( );
        
			// Si seteo la variable "_template" en un scr, implica que
			// puedo cambiar cual es el template a mostrar.
			$template = "";
			$tpl = (string) basescr::getvar( "_template");
			if ( $tpl && strlen( $tpl) > 0) {
					$template = $tpl;
			} else {
					$template = "scr_" . $currentscr . ".tpl";
			}
				

		if (!$template) return false;

        // Get the title.
        $title = str_replace( "&#x00B0;", "º", str_replace( ",,", "", str_replace( "&gt;", ">", html_entity_decode( lang( $scr[ "title"]), ENT_NOQUOTES, DEF_CHARSET))));

        // Esto emula lo que se hace en los templates para armar el "replacement" de un titulo.
        // Obviamente es duplicar codigo, pero no queda otra.
        switch( $scr['id'])
        {
        case "rate":
            $rate_type = $smarty->get_template_vars( "rate_type");
            $rate_number = $smarty->get_template_vars( "rate_number");
            $title = str_replace( "[REPLACEMENT]", $rate_type . " (" . $rate_number . ")", $title);
            break;

        case "receipt":
            $receipt = $smarty->get_template_vars( "receipt");
            $title = str_replace( "[REPLACEMENT]", $receipt->receiptid, $title);
            break;

        case "ticket":
            $ticket = $smarty->get_template_vars( "ticket");
            $title = str_replace( "[REPLACEMENT]", $ticket->ticketid, $title);
            break;
            
        }

        // Si nos piden exportar un csv y se seteo una ca_list, entonces estamos de condiciones
        // de exportar la planilla de excel.
        if ( basescr::action_exportcsv( ) && is_object( ( $ca_list = $smarty->get_template_vars( "ca_list"))))
        {
            $csv = $ca_list->csv_get( );
            $len = strlen( $csv);
            $now = time( );

            $title = str_replace( ">", "-", $title);
            header( "Content-Type: text/csv");
            header( 'Content-Disposition: attachment; filename="' . date( "d-m-Y") . " - " . $title . ".csv" . '"');
            header( "Content-Length: " . $len);
            header( "Pragma: public", true);
            header( "Last-Modified: " . gmdate( "D, d M Y H:i:s", $now));
            header( "Expires: " . gmdate( "D, d M Y H:i:s", $now +1));
            print( $csv);
            session_write_close( );
            exit;
        }

        if (basescr::action_email()) {
        	
            //flag indicador de que el mail se envio con exito
			$email_done = filter::flag( varconn::REQUEST( "email_done"));
			
			//flag indicador de que el mail no se envio
            $email_failed = filter::flag( varconn::REQUEST( "email_failed"));

            if ( $email_done) {
				$smarty->assign( "email_done", true);
				
            } else if ( $email_failed) {
                
				$smarty->assign( "email_failed", true);
				
            } else {
                
				// Si tenemos el flag de e-mail, y eaddr contiene un e-mail valido, entonces
                // estamos en condiciones de enviar el e-mail.
                //
				// nota: beta-cuenta/inc/filter.php define la clase estatica filter
				//		 que contine varias funciones generales de validacion
				//		 en particular
				//			email: comprueba que sea una direccion de formato valido de email
				//			sid: compruba que el codigo de verif. tenga un formato valido
                $email = filter::email( varconn::REQUEST( "eaddr"));
                $email_sid = filter::sid( varconn::REQUEST( "email_sid"));
                
                //obs: esta logica no distingue entre las combinaciones
                //		=> pasa al else si: no se definio mail (no estaba en el textbox)
                //		si no se corresponde el sid (como cuando se accede por 1ra vez la pag)
                if ( $email && $email_sid && strcmp( $email_sid, ca_session::get( "email_sid")) == 0) {
                    
                    ca_session::destroy( "email_sid");
					
                    $csv = null;
                    $html = null;
                    
                    //verifica que haya data para exportar en alguno de estos formatos (csv o html)
                    //nota: de no haberlo no se envia el mail, error: no hay datos para enviar
                    if ($scr_obj->allow_exportcsv 
                    		&& is_object(($ca_list = $smarty->get_template_vars( "ca_list")))) {
                        $csv = $ca_list->csv_get( );
                    } else if ( $scr_obj->allow_print) {
                        // Esto es un tweak. Seteo como si estubiera en modo printer-friendly
                        // sin paginacion, y saco el flag de e-mail.
                        $smarty->assign( "print", true);
                        $smarty->assign( "printall", true);
                        $smarty->assign( "email", false);

                        // Making the HTML.
                        $html = "";
                        $html .= $smarty->fetch( "begin.tpl");
                        $html .= $smarty->fetch( $template);
                        $html .= $smarty->fetch( "end.tpl");
                    }
                    
                    $sucess = false;                  
                    if ($csv || $html) {    
                    
                        //trigger_error( "Sending e-mail");
                        $uri = new uri( );
                        //trigger_error( $uri->uri);
                        
                        // Creating the e-mail.					

                        $ca_email = new ca_email( $currentscr, ca_session::language_get( ));
                        $ca_email->add_to( CA_EMAIL_RECIPIENT_TYPE_TO, new ca_email_recipient( DEF_HARDCODED_USER_EMAIL ? DEF_HARDCODED_USER_EMAIL : $email, DEF_HARDCODED_USER_EMAIL ? DEF_HARDCODED_USER_EMAIL : $email));												
                        // Replacement: [PANEL_NAME]
                        $ca_email->set_tag_replacement( "[PANEL_NAME]", owner::panel_name( ));
                        
						// YAH (yet another hack) 
						if($_GET["pm"] == "pago_facil"){ // Le esta enviando el cupon de pago
							$ca_email->set_tag_replacement( "[DOC_TYPE]", TPL_EMAIL_ATTACH_PAGO_FACIL);
							$title = "cupón de pago";
						}else{ // Factura
							$ca_email->set_tag_replacement( "[DOC_TYPE]", TPL_EMAIL_ATTACH_TICKET);
						}
						
                        // Replacement: [ADDR_SUPPORT]
                        $ca_email->set_tag_replacement( "[ADDR_SUPPORT]", owner::owner_name() . '<'.owner::addr_support( ) .'>');

                        // Replacement: [INFO_SUPPORT]
                        $ca_email->set_tag_replacement( "[INFO_SUPPORT]", implode( '<br />', owner::info_support( )));
                        
                        // Replacement: [BTITLE]
                        $ca_email->set_tag_replacement( "[BTITLE]", $title);

                        
                        //codigo
                        $ca_email->set_tag_replacement("[CODIGO]", ca_session::get_userid());
                        
                        // Replacement: [TITULAR]
                        $user = new user( ca_session::get_userid( ));
                        $titular = $user->get_titular( );
                        $ca_email->set_tag_replacement( "[TITULAR]", $titular);

                        // Replacement: [SCR_RATE_ACCOUNT]
                        if ( $scr['id'] == "rate")
                        {
                            $ca_email->set_tag_replacement( "[SCR_RATE_ACCOUNT]", $smarty->get_template_vars( "rate_type"));
                        }

                        // Replacement: [SCR_TRAFF_GENERIC_REPORT_TYPE]
                        if ( in_array( $scr['id'], array( "traff_f", "traff_nf", "traff_p")))
                        {
                        
                      		$title = str_replace( ",,", "", lang( $smarty->get_template_vars( "_title")));
                      		$title = substr($title, strpos($title, '&gt;') + 4);
                            $ca_email->set_tag_replacement( "[SCR_TRAFF_GENERIC_REPORT_TYPE]", $title);
                        }
                       
                        // Adding the attachment.
                        if ( $csv)
                        {							
                            $filename = date( "d-m-Y") . " - " . $title . ".csv";
                            $ca_email->add_attachment( new ca_email_attachment( $csv, "text/csv", $filename));
                        }
                        else // $html
                        {							
                            $filename = date( "d-m-Y") . " - " . $title . ".html";
                            $ca_email->add_attachment( new ca_email_attachment( $html, "text/html", $filename));
                        }

                        // Sending the e-mail.
                        if ($ca_email->send_pear()) {
							//$sucess = true;
							/* El hack del siglo... 
								Para que el adjunto del mail no use paginador tenemos que setear smarty para
								que se muestre como si se estuviera exportando o imprimiendo. 
								Luego de enviado el mail, para que se vean de nuevo los menues y la lista paginada
								hacemos un redirect a la misma url pero quitamos el parametro email_sid, sino entra 
								en un bucle
							*/
							$querystring = "";
							if(count($_GET) > 0){
								$i=0;
								foreach($_GET as $llave => $valor){
									if($llave != "email_sid"){
										$separador = ($i == 0) ? "?" : "&" ;
										if(count($valores) > 0){
											foreach($valores as $llavenueva => $valornuevo){
												if($llavenueva == $llave){
													$valor = $valornuevo;
												}
											}
										}

										$querystring .= $separador . $llave . "=" . $valor;
										$i++;
										$separador = ($i == 0) ? "?" : "&" ;
									}
								}
							}
							header("location: ". $_SERVER["SCRIPT_NAME"] .$querystring ."&email_done=1");
				           	exit;
                        } else {
						
                        	//
                        }

                    } else {
                    
                    	//
                    	
                    }

                    $uri = new uri( );
                    $uri->exclude_params( array( "print", "printall", "email", "exportcsv", "eaddr", "pay", "email_done", "email_failed", "email_sid"));
                    $uri->set_flags( array( "email", $sucess ? "email_done" : "email_failed"));
                    clientcontrol::redirect( $uri->uri);
                
                } else {
                	
                    
                    $email_sid = ca_session::create_sid( );
                    ca_session::set( "email_sid", $email_sid);
                    $smarty->assign( "email_sid", $email_sid);
                    
                }
            }
        }

		//redefine el path de acceso (seleccion de menu principal)
		if ($_SESSION['redefinePath']) $_SESSION["currentscr"] = $currentscr;
		/* la variable smarty src_forzado es utilizada como path para mostrar
		   el path de menu desde el que se inicio la operacion actual 
		   ver: tpl/default/begin.tpl (la sustucion src x src_forzado se realiza
		   en el ultimo momento (si trato de redefinir scr falla)
		 */
		$smarty->assign("src_forzado", $_SESSION["currentscr"]);
		
		//echo 'INFO:<hr /><pre>' . $template . '</pre><hr />';
        // Displaying the HTML.

        $smarty->display( "begin.tpl");
		$smarty->display( $template);
		$smarty->display( "end.tpl");
		// PARCHE: CIERRO TODAS LAS CONEXIONES
		global $dbh;
		$dbh->Close();

		return true;
	}

	function strerr( $errno)
	{
		$errors = basescr::errors( );
		foreach( $errors as $key => $value)
		{
			if ( $value[ 0] == $errno)
				return $value[ 1];
		}

		return false;
	}
	
	function seterr( $errno)
	{
		if ( ( int)$errno >= 0 || !$strerr || strlen( $strerr) <= 0)
			return false;
		
		$err = basescr::getvar( "err");
		if ( !$err || !is_array( $err))
			$err = array( );

		$err[ ] = array( $errno, $strerr);
		basescr::setvar( "err", $err);

		return true;
	}

	function haserrno( $errno)
	{
		$err = basescr::getvar( "err");
		if ( !$err || !is_array( $err))
			return false;
		
		foreach( $err as $key => $value)
		{
			if ( $err[ 0] == $errno)
				return true;
		}

		return false;
	}

	function errors( )
	{
		return array(
			array( -1, "Invalid Parameter"),
			array( -2, "Otro error"),
		);
	}
}

?>

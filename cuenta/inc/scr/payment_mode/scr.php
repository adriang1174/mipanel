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
		
		/* MOVER A ARCHIVO DE IDIOMA !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! */
		define("TPL_CUR_PAY_MODE", "Su forma de pago actual es:");
		define("TPL_PAY_CARD", "Tarjeta:");
		define("TPL_LAST_4_DIG", "Ultimos 4 d&iacute;gitos:");
		define("TPL_YOUR_CARD_IS", "Su tarjeta est&aacute;:");
		define("TPL_PAYMENT_FORM_DESCRIP", "Para modificar su forma de pago, por favor, complete el siguiente formulario.<br><b>Importante:</b> Los cambios recibidos luego del d�a 9 de cada mes se har�n efectivos en el d�bito del mes siguiente.");
		define("TPL_PAY_CARD_NUMBER", "N�mero de tarjeta:");
		define("TPL_PAY_CARD_EXP_DATE", "Fecha de vencimiento:");
		define("TPL_PAY_CARD_SEC_CODE", "C�digo de seguridad:");
		define("TPL_PAY_CARD_FULL_NAME", "Nombre y apellido del titular de la tarjeta:");
		define("TPL_PAY_CARD_ADDRESS", "Direcci�n de resumen de la tarjeta:");
		define("TPL_PAY_CARD_STREET", "Calle:");
		define("TPL_PAY_CARD_NUMBER", "N�mero:");
		define("TPL_PAY_CARD_FLOOR", "Piso:");
		define("TPL_PAY_CARD_DEPT", "Departamento:");
		define("TPL_PAY_CARD_CP", "C�digo postal:");
		define("TPL_PAY_CARD_LOC", "Localidad:");
		define("TPL_PAY_CARD_CITY", "Ciudad:");
		define("TPL_PAY_CARD_PROV", "Provincia o estado:");
		define("TPL_PAY_CARD_COUNTRY", "Pa�s:");
		define("TPL_PAY_CARD_ACCEPT_DEBIT", "Acepto la siguiente autorizaci�n para el d�bito autom�tico");
		define("TPL_PAY_CARD_DEBIT_INFO", "Por la presente acepto el d�bito que cada mes se realizar�, correspondiente a la totalidad de las facturas debidas por servicios prestados. Dicha forma de pago ser� utilizada hasta que comunique lo contrario, con 30 d�as de anticipaci�n. En caso de no poder debitar los cargos anteriormente detallados, entiendo que se proceder� a suspender el servicio.");
		define("TPL_PAY_FORM_MSG", "Su solicitud de cambio de forma de pago se ha enviado correctamente.");
		
		
		
		
		$owner = owner_to_ownerid();

		$smarty->assign('owner_id', $owner);
		
		
		if(!empty($_POST)){
			// ACA VA EL CODIGO QUE PROCESA LA SOLICITUD....
			$smarty->assign("show_msg", true);
		}else{
			$smarty->assign("show_form", true);
			if($owner != 3 && $owner != 5){ // Los usuarios de Hola Argentina y Holatel no deben ver los siguientes campos del formulario
				$smarty->assign("form_seccion_2_visible", true);
			}else{
				$smarty->assign("form_seccion_2_visible", false);
			}
		}
		
		$user = new user( ca_session::get_userid( ));
		$tickets = $user->get_ticket_list(false, 0, 1, $is_last, true, $total);
		$ticketid = $tickets[0]->ticketid;
		
		$smarty->assign('ticketid', $ticketid);
		
		
		return true;
	}
}

?>

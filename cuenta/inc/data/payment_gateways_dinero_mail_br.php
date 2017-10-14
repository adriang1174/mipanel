<?
//carga una clase que agrupa metodos estaticos adicionales
require_once(INCLUDE_PATH . "data/pagos_online_gw.php");

//require_once( INCLUDE_PATH . "db.php");

//define('CODIGO_COMERCIO_BR', '14566'); // sebastian@promaker
define('CODIGO_COMERCIO_BR', '196');


//(!)revisar
class p_gateways_dinero_mail_br_ticket {
    
    function p_gateways_dinero_mail_br_ticket($ticketid) {
        
		$this->ticketid = $ticketid;

    }

}

class p_gateways_dinero_mail_br extends p_gateways {

	function p_gateways_dinero_mail_br($userid) {

       	parent::p_gateways($userid, "pagos_online");

    }
	
	function trackPeticion($ticket){
		
		$query = "
			INSERT INTO dineromail_log (
				fecha_inicio_pago, cliente_id, monto, moneda
			) VALUES (
				NOW(), '" . ca_session::get_userid() . "', " . $ticket->total . ", " . $ticket->TipoMoneda . "
			);";
		
		db::init();
        db::DoIt($query);
		
		$query = "select max(id_pago) from dineromail_log where cliente_id = '" . ca_session::get_userid() . "'";
        $id = db::get_row_as_scalar($query);
		
        return $id;
		
	}
	
	function trackPeticionClose($idTrack, $resultado){
		
		//le agrego una restriccion sobre el idCliente para que no pueda modifcar cosas de otros usarios
		//si esta intentando hackear
		$query = "
			UPDATE dineromail_log SET resultado = '" . $resultado . "', fecha_fin_pago = NOW() 
			WHERE id_pago = " . $idTrack . " AND cliente_id = '" . ca_session::get_userid() . "';";

		db::init();
		db::DoIt($query);
		
	}
	
    function get_ticket($ticketid, $amount2pay = 0) {
	
		//echo "BR: get_ticket<br />";
		
		list($tipodoc, $sucdoc, $numdoc) = explode('-', $ticketid);
		$ticketid_short = $sucdoc."-".$numdoc;
		
		$myticket = $this->userdata->get_ticket($ticketid);
		/*
		echo "<pre>";
		print_r($myticket);
		echo "</pre>";
		*/
        $p_dinero_mail_mx = new p_gateways_dinero_mail_mx_ticket($ticketid_short);
		
		
		if (strlen($ticketid) == 0) { // Pagos sin factura
			$p_dinero_mail_mx->ticketid = false;
			$p_dinero_mail_mx->moneda = 'USD';
			$myticket->monedaid = 1;
		} else {
			$p_dinero_mail_mx->ticketid = $ticketid;
			$p_dinero_mail_mx->moneda = $this->userdata->get_currency($myticket->monedaid);	
		}
        
		if($amount2pay > 0){
			$p_dinero_mail_mx->total = round($amount2pay, 2);
		}else{
			$p_dinero_mail_mx->total = $myticket->itotal;
		}
		
		
		$cot_fact = ca_currency::get_last_quotation_by_id( $myticket->monedaid );
        $cot_medio = ca_currency::get_last_quotation_by_id( 5 ); // REALES
        $cot = $cot_fact['cotizacion'] / $cot_medio['cotizacion'];
		
		$p_dinero_mail_mx->total_reales = round(($p_dinero_mail_mx->total * $cot), 2);
		$p_dinero_mail_mx->total_reales_string = number_format(($p_dinero_mail_mx->total * $cot), 2);
		
        		/* VARIABLES OBLIGATORIAS PARA LA LLAMADADA */

		$p_dinero_mail_mx->url_action = 'https://brasil.dineromail.com/dinero-tools/login/shop/shop_ingreso.asp';
		$p_dinero_mail_mx->NombreItem = 'pago total/parcial ' . $p_dinero_mail_mx->ticketid;
		$p_dinero_mail_mx->TipoMoneda = "1"; // Reales
		
		
		$p_dinero_mail_mx->E_Comercio = CODIGO_COMERCIO_BR; //CODIGO_COMERCIO;
		
		$p_dinero_mail_mx->DireccionExito = "";
		$p_dinero_mail_mx->DireccionFracaso = "";
		
		$profile = new profile(ca_session::get_userid());
		
		$p_dinero_mail_mx->usr_nombre = $profile->getRSocial();
		$p_dinero_mail_mx->usr_apellido = '';
		$p_dinero_mail_mx->usr_tel_numero = '';
		$p_dinero_mail_mx->usr_email = $profile->get();
		
		$nro_item = ca_session::get_userid();
		
		$nro_item = str_replace('C', '0', $nro_item);
		$p_dinero_mail_mx->NroItem = $nro_item;
		
		/**/

        return $p_dinero_mail_mx;
    }
   
}
?>

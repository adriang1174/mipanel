<?
//carga una clase que agrupa metodos estaticos adicionales
require_once(INCLUDE_PATH . "data/pagos_online_gw.php");
//require_once( INCLUDE_PATH . "db.php");
if(!defined('LLAVE_ENCRIPTACION_PAGOS_ONLINE')){
    define('LLAVE_ENCRIPTACION_PAGOS_ONLINE', '1111111111111111');
}

if(!defined('ID_USUARIO_PAGOS_ONLINE')){
    define('ID_USUARIO_PAGOS_ONLINE', '2');
}

class p_gateways_pagos_online_ticket
{
    var $id_usuario;
    var $id_venta;
    var $descripcion_venta;
    var $valor_venta;
    var $valor_iva;
    var $valor_base_dev;
    var $email_comprador;
    var $llave_encripcion;
    var $moneda;
    var $url_respuesta;
	var $url_confirmacion;
	var $lenguaje;
	var $extra1;
	var $extra2;
	var $plantilla;
	var $prueba;
	var $firma;
	var $firma_codificada;
				
    function p_gateways_pagos_online_ticket( $ticketid)
    {
        $this->ticketid = $ticketid;
    }
}

class p_gateways_pagos_online extends p_gateways
{
    function p_gateways_pagos_online( $userid)
    {
        parent::p_gateways( $userid, "pagos_online");
    }
	
    function get_ticket( $ticketid, $amount2pay = 0)
    {
        list($tipodoc, $sucdoc, $numdoc) = explode('-', $ticketid);
        $ticketid_short = $sucdoc."-".$numdoc;
		
		$myticket = $this->userdata->get_ticket($ticketid);
        $p_pagosOnLine = new p_gateways_pagos_online_ticket($ticketid_short);
		
		$p_pagosOnLine->client = $this->userid." - ".$this->userdata->get_titular();
    	$p_pagosOnLine->ticketid = $ticketid;

        $cot_fact = ca_currency::get_last_quotation_by_id( $myticket->monedaid );
        $cot_medio = ca_currency::get_last_quotation_by_id( 3 ); // $MX
        $cot = $cot_fact['cotizacion'] / $cot_medio['cotizacion'];
        
        $tot = $amount2pay ? $amount2pay : $myticket->itotal;
        $p_pagosOnLine->total_dollars = $tot;
        $p_pagosOnLine->total_string = $this->userdata->get_currency(3)." ".number_format($tot * $cot, 2)." (".$this->userdata->get_currency($myticket->monedaid)." ".$tot.")";
        $p_pagosOnLine->dollar_simbol = $this->userdata->get_currency($myticket->monedaid);
        $p_pagosOnLine->original_currency = $this->userdata->get_currency_desc($myticket->monedaid);
		
        /* VARIABLES OBLIGATORIAS PARA LA LLAMADADA */
		
		$p_pagosOnLine->id_usuario = ID_USUARIO_PAGOS_ONLINE;
		/* refVenta: Es la referencia de la venta, esta debe ser unica y normalmente
		es generada en la pagina web de comercio, en el momento que se guarda el registro
		de la venta	dentro de la tabla de datos correspondiente.*/

		$p_pagosOnLine->id_venta = $p_pagosOnLine->ticketid . time();	//(!)remover time
		$p_pagosOnLine->descripcion_venta = 'pago total/parcial de ' . 
			$p_pagosOnLine->ticketid;									//(!)ajustar
		
		$p_pagosOnLine->valor_venta = $p_pagosOnLine->total_dollars;
			
		/* valor: Es el valor total de la transaccion */
		/* iva: Es el valor de IVA de la transaccion */
		$p_pagosOnLine->valor_iva = 0;
		
		/* baseDevolucionIva: Es valor base para devolucion del IVA */
		$p_pagosOnLine->valor_base_dev = 0;	//$venta['valor_base_iva'];
		
		$p_pagosOnLine->email_comprador = $this->userdata->get_email();	//$comprador['email'];
				
		/* La llave utilizada para la generacion de la firma digital se encuentra en el
		MODULO ADMINISTRATIVO dentro de ficha OPCIONES como
		 "Llave para realizar encripciones"	*/
		$p_pagosOnLine->llave_encripcion = LLAVE_ENCRIPTACION_PAGOS_ONLINE;		//(!)valor final
		$p_pagosOnLine->moneda = "USD";											//(!)seguro?

		/* VARIABLES OPCIONALES */
		$p_pagosOnLine->url_respuesta = "";								//se establece en src 
		$p_pagosOnLine->url_confirmacion = "";							//se establece en src
		
		$p_pagosOnLine->lenguaje = "ES";								//(!)variable de idioma?
	
		$p_pagosOnLine->extra1 = $this->userid;							//(!)utilizo ambos campos
		$p_pagosOnLine->extra2 = $p_pagosOnLine->valor_venta;			//inicialmente pues no
																		//que los necesite
		//$p_pagosOnLine->plantilla = "";
					
		/* SEGURIDAD */
		
		$p_pagosOnLine->prueba = 1;										//(!)remover al final
		
		$p_pagosOnLine->firma =  "$p_pagosOnLine->llave_encripcion~$p_pagosOnLine->id_usuario~$p_pagosOnLine->id_venta~$p_pagosOnLine->valor_venta~$p_pagosOnLine->moneda";
		$p_pagosOnLine->firma_codificada = md5($p_pagosOnLine->firma);

		/**/

        return $p_pagosOnLine;
    }
   
}
?>

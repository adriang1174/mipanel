<?
/*
	para agregar un nuevo medio de pago:
	1)crear una clase que extineda de p_gateways con convencion de nombre p_gateways_ . denomMedioPago
	2)incluir el require_once(INCLUDE_PATH . "data/nombre p_gateways_ . denomMedioPago .php");
	3)agregar el elemento de control en el array get_list
	
	porque:
	1) y 2)la persona que ideo esto lo penso para que sea de esta forma y hay muchas verificaciones
	y enlaces a lo largo de las paginas y si no esta definido asi falla o se ignora el medio de pago
	3) vinculado a la pagina de seleccion de medio (/src/ticket/scr.php)
	nota /src/ticket/scr.php contiene el nuecleo de los pasos, inmediatamente luego de definir aquie
	se debe arrancar haciendo una analogia de los existente en esa pagina (contiene la logica)
	luego /tpl/default/ticket.ca contiene la vista y se controla mucho por flags asignados a
	smarty para permitir o no la visualizacion de los elementos
*/



require_once(INCLUDE_PATH . "db.php");
require_once(INCLUDE_PATH . "misc.php");
require_once(INCLUDE_PATH . "data/user.php");
require_once(INCLUDE_PATH . "data/payment_gateways_pago_facil.php");
require_once(INCLUDE_PATH . "data/payment_gateways_pago_universal.php");
require_once(INCLUDE_PATH . "data/payment_gateways_dinero_mail.php");
require_once(INCLUDE_PATH . "data/payment_gateways_paypal.php");
require_once(INCLUDE_PATH . "data/payment_gateways_pagos_online.php");
require_once(INCLUDE_PATH . "data/payment_gateways_dinero_mail_mx.php");
require_once(INCLUDE_PATH . "data/payment_gateways_dinero_mail_br.php");
require_once(INCLUDE_PATH . "data/payment_gateways_pago_online.php");

class p_gateways
{
    var $userid;
    var $userdata;
    var $name;

    function p_gateways( $userid, $name)
    {
        $this->userid = $userid;
        $this->userdata = new user($userid);
        $this->name = $name;
    }

    function exists( $name) {
	
	   return class_exists( "p_gateways_" . $name);
	   
    }
    
    function get_trans_id($ticketid, $total) {
        db::init();
        list($tipodoc, $sucdoc, $numdoc) = explode('-', $ticketid, 3);
        
        $query = "select max(idtransact) from Pays where cliente_id = '".$this->userid."'";
        $last_transid = db::get_row_as_scalar($query);

        if(!$last_transid)
            $new_transid = 1;
        else
            $new_transid = $last_transid+1;
        
        $query = "insert into pays(id, cliente_id, modulo, fecha, tipodoc, sucdoc, numdoc, valor, idtransact) ";
        $query .= " values (nextval('pays_id'), '".$this->userid."', 'FactL', now(), '$tipodoc', '$sucdoc', '$numdoc', '$total', '$new_transid')";
        
        db::DoIt($query);

        $str_id = sprintf("%s%04d", $this->userid, $new_transid);

        return $str_id;
    }
    
    function get_owner_list($owner_id, $pais){
	   	db::init();
		$query = "SELECT medio_cobranza_id FROM medios_cobranza_habilitados WHERE (pais = '". $pais ."' AND owner_id = ". $owner_id .") OR (pais = '*' AND owner_id = ". $owner_id .")";
		$medios = db::get_rows_as_array($query);
		$medios_habilitados = array();
		foreach($medios as $medio){
			array_push($medios_habilitados, $medio[0]);
		}
		return $medios_habilitados;
    }

    /*
		Este metodo retorna un listado de elementos <array informacion medio pago>
		comentarlos <=> que ya no esten disponibles
	*/
	function get_list( ) {
	
        return array(
            array( "id" => "pago_mis_cuentas", "img" => "logo-pagomiscuentas.jpg", "implemented" => false, "href" => "http://www.pagomiscuentas.com/"),
            //array( "id" => "bnl", "img" => "logo-bnl.gif", "implemented" => false, "href" => null),
			array( "id" => "hsbc", "img" => "logo-HSBC.jpg", "implemented" => false, "href" => null),
			array( "id" => "galicia", "img" => "logo-galicia.jpg", "implemented" => false, "href" => null),
            array( "id" => "link", "img" => "logo-linkpagos.jpg", "implemented" => false, "href" => "http://www.linkpagos.com.ar/"),
            array( "id" => "pago_facil", "img" => "logo-pagofacil.jpg", "implemented" => true, "href" => null),
            array( "id" => "rapipago", "img" => "logo-rapipago.jpg", "implemented" => true, "href" => null),
            array( "id" => "pago_universal", "img" => "logo-pagouniversal.jpg", "implemented" => true, "href" => null),
            array( "id" => "dinero_mail", "img" => "logo-dineromail.gif", "implemented" => true, "href" => null),
			array(
				"id" => "dinero_mail_mx", 
				"img" => "logo-dineromail-mx.gif", 
				"implemented" => true, 
				"href" => null
			),
			array(
				"id" => "dinero_mail_br", 
				"img" => "logo-dineromail-br.gif", 
				"implemented" => true, 
				"href" => null
			),
            //array( "id" => "dinero_mail", "img" => "logo-dineromail.gif", "implemented" => false, "href" => null)
			array( "id" => "paypal", "img" => "logo-paypal.gif", "implemented" => true, "href" => null),
			array( "id" => "pagos_online", "img" => "logo-pagosonline.gif", "implemented" => true, "href" => null));
    }
    
}
?>

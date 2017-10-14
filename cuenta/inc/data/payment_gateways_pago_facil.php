<?

class p_gateways_pago_facil_ticket
{
    var $titular;
    var $address;
    var $cuit;
    var $expiration;
    var $clientid;
    var $payment_condition;
    var $total_simbol;
    var $total_amount;
    var $ticketid;
    var $barcodeid;

    function p_gateways_pago_facil_ticket( $ticketid)
    {
        $this->ticketid = $ticketid;
    }
}

class p_gateways_pago_facil extends p_gateways
{
    function p_gateways_pago_facil( $userid)
    {
        parent::p_gateways( $userid, "pago_facil");
    }

    function get_ticket( $ticketid, $amount2pay = 0)
    {
        list($tipodoc, $sucdoc, $numdoc) = explode('-', $ticketid);
        $ticketid_short = $sucdoc."-".$numdoc;

        $myticket = $this->userdata->get_ticket($ticketid);
       
        $p_pagofacil = new p_gateways_pago_facil_ticket($ticketid_short);
        $p_pagofacil->titular = $this->userdata->get_titular();
        $p_pagofacil->cuit = $myticket->cuit;
        $p_pagofacil->address = $myticket->address;
        $p_pagofacil->expiration = $myticket->date_expire;
        $p_pagofacil->clientid = $myticket->userid;
        $p_pagofacil->payment_condition = $myticket->condpago;
        $p_pagofacil->total_simbol = $this->userdata->get_currency($myticket->monedaid);
        $p_pagofacil->total_amount = $amount2pay ? $amount2pay : $myticket->itotal;
        $p_pagofacil->ticketid = $ticketid;
        $p_pagofacil->barcodeid = $this->get_barcode_number($ticketid, $tipodoc, $sucdoc, $numdoc, $myticket, $amount2pay);

		
        return $p_pagofacil;
    }
    
    static function static_get_barcode_number($ticketid, $tipodoc, $sucdoc, $numdoc, $myticket, $amount2pay, $userid){ 
    

    	$topay = '';
        if($amount2pay)
            $topay = $amount2pay;
        else
            $topay = $myticket->itotal;

        if(strstr($topay, "."))
        {
           list ($a, $b) = explode(".", $topay);
           if(strlen($b) == 1)
		$b = $b . "0";

           $cents = $b;

           /*
		Este bloque traia problema con los montos de menos de .10 - Sebastian Gil 19/12
            if($b < 10)
              $cents = $b * 10;
            else
              $cents = $b;
	    */
		
            $amount = $a.sprintf("%02d", (int)($cents));
        }
        else
        {
            $amount = (int) $amount2pay * 100;
        }
        
        if($amount < 0){
        	$amount = 0;
        }

        $importeFormateado = sprintf("%08d", (int)($amount));

        
        $now = localtime(time() + 30 * 86400,TRUE);
        
        $fechaImpresion = sprintf("%02d%03d", (($now['tm_year'] + 1900) % 100), ($now['tm_yday'] + 1));
        $tipoFactura = ($tipodoc == "FA") ? 1 : ($tipodoc == "FB") ? 2 : 3;
        $mysucDoc = sprintf("%02d", (int) $sucdoc);
		
		
		// Nunca puede tener mas de 6 caracteres el numdoc
		if(strlen($numdoc) > 6){
			$numdoc = substr($numdoc, strlen($numdoc) - 6);
		}
		
		global $_global_owner;
		
		if(isset($_global_owner) && $_global_owner != ''){

			$owner_to_use = $_global_owner;
		}else{
			$owner_to_use = ca_session::get('owner');
		}
		
		switch($owner_to_use){
			case "telephone2":
				$barCodeString = '364' . $importeFormateado . $fechaImpresion .  sprintf("%08d", (int) $numdoc) . $userid . '0' . $importeFormateado .$fechaImpresion;
			break;
			case "red":
				if(stripos($userid, 'C') === false){
	                $userid = $userid;
                }else{
	                $userid = str_replace('C', '0', $userid);
                }
				$barCodeString = '143' . $importeFormateado . $fechaImpresion . $userid  . '0' . $tipoFactura . $mysucDoc . sprintf("%06d", (int) $numdoc);
			break;
			case "t2":
				if(stripos($userid, 'C') === false){
	                $userid = $userid;
                }else{
	                $userid = str_replace('C', '0', $userid);
                }
				$barCodeString = '143' . $importeFormateado . $fechaImpresion . $userid . '0' . $tipoFactura . $mysucDoc . sprintf("%06d", (int) $numdoc);
				/*
				$numdoc = substr($numdoc, 2, strlen($numdoc));
               $barCodeString = '143' . $importeFormateado . $fechaImpresion .  sprintf("%08d", (int) $numdoc) . $userid . '0' . $importeFormateado .$fechaImpresion;
               */
               
            break;
		}

        
        $leading = substr($barCodeString, 0, 5);
        $trailing = substr($barCodeString, 5);
                
        $l = array( 1, 3, 5, 7, 9 );
        $r = array( 3, 5, 7, 9 );
        $sum = 0;
        $i = 0;

        while ($i < strlen($leading)) {
            $sum += $l[$i] * substr($leading, $i, 1);
            $i++;
        }

        $i = 0;
        while ($i < strlen($trailing)) {
            $sum += $r[$i % 4] * substr($trailing, $i, 1);
            $i++;
        }

        $sum /= 2;
        $dv = (int)$sum % 10;
        $barcode = $barCodeString . $dv;


        return $barcode;
    }
    
    function get_barcode_number($ticketid, $tipodoc, $sucdoc, $numdoc, $myticket, $amount2pay) { // EN ALGUN MOMENTO TENEMOS QUE QUITAR ESTA FUNCION Y USAR SIEMPRE STATIC_GET_BARCODE_NUMBER
	    $topay = '';
        if($amount2pay)
            $topay = $amount2pay;
        else
            $topay = $myticket->itotal;


        if(strstr($topay, "."))
        {
           list ($a, $b) = explode(".", $topay);
           if(strlen($b) == 1)
		$b = $b . "0";

           $cents = $b;

           /*
		Este bloque traia problema con los montos de menos de .10 - Sebastian Gil 19/12
            if($b < 10)
              $cents = $b * 10;
            else
              $cents = $b;
	    */
		
            $amount = $a.sprintf("%02d", (int)($cents));
        }
        else
        {
            $amount = (int) $amount2pay * 100;
        }
		
		 if($amount < 0){
        	$amount = 0;
        }
        
        $importeFormateado = sprintf("%08d", (int)($amount));
        
        $now = localtime(time() + 30 * 86400,TRUE);
        $fechaImpresion = sprintf("%02d%03d", (($now['tm_year'] + 1900) % 100), ($now['tm_yday'] + 1));
        $tipoFactura = ($tipodoc == "FA") ? 1 : ($tipodoc == "FB") ? 2 : 3;
        $mysucDoc = sprintf("%02d", (int) $sucdoc);
		
		
		// Nunca puede tener mas de 6 caracteres el numdoc
		if(strlen($numdoc) > 6){
			$numdoc = substr($numdoc, strlen($numdoc) - 6);
		}
		
		
		switch(ca_session::get('owner')){
			case "telephone2":
				$barCodeString = '364' . $importeFormateado . $fechaImpresion .  sprintf("%08d", (int) $numdoc) . $this->userid . '0' . $importeFormateado .$fechaImpresion;
			break;
			case "red":
				if(stripos($this->userid, 'C') === false){
	                $cliente = $this->userid;
                }else{
	                $cliente = str_replace('C', '0', $this->userid);
                }
				$barCodeString = '143' . $importeFormateado . $fechaImpresion . $cliente . '0' . $tipoFactura . $mysucDoc . sprintf("%06d", (int) $numdoc);
			break;
            case "t2":
            	if(stripos($this->userid, 'C') === false){
	                $cliente = $this->userid;
                }else{
	                $cliente = str_replace('C', '0', $this->userid);
                }
                
                $barCodeString = '143' . $importeFormateado . $fechaImpresion . $cliente . '0' . $tipoFactura . $mysucDoc . sprintf("%06d", (int) $numdoc);
               
                /*
            	$barCodeString = '143' . $importeFormateado . $fechaImpresion . '0' . substr($this->userid, 1) . '0' . $tipoFactura . $mysucDoc . sprintf("%06d", (int) $numdoc);
            	*/
            	/*
            	// Estos clientes tienen numeros de factura de 8 digitos y deben ser solo de 6
            	$numdoc = substr($numdoc, 2, strlen($numdoc));
                //$barCodeString = '143' . $importeFormateado . $fechaImpresion .  $userid . '0' . $tipoFactura . $mysucDoc . sprintf("%06d", (int) $numdoc);
                $barCodeString = '143' . $importeFormateado . $fechaImpresion .  sprintf("%08d", (int) $numdoc) . $this->userid . '0' . $importeFormateado .$fechaImpresion;
                */
                
            break;

		}
        /*
        echo "importeFormateado ";
                var_dump($importeFormateado);
                echo "<br>";
                
                echo "fechaImpresion ";
                var_dump($fechaImpresion);
                echo "<br>";
                
                echo "cliente ";
                var_dump($cliente);
                echo "<br>";
                
                
                 echo "tipoFactura ";
                var_dump($tipoFactura);
                echo "<br>";
                
                 echo "mysucDoc ";
                var_dump($mysucDoc);
                echo "<br>";
                
                echo "numdoc ";
                var_dump($numdoc);
                echo "<br>";
                
                echo "barCodeString: ". $barCodeString;
           */     
        
        $leading = substr($barCodeString, 0, 5);
        $trailing = substr($barCodeString, 5);
                
        $l = array( 1, 3, 5, 7, 9 );
        $r = array( 3, 5, 7, 9 );
        $sum = 0;
        $i = 0;

        while ($i < strlen($leading)) {
            $sum += $l[$i] * substr($leading, $i, 1);
            $i++;
        }

        $i = 0;
        while ($i < strlen($trailing)) {
            $sum += $r[$i % 4] * substr($trailing, $i, 1);
            $i++;
        }

        $sum /= 2;
        $dv = (int)$sum % 10;
        $barcode = $barCodeString . $dv;

        return $barcode;
    }
}

?>

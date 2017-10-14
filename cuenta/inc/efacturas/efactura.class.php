<?php

class Efactura{
	
	var $tipo;
	var $numero;
	var $razon_social;
	var $domicilio;
	var $ciudad;
	var $pais;
	var $cuit;
	var $condicion_pago;
	var $condicion_iva;
	var $clave_banelco;
	var $clave_link;
	var $fecha_emision;
	var $fecha_vencimiento;
	var $codigo_cliente;
	var $items = array();
	var $total_gravado_21;
	var $total_gravado_27;
	var $iva_21;
	var $iva_27;
	var $iva_13_5 = 0;
	var $iva_10_5 = 0;
	var $percep_iibb;
	var $exento = 0;
	var $subtotal;
	var $total;
	var $total_string;
	var $saldo_a_fecha_emision;
	var $barcode_total;
	var $barcode_saldo;
	var $frase_pie;
	
	var $pdf;
	var $owner;
	var $path_efacturas;
	
	function Efactura($path_efacturas, $owner, $ticket = NULL){
		$this->path_efacturas = $path_efacturas;
		
		require_once($this->path_efacturas.'fpdf/fpdf.php');

		if($ticket){
		    
		    $tmp_tkt = explode("-", $ticket->factura_nro);

  		    $this->sucdoc = $tmp_tkt[0];		    
		    $this->numdoc = $tmp_tkt[1];

		    
			// FIX PARA CA y CB
			$this->letra_tipo = substr($ticket->factura_tipo, 0, 1);
			
			$this->tipodoc_real = $ticket->factura_tipo;			
			$this->tipo = str_replace(array('F', 'C', 'D'), '', $ticket->factura_tipo);
			
			
			$this->numero = $ticket->factura_nro;
			$this->razon_social = $ticket->titular;
			$this->domicilio = $ticket->address;
			$this->ciudad = $ticket->city;
			$this->pais = $ticket->state;
			$this->cuit = $ticket->cuit;
			$this->condicion_pago = $ticket->condpago;
			$this->condicion_iva = $ticket->condiva;
			$this->clave_banelco = $ticket->passwd_banelco;
			$this->clave_link = $ticket->passwd_link;
			$this->fecha_emision = $ticket->date;
			$this->fecha_vencimiento = $ticket->date_expire;
			$this->codigo_cliente = $ticket->userid;
			$this->items = $ticket->comsumo_list;
			/*
			$this->items = array();
			$this->items[0] = array('description' => 'Comunicaciones a celulares hasta el 31/03/2010', 
									'units' => '266 minutos', 
									'importe' => '$ 91,37');
			*/
			$this->total_gravado_21 =$ticket->neto21;
			$this->total_gravado_27 = $ticket->neto27;
			$this->iva_21 = $ticket->iva21;
			$this->iva_27 = $ticket->iva27;
			//$this->iva_13_5 = "X";
			//$this->iva_10_5 = "X";
			$this->percep_iibb = (float)($ticket->perc_iibb);
			//$this->exento = "X";
			$this->subtotal = $ticket->subtotal;
			$this->total = $ticket->total;
			$this->total_string = $ticket->total_string;
			
			$this->cae = $ticket->cae;
			$this->fvtocae = $ticket->fvtocae;
			
			//$this->saldo_a_fecha_emision = "X";
		}
		
		if(!$owner){
			echo "Owner no definido";
			exit();
		}
		
		$this->owner = $owner;
		
		if($owner == 'red'){
		    $this->real_owner = 'Alternativa';
		}elseif($owner == 'telephone2' || $owner == 't2'){
		    $this->real_owner = 'Telephone2';
		}elseif($owner == 'hola'){
		    $this->real_owner = 'HolaTel';
		}elseif($owner == 'latinatel'){
		    $this->real_owner = 'Latinatel';
		}
		
		
		
		$this->pdf = new FPDF('P', 'mm', 'A4');
		
		
	}
	
	function _setBody(){
		$this->pdf->SetFont('Arial','B',40);
		if($this->owner == 'red' || $this->owner == 'telephone2' || $this->owner == 't2'){
			$this->pdf->Text(40.4,16.2, $this->tipo);
		}


		$this->pdf->SetFont('Arial','B',12.5);
		//$this->pdf->Text(154,30, 'F'.$this->tipo .'-'.$this->numero);
		
		$this->pdf->Text(154,30, $this->letra_tipo.$this->tipo .'-'.$this->numero);

		$this->pdf->SetFont('Arial','',7.7);
		$this->pdf->Text(25,47.5, $this->razon_social);

		$this->pdf->Text(25,51.5, $this->domicilio);
		$this->pdf->Text(25,55.5, $this->ciudad);
		$this->pdf->Text(25,59.5, $this->pais);

        if($this->owner != 'latinatel'){
		    $this->pdf->Text(125, 32, $this->cuit);
		    $this->pdf->Text(125, 37.5, $this->condicion_pago);
		    $this->pdf->Text(125, 43, $this->condicion_iva);
		}
		
		if($this->owner == 'red' || $this->owner == 'telephone2' || $this->owner == 't2'){
			$this->pdf->Text(125, 55.5, $this->clave_banelco);
			/*
			if($this->owner == 'red' || $this->owner == 't2' ){
				$this->pdf->Text(125, 61.5, $this->clave_link);
			}
			*/
		}

		$this->pdf->SetY(84);
		$this->pdf->SetX(0);
		foreach($this->items as $items){
			$this->pdf->SetX(4.5);
			$this->pdf->Cell(131, 4.5, $items->description, 0, 0, 'L');
			if($items->units != 0){
				$this->pdf->Cell(42, 4.5, $items->units, 0, 0, 'C');
			}else{
				$this->pdf->Cell(42, 4.5, '', 0, 0, 'C');
			}
			
			$importe = explode(" ", trim($items->importe));
			$this->pdf->Cell(8, 4.5, $importe[0]);
			$this->pdf->Cell(16, 4.5, $importe[1], 0, 1, 'R');

		}

		if($this->tipo == 'A'){
			$this->pdf->Text(17.5,197.5, $this->total_gravado_21);
			$this->pdf->Text(42,197.5, $this->total_gravado_27);
			$this->pdf->Text(63,197.5, $this->iva_21);
			$this->pdf->Text(81,197.5, $this->iva_27);
			$this->pdf->Text(101,197.5, $this->iva_13_5);
			$this->pdf->Text(122,197.5, $this->iva_10_5);
			$this->pdf->Text(144,197.5, $this->percep_iibb);
			$this->pdf->Text(163,197.5, $this->exento);
			$this->pdf->Text(191,197.5, $this->subtotal);
		}
		$this->pdf->Text(188,203.5, $this->total);


		$this->pdf->SetFont('Arial','B',7.7);
		
		if($this->owner == 'latinatel'){ // CONVIERTO FECHAS A AAAA/MM/DD
		    $f_emision_en = explode('/', $this->fecha_emision);
		    $this->fecha_emision = $f_emision_en[2] .'/' .$f_emision_en[1] .'/'.$f_emision_en[0];
		    
		    
		    $f_vencimiento_en = explode('/', $this->fecha_vencimiento);
		    $this->fecha_vencimiento = $f_vencimiento_en[2] .'/' .$f_vencimiento_en[1] .'/'.$f_vencimiento_en[0];
		    
		}
		
		$this->pdf->Text(187, 37.5, $this->fecha_emision);
	    $this->pdf->Text(187, 46.5, $this->fecha_vencimiento);
		
		$this->pdf->Text(190, 55.5, $this->codigo_cliente);


		$this->pdf->SetFont('Arial','B',8);
		$total = explode(" ", trim($this->total));
		if($this->owner == 'red' || $this->owner == 'telephone2' || $this->owner == 't2'){
			$this->pdf->Text(114,212, 'Total factura        '.$total[0].'    '. $total[1]);
		}
		
		if(isset($this->saldo_a_fecha_emision) && ($this->owner == 'red' || $this->owner == 'telephone2' || $this->owner == 't2')){
			$this->pdf->Text(114,233, 'Saldo al ' . $this->fecha_emision . '        $    '. $this->saldo_a_fecha_emision);
		}

		
		if(isset($this->barcode_total) && ($this->owner == 'red' || $this->owner == 'telephone2' || $this->owner == 't2')){
			//$url_barcode = 'https://webseg.alternativa.com.ar/cuenta/bc.ca?id='. $this->barcode_total.'&h='. sha1( $this->barcode_total . "casec*911");
		    $url_barcode = 'http://mipanel.grupoalternativa.com/cuenta/bc.ca?id='. $this->barcode_total.'&h='. sha1( $this->barcode_total . "casec*911");
			//$url_barcode = 'http://localhost/cuenta/bc.ca?id='. $this->barcode_total.'&h='. sha1( $this->barcode_total . "casec*911");
			
			$this->pdf->Image($url_barcode, 113.5, 214, 65, NULL, 'gif');
		}
		
				
		
		if(isset($this->barcode_saldo) && ($this->owner == 'red' || $this->owner == 'telephone2' || $this->owner == 't2')){
			//$url_barcode_saldo = 'https://webseg.alternativa.com.ar/cuenta/bc.ca?id='. $this->barcode_saldo.'&h='. sha1( $this->barcode_saldo . "casec*911");
			$url_barcode_saldo = 'http://mipanel.grupoalternativa.com/cuenta/bc.ca?id='. $this->barcode_saldo.'&h='. sha1( $this->barcode_saldo . "casec*911");
			//$url_barcode_saldo = 'http://localhost/cuenta/bc.ca?id='. $this->barcode_saldo.'&h='. sha1( $this->barcode_saldo . "casec*911");
		
			
			$this->pdf->Image($url_barcode_saldo, 113.5, 234.5, 65, NULL, 'gif');
		}
		
		$this->pdf->SetFont('Arial','',7);
		
		$v_frase_inicial = 258.5;
			
		if(isset($this->frase_pie) && is_array($this->frase_pie) && count($this->frase_pie) > 0){
			foreach($this->frase_pie as $frase){
				$res = null;
				$res2 = null;
				
				$res = $this->trim_text($frase[0], 150, false);
				
				$this->pdf->Text(6,$v_frase_inicial, $res);
				
				
				
				$v_frase_inicial += 4.2;


				if(strlen($res) < strlen($frase[0])){
					$res2 = trim(substr($frase[0], strlen($res)));
					$this->pdf->Text(6,$v_frase_inicial, $res2);
					$v_frase_inicial += 4.2;
				}

				/*
				if (strlen($frase[0]) > 175) {
					$this->pdf->Text(6,$v_frase_inicial, trim(substr($frase[0], 0, 175)));
					$v_frase_inicial += 4.2;
					$this->pdf->Text(6,$v_frase_inicial, trim(substr($frase[0], 175)));
					$v_frase_inicial += 4.2;
				}else{
					$this->pdf->Text(6,$v_frase_inicial, trim($frase[0]));
					$v_frase_inicial += 4.2;
				}
				*/
			}
		}
	}
	
	function trim_text($input, $length, $ellipses = true, $strip_html = true) {
		//strip tags, if desired
		if ($strip_html) {
		    $input = strip_tags($input);
		}
	  
		//no need to trim, already shorter than trim length
		if (strlen($input) <= $length) {
		    return $input;
		}
	  
		//find last space within length
		$last_space = strrpos(substr($input, 0, $length), ' ');
		$trimmed_text = substr($input, 0, $last_space);
	  
		//add ellipses (...)
		if ($ellipses) {
		    $trimmed_text .= '...';
		}
	  
		return $trimmed_text;
	}
	
	function _setHeaders(){
		$this->pdf->AddPage();
		$this->pdf->Image($this->path_efacturas.'background-'.$this->owner .'-'. strtoupper($this->tipo) .'.jpg', 0, 0, 210);
		//$this->pdf->Image($this->path_efacturas.'background-'.$this->owner  .'.jpg', 0, 0, 210);
		$this->pdf->SetFont('Arial','B',7.7);
		if($this->owner == 'latinatel'){
		    $this->pdf->Text(9,47.5, utf8_decode('BILL TO:'));
		}else{
		    $this->pdf->Text(9,47.5, utf8_decode('SEÑOR/ES:'));
		}
		
		if($this->owner == 'latinatel'){
    		$this->pdf->Text(9,51.5, 'ADDRESS:');
    	}else{
    	    $this->pdf->Text(9,51.5, 'DOMICILIO:');
    	}
		if($this->owner == 'latinatel'){
			//$this->pdf->Text(100.1,32, 'RUC:');
		}else{
			$this->pdf->Text(102.1,32, 'CUIT:');
		}
		
		if($this->owner == 'latinatel'){
    		//$this->pdf->Text(100.1,37.5, 'Cond. of Payment:');
	    }else{
	        $this->pdf->Text(102.1,37.5, 'Cond. Pago:');
	    }
	    
	    
	    if($this->owner == 'latinatel'){
	        //$this->pdf->Text(100.1,43, 'Cond. IVA:');
	    }else{	
		    $this->pdf->Text(102.1,43, 'Cond. IVA:');
		}
		
		if($this->owner == 'red' || $this->owner == 'telephone2' || $this->owner == 't2'){
			$this->pdf->Text(102.1,50.3, utf8_decode('Clave de pago electrónico:'));
			$this->pdf->Text(110,55.5, 'Banelco');
			/*
			if($this->owner == 'red' || $this->owner == 't2'){
				$this->pdf->Text(110,61.5, 'Link');
			}
			*/
		}
		
		if($this->owner == 'latinatel'){
		    $this->pdf->Text(153.5,37.5, utf8_decode('Invoice Date:'));
		}else{
    		$this->pdf->Text(153.5,37.5, utf8_decode('Fecha de Emisión:'));
    	}
    	
    	if($this->owner == 'latinatel'){
    	    $this->pdf->Text(153.5,46.5, 'Due Date:');
    	}else{
    		$this->pdf->Text(153.5,46.5, 'Fecha de Vencimiento:');
    	}
    	
    	if($this->owner == 'latinatel'){
    	    $this->pdf->Text(153.5,55.5, utf8_decode('Customer Code:'));
    	}else{
    		$this->pdf->Text(153.5,55.5, utf8_decode('Código de Cliente:'));
    	}
    	
    	if($this->owner == 'latinatel'){
    	    $this->pdf->Text(5,75.5, 'CONCEPTS');
    	}else{
    		$this->pdf->Text(5,75.5, 'CONCEPTOS');
    	}
    	
    	if($this->owner == 'latinatel'){
    	    $this->pdf->Text(152,75.5, 'MINUTES');
    	}else{
    		$this->pdf->Text(152,75.5, 'UNIDADES');
    	}	
    	
    	if($this->owner == 'latinatel'){
    		$this->pdf->Text(182.5,75.5, 'AMOUNTS');
    	}else{
    	    $this->pdf->Text(182.5,75.5, 'IMPORTES');
    	}
    	
		
		if($this->tipo == 'A'){
			$this->pdf->Text(2.1,192.5, 'Total gravado 21%');
			$this->pdf->Text(30,192.5, 'Total gravado 27%');
			$this->pdf->Text(61,192.5, 'IVA 21%');
			$this->pdf->Text(80,192.5, 'IVA 27%');
			$this->pdf->Text(99,192.5, 'IVA 13.5%');
			$this->pdf->Text(120,192.5, 'IVA 10.5%');
			$this->pdf->Text(138,192.5, 'Precep. IIBB');
			$this->pdf->Text(160,192.5, 'Exento');
			$this->pdf->Text(188.5,192.5, 'Subtotal');
		}
		$this->pdf->Text(166,203.5, 'Total');
		
		
		if($this->owner == 'red' || $this->owner == 't2'){
			// DIRECCION RED
			$this->pdf->SetFont('Arial','B',6);
			$this->pdf->Text(81,8.9, 'GUATEMALA 5590 PISO 2');
			$this->pdf->Text(81,11.5, '1425');
			$this->pdf->Text(81,14.4, utf8_decode('CIUDAD AUTÓNOMA'));
			$this->pdf->Text(81,17.1, 'DE BUENOS AIRES');
		
			$this->pdf->SetFont('Arial','',5);
			$this->pdf->Text(108,8.7, 'RED ALTERNATIVA S.A.');
			$this->pdf->Text(108,10.8, 'IVA RESPONSABLE INSCRIPTO');
			$this->pdf->Text(108,13, 'CUIT 30-69898565-4');
			$this->pdf->Text(108,15.1, 'INGRESOS BRUTOS 901-029230-6');
			$this->pdf->Text(108,17.3, 'INICIO DE ACTIVIDADES: DIC. 1998');
		}
		
		if($this->owner == 'telephone2' ){
			// DIRECCION T2
			$this->pdf->SetFont('Arial','B',6);
			$this->pdf->Text(84,8.9, 'GUATEMALA 5590 PISO 2');
			$this->pdf->Text(84,11.5, '1425');
			$this->pdf->Text(84,14.4, utf8_decode('CIUDAD AUTÓNOMA'));
			$this->pdf->Text(84,17.1, 'DE BUENOS AIRES');
		
			$this->pdf->SetFont('Arial','',5);
			$this->pdf->Text(108,8.7, 'TELEPHONE2 S.A.');
			$this->pdf->Text(108,10.8, 'IVA RESPONSABLE INSCRIPTO');
			$this->pdf->Text(108,13, 'CUIT 30-70726752-2');
			$this->pdf->Text(108,15.1, 'INGRESOS BRUTOS 901-052300-1');
			$this->pdf->Text(108,17.3, 'INICIO DE ACTIVIDADES: JUL. 2001');
		}
		
		if($this->owner == 'hola' || $this->owner == 'latinatel'){
			// DIRECCION T2 
			$this->pdf->SetFont('Arial','B',6);
			/*
			$this->pdf->Text(84,8.9, 'Ing. Luis Ponce 1302 ');
			$this->pdf->Text(84,11.5, 'Piso 11 - 11300');
			$this->pdf->Text(84,14.4, 'Montevideo');
			$this->pdf->Text(84,17.1, 'Uruguay');
		    */
		    
			$this->pdf->Text(84,8.9, 'Saez Carlos F. 6431 ');
			$this->pdf->Text(84,11.5, 'Apto 202 - 11502');
			$this->pdf->Text(84,14.4, 'Carrasco - Montevideo');
			$this->pdf->Text(84,17.1, 'Uruguay');		    
		    
			$this->pdf->SetFont('Arial','',5);
			$this->pdf->Text(108,8.7, 'Latinatel SA');
			$this->pdf->Text(108,10.8, '');
			$this->pdf->Text(108,13, 'RUC 21-512054-0011');
			$this->pdf->Text(108,15.1, '');
			$this->pdf->Text(108,17.3, '');
		}
				
		$this->pdf->SetFont('Arial','B',7);
		if($this->tipo == 'A'){
			$this->pdf->Text(38,20.7, utf8_decode('Código N° 01'));
		}else if($this->tipo == 'B'){
			$this->pdf->Text(38,20.7, utf8_decode('Código N° 06'));
		}
		
		// Frase a la izquierda del codigo de barras
		$this->pdf->SetFont('Arial','B',7);
		if($this->owner == 'telephone2'){
			$this->pdf->Text(4,212.7, 'Incluye servicios facturados por Cuenta y Orden de otros prestadores');
			$this->pdf->Text(4,216.7, 'Recargo llamadas a celulares');
		}
		
		if($this->owner == 'red' || $this->owner == 't2'){
			$this->pdf->Text(4,212.7, utf8_decode('Entidades habilitadas para el cobro: Galicia / Pago Fácil / Pagomiscuentas'));
			$this->pdf->Text(4,216.7, utf8_decode('La falta de Pago en Fecha Prevista generará un interés punitorio'));
			$this->pdf->Text(4,220.7, 'de acuerdo al art. 16 del RGCSBT');
		}
		
		$this->pdf->SetFont('Arial','',6);
		
		if($this->owner == 'red' || $this->owner == 't2' || $this->owner == 'telephone2'){
			if(trim($this->cae) != ''){
				$this->pdf->Text(4,250, 'C.A.E.: '. $this->cae);
			}
			
			if(trim($this->fvtocae) != ''){
				$this->pdf->Text(4,252.5, 'Fecha de vencimiento: '. $this->fvtocae);
			}
			
		}
		
		$this->pdf->SetFont('Arial','',7);
		
		$this->pdf->Text(2.5,203.5, $this->total_string);
	}
	
	function _setDorso(){
		if($this->owner == 'red'){
			$this->pdf->AddPage();
			$this->pdf->Image($this->path_efacturas.'page2-'.$this->owner.'.jpg', 0, 0, 210);
			$this->pdf->SetFont('Arial','B',9);
			$this->pdf->Text(29,9, 'Consideraciones Generales');
			
			$parrafos = array(
				'La presente factura se corresponde con las condiciones impositivas consignadas por el cliente en la solicitud de servicio, la cual fue considerada por la compañía con carácter de declaración jurada y fue acreditada mediante los comprobantes que las normas impositivas determinan.',
				'El cliente constituye domicilio en el indicado en la presente factura y la compañía en GUATEMALA 5590 PISO 2 Capital Federal. Ambos acuerdan que en tales domicilios serán válidas todas las notificaciones que se efectúen.',
				'El cliente se compromete a no utilizar el servicio para ningún propósito contrario a la ley.',
				'La compañía se reserva el derecho de modificar todos o cualquiera de los términos y condiciones, incluyendo cargos y tarifas aplicables al servicio, comunicando previamente tal modificación al cliente, quien si no estuviera de acuerdo con la misma podrá solicitar la baja del servicio, de conformidad con el procedimiento previsto en la última cláusula de la presente factura.',
				'La compañía se compromete a informar sobre la emisión y vencimiento de las facturas. De no recibir la factura, el cliente podrá consultarla en la web o solicitarla por cualquiera de los medios de contacto informados, a fin de facilitar su pago.',
				'Los cargos de abonos serán facturados por mes adelantado, en tanto las llamadas efectuadas serán facturadas una vez consumidas hasta la fecha que se indica en el cuerpo de la presente factura.',
				'La compañía se reserva el derecho de facturar al cliente cualquier impuesto o gravamen que se cree en el futuro y que afecte al servicio prestado.',
				'El cliente podrá reclamar a la compañía los cargos facturados, dentro de los 30 días de emisión de la presente factura. Luego de ese período, la factura se considerará conformada por el cliente. Dicho reclamo podrá hacerse vía e-mail a: asistencia@alternativa.com.ar o por fax al (011) 5279-2000 opción 1.',
				'La compañía analizará el reclamo del cliente y se expedirá sobre el particular por el medio que considere conveniente. Si la compañía no aceptara los reclamos del cliente, éste deberá abonar los cargos que hubiera reclamado. Si los aceptara, emitirá el crédito correspondiente.',
				'Si el cliente no realiza ningún pago al vencimiento, dicho incumplimiento facultará a la compañía a suspender el servicio, así como a ejercer las acciones que le provea la ley y reclamar en su caso la indemnización que correspondiera más los daños y perjuicios resultantes.',
				'Atento a lo establecido por los Art. 44 / 46 / 47 del Reglamento General de Clientes del Servicio Básico Telefónico se le informa: Artículo 44. Los prestadores, previo a concretar la suspensión, deberán informar al cliente de tal situación, telefónicamente o por otros medios al menos en DOS (2) oportunidades. Artículo 46. Los prestadores podrán dar de baja en forma definitiva cuando el cliente no abonare las facturas dentro de los SESENTA (60) días corridos posteriores a su vencimiento. Previo a concretar la baja, los prestadores deberán notificar al cliente por medio fehaciente, con al menos CINCO (5) días hábiles de anticipación, la fecha en el que se concretará la misma. La baja no implica la liberación de la obligación de pago de la deuda pendiente. Artículo 47. El servicio suspendido será rehabilitado por los prestadores dentro de las 48 horas hábiles de efectuado el pago de la deuda originaria, más los recargos por mora y el derecho de rehabilitación vigente.',
				'La compañía podrá reclamar al cliente el costo que le genere la imposibilidad del cobro de cualquier cheque o valor agregado por el cliente para la cancelación de su deuda y que fuera rechazado o por cualquier modo no pagado según los términos previstos.',
				'La compañía está facultada para aceptar o no pagos parciales. En caso de que acepte pagos parciales, el cliente reconoce que no se habrá librado de su obligación de pago, hasta el pago total de la deuda, pudiendo la compañía reclamarle la suma no abonada.',
				'La compañía se encuentra facultada a su discreción para imputar los pagos que reciba del cliente a las deudas que éste mantenga con la compañía del modo que considere más conveniente.',
				'Ante cualquier interrupción del servicio el cliente dará aviso a la compañía, con el objeto de que ésta pueda averiguar la causa de tal inconveniente y resolverlo.',
				'La instalación, reparación y remoción de los discadores debe ser realizada o prestada por personal o parte autorizada por la compañía.',
				'La compañía no será responsable por ningún daño al cliente que pueda haber resultado de la instalación, remoción o reparación de los equipos por personal no autorizado por la compañía.',
				'El riesgo de daño, pérdida, robo o destrucción de los discadores, sea total o parcial, deberá ser asumido por el cliente.',
				'Los discadores que sean entregados al cliente son en comodato, debiendo el cliente proceder a su devolución una vez operada la baja efectiva del servicio.'
			);

			$this->pdf->SetFont('Arial','',8.3);
		
			$this->pdf->SetY(13.8);			
			foreach ($parrafos as $linea){
				$this->pdf->Cell(18.5, 3.6, '');
				$this->pdf->MultiCell(0,3.6, chr(149) . ' ' . utf8_decode($linea));
			}
			
			$this->pdf->SetFont('Arial','B',8.5);
			$this->pdf->Text(29, 193, 'Contactos');
			$this->pdf->Text(98, 193, 'Formas de Pago');
			
			$this->pdf->SetFont('Arial','',8.2);
			$this->pdf->Text(29, 201, utf8_decode('Centro de Atención al Cliente:'));
			$this->pdf->Text(29, 205, utf8_decode('Lunes a viernes de 9 a 18 horas.'));
			$this->pdf->SetFont('Arial','B',8.2);
			$this->pdf->Text(29, 208.5, utf8_decode('E-mail: asistencia@alternativa.com.ar'));
			$this->pdf->SetFont('Arial','',8.2);
			$this->pdf->Text(29, 212.7, utf8_decode('Teléfono: (011) 5279-2000 opción 1'));
			$this->pdf->Text(29, 215.6, utf8_decode('Humboldt 1917, Ciudad de Buenos Aires.'));
			$this->pdf->Text(29, 219.4, utf8_decode('C1414CTU Buenos Aires, Argentina'));
			$this->pdf->Text(29, 222.7, utf8_decode('www.alternativa.com.ar'));
			
			$this->pdf->SetFont('Arial','B',8.2);
			$this->pdf->Text(98, 200.7, utf8_decode('Adhesión a débito automático:'));
			$this->pdf->SetFont('Arial','',8.2);
			$this->pdf->Text(98, 204.5, utf8_decode('Tarjeta Visa, American Express, Mastercard o Cta. Cte. / Caja de Ahorro.'));
			$this->pdf->SetFont('Arial','B',8.2);
			$this->pdf->Text(98, 208, utf8_decode('Débito en cuenta bancaria:'));
			$this->pdf->SetFont('Arial','',8.2);
			$this->pdf->Text(98, 211.4, utf8_decode('Por cajeros automáticos o www.pagomiscuentas.com'));
			$this->pdf->SetFont('Arial','B',8.2);
			$this->pdf->Text(98, 215, utf8_decode('Efectivo:'));
			$this->pdf->SetFont('Arial','',8.2);
			$this->pdf->Text(98, 219, utf8_decode('En ventanillas del Banco Galicia, o en sucursales de Pago Fácil.'));
			$this->pdf->SetFont('Arial','B',8.2);
			$this->pdf->Text(98, 222.4, utf8_decode('Cheque:'));
			$this->pdf->SetFont('Arial','',8.2);
			$this->pdf->Text(98, 226, utf8_decode('En ventanillas del Banco Galicia o en Centros de servicios Pago Fácil.'));
			
			
			$this->pdf->SetFont('Arial','',8);
			$this->pdf->SetY(234);			
			$this->pdf->Cell(18.5, 3.6, '');
			$this->pdf->MultiCell(0,3.6,utf8_decode('Señor cliente: si su reclamo no es atendido debidamente o la respuesta del prestador no es satisfactoria, comuníquese gratuitamente con la Comisión Nacional de Comunicaciones al teléfono 0-800-333-3344, para recibir asesoramiento, o directamente envíe su reclamo por correo sin cargo, a través del Apartado Especial 114 (1000) Correo Central, dentro de los plazos del artículo 36 del Reglamento General del Servicio Básico Telefónico. Asimismo, si desea conocer sus derechos y obligaciones, puede consultar el texto del Reglamento General de Clientes del Servicio Básico Telefónico en la Guía Telefónica o solicitarlo a Red Alternativa S.A.'));
			
			$this->pdf->SetFont('Arial','B',9);
			$this->pdf->Text(29, 258, utf8_decode('Consulte términos y condiciones del servicio en www.alternativa.com.ar
'));
		}
		
		if($this->owner == 'telephone2'){
			$this->pdf->AddPage();
			$this->pdf->Image($this->path_efacturas.'page2-'.$this->owner.'.jpg', 0, 0, 210);
			$this->pdf->SetFont('Arial','B',9);
			$this->pdf->Text(18.5,11.6, 'Consideraciones Generales');
			
			$parrafos = array(
				'La presente factura se corresponde con las condiciones impositivas consignadas por el cliente en la solicitud de servicio, la cual fue considerada por la compañía con carácter de declaración jurada y fue acreditada mediante los comprobantes que las normas impositivas determinan.',
				'El cliente constituye domicilio en el indicado en la presente factura y la compañía en Humboldt 1917 Capital Federal. Ambos acuerdan que en tales domicilios serán válidas todas las notificaciones que se efectúen.',
				'El cliente se compromete a no utilizar el servicio para ningún propósito contrario a la ley.',
				'La compañía se reserva el derecho de modificar todos o cualquiera de los términos y condiciones, incluyendo cargos y tarifas aplicables al servicio, comunicando previamente tal modificación al cliente, quien si no estuviera de acuerdo con la misma podrá solicitar la baja del servicio.',
				'La compañía se compromete a informar sobre la emisión y vencimiento de las facturas. De no recibir la factura, el cliente podrá consultarla en la web o solicitarla por cualquiera de los medios de contacto informados, a fin de facilitar su pago.',
				'Los cargos de abonos serán facturados por mes adelantado, en tanto las llamadas efectuadas serán facturadas una vez consumidas hasta la fecha que se indica en el cuerpo de la presente factura.',
				'La compañía se reserva el derecho de facturar al cliente cualquier impuesto o gravamen que se cree en el futuro y que afecte al servicio prestado.',
				'El cliente podrá reclamar a la compañía los cargos facturados, dentro de los 30 días de emisión de la presente factura. Luego de ese período, la factura se considerará conformada por el cliente. Dicho reclamo podrá hacerse vía e-mail a: asistencia@telephone2.com o por fax al 011-4032-1266.',
				'La compañía analizará el reclamo del cliente y se expedirá sobre el particular por el medio que considere conveniente. Si la compañía no aceptara los reclamos del cliente, éste deberá abonar los cargos que hubiera reclamado. Si los aceptara, emitirá el crédito correspondiente.',
				'Si el cliente no realiza ningún pago al vencimiento, dicho incumplimiento facultará a la compañía a suspender el servicio, así como a ejercer las acciones que le provea la ley y reclamar en su caso la indemnización que correspondiera más los daños y perjuicios resultantes.',
				'Atento a lo establecido por los Art. 44 / 46 / 47 del Reglamento General de Clientes del Servicio Básico Telefónico se le informa: Artículo 44. Los prestadores, previo a concretar la suspensión, deberán informar al cliente de tal situación, telefónicamente o por otros medios al menos en DOS (2) oportunidades. Artículo 46. Los prestadores podrán dar de baja en forma definitiva cuando el cliente no abonare las facturas dentro de los SESENTA (60) días corridos posteriores a su vencimiento. Previo a concretar la baja, los prestadores deberán notificar al cliente por medio fehaciente, con al menos CINCO (5) días hábiles de anticipación, la fecha en el que se concretará la misma. La baja no implica la liberación de la obligación de pago de la deuda pendiente. Artículo 47. El servicio suspendido será rehabilitado por los prestadores dentro de las 48 horas hábiles de efectuado el pago de la deuda originaria, más los recargos por mora y el derecho de rehabilitación vigente.',
				'La compañía podrá reclamar al cliente el costo que le genere la imposibilidad del cobro de cualquier cheque o valor agregado por el cliente para la cancelación de su deuda y que fuera rechazado o por cualquier modo no pagado según los términos previstos.',
				'La compañía está facultada para aceptar o no pagos parciales. En caso de que acepte pagos parciales, el cliente reconoce que no se habrá librado de su obligación de pago, hasta el pago total de la deuda, pudiendo la compañía reclamarle la suma no abonada.',
				'La compañía se encuentra facultada a su discreción para imputar los pagos que reciba del cliente a las deudas que éste mantenga con la compañía del modo que considere más conveniente.',
				'Ante cualquier interrupción del servicio el cliente dará aviso a la compañía, con el objeto de que ésta pueda averiguar la causa de tal inconveniente y resolverlo.'
			);

			$this->pdf->SetFont('Arial','',8.3);
		
			$this->pdf->SetY(16.2);			
			foreach ($parrafos as $linea){
				$this->pdf->Cell(3.2, 3.6, '');
				$this->pdf->MultiCell(0,3.6, chr(149) . ' ' . utf8_decode($linea));
			}
			
			$this->pdf->SetFont('Arial','B',8.5);
			$this->pdf->Text(19, 184.2, 'Contactos');
			$this->pdf->Text(83.5, 184.2, 'Formas de Pago');
			
			$this->pdf->SetFont('Arial','',8.2);
			$this->pdf->Text(13.5, 190, utf8_decode('Centro de Atención al Cliente:'));
			$this->pdf->Text(13.5, 192.9, utf8_decode('Lunes a viernes de 9 a 18 horas.'));
			$this->pdf->SetFont('Arial','B',8.2);
			$this->pdf->Text(13.5, 196.3, utf8_decode('E-mail: asistencia@telephone2.com'));
			$this->pdf->SetFont('Arial','',8.2);
			$this->pdf->Text(13.5, 199.5, utf8_decode('Teléfono: 0800-345-1070'));
			$this->pdf->Text(13.5, 202.7, utf8_decode('Humboldt 1917, Ciudad de Buenos Aires.'));
			$this->pdf->Text(13.5, 205.7, utf8_decode('C1414CTU Buenos Aires, Argentina'));
			$this->pdf->Text(13.5, 208.9, utf8_decode('www.telephone2.com'));
			
			$this->pdf->SetFont('Arial','B',8.2);
			$this->pdf->Text(79, 190, utf8_decode('Adhesión a débito automático:'));
			$this->pdf->SetFont('Arial','',8.2);
			$this->pdf->Text(79, 194, utf8_decode('Tarjeta Visa, American Express, Mastercard o Cta. Cte. / Caja de Ahorro. Solicite su adhesión'));
			$this->pdf->Text(79, 197, utf8_decode('vía e-mail a asistencia@telephone2.com.'));
			
			$this->pdf->SetFont('Arial','B',8.2);
			$this->pdf->Text(79, 201.6, utf8_decode('Débito en cuenta bancaria:'));
			
			
			$this->pdf->SetFont('Arial','',8.2);
			$this->pdf->Text(79, 205.4, utf8_decode('Por cajeros automáticos de la red Banelco o en www.pagomiscuentas.com'));
			$this->pdf->Text(79, 208.3, utf8_decode('ingresando el número de cliente o cuenta que figura en su factura.'));
			
			$this->pdf->SetFont('Arial','B',8.2);
			$this->pdf->Text(79, 213, utf8_decode('Efectivo:'));
			$this->pdf->SetFont('Arial','',8.2);
			$this->pdf->Text(79, 216.7, utf8_decode('En ventanillas del Banco Galicia, o en sucursales de Pago Fácil o Rapipago.'));
			$this->pdf->SetFont('Arial','B',8.2);
			$this->pdf->Text(79, 221.8, utf8_decode('Cheque:'));
			$this->pdf->SetFont('Arial','',8.2);
			$this->pdf->Text(79, 225, utf8_decode('En ventanillas del Banco Galicia o en Centros de servicios Pago Fácil.'));
			$this->pdf->SetFont('Arial','B',8.2);
			$this->pdf->Text(79, 229.4, utf8_decode('Pago telefónico:'));
			$this->pdf->SetFont('Arial','',8.2);
			$this->pdf->Text(79, 232.8, utf8_decode('Tarjeta Visa, American Express o Mastercard llamando a Rapipago por teléfono al '));
			$this->pdf->Text(79, 235.8, utf8_decode('0810-345-7274.'));
			
			
			
			
			$this->pdf->SetFont('Arial','',8);
			$this->pdf->SetY(243);			
			$this->pdf->Cell(3, 3.6, '');
			$this->pdf->MultiCell(0,3.6,utf8_decode('Señor cliente: si su reclamo no es atendido debidamente o la respuesta del prestador no es satisfactoria, comuníquese gratuitamente con la Comisión Nacional de Comunicaciones al teléfono 0800 333 3344, para recibir asesoramiento, o directamente envíe su reclamo por correo sin cargo, a través del Apartado Especial 114 (1000) Correo Central, dentro de los plazos del artículo 36 del Reglamento General del Servicio Básico Telefónico. Asimismo, si desea conocer sus derechos y obligaciones, puede consultar el texto del Reglamento General de Clientes del Servicio Básico Telefónico en la Guía Telefónica o solicitarlo a Telephone 2 S.A.'));
			
			$this->pdf->SetFont('Arial','B',8);
			$this->pdf->Text(13.5, 268, utf8_decode('Consulte términos y condiciones del servicio en www.telephone2.com'));
		}
		
		if($this->owner == 't2'){
			$this->pdf->AddPage();
			$this->pdf->Image($this->path_efacturas.'page2-'.$this->owner.'.jpg', 0, 0, 210);
			$this->pdf->SetFont('Arial','B',9);
			$this->pdf->Text(18.5,11.6, 'Consideraciones Generales');
			
			$parrafos = array(
				'La presente factura se corresponde con las condiciones impositivas consignadas por el cliente en la solicitud de servicio, la cual fue considerada por la compañía con carácter de declaración jurada y fue acreditada mediante los comprobantes que las normas impositivas determinan.',
				'El cliente constituye domicilio en el indicado en la presente factura y la compañía en Humboldt 1917 Capital Federal. Ambos acuerdan que en tales domicilios serán válidas todas las notificaciones que se efectúen.',
				'El cliente se compromete a no utilizar el servicio para ningún propósito contrario a la ley.',
				'La compañía se reserva el derecho de modificar todos o cualquiera de los términos y condiciones, incluyendo cargos y tarifas aplicables al servicio, comunicando previamente tal modificación al cliente, quien si no estuviera de acuerdo con la misma podrá solicitar la baja del servicio.',
				'La compañía se compromete a informar sobre la emisión y vencimiento de las facturas. De no recibir la factura, el cliente podrá consultarla en la web o solicitarla por cualquiera de los medios de contacto informados, a fin de facilitar su pago.',
				'Los cargos de abonos serán facturados por mes adelantado, en tanto las llamadas efectuadas serán facturadas una vez consumidas hasta la fecha que se indica en el cuerpo de la presente factura.',
				'La compañía se reserva el derecho de facturar al cliente cualquier impuesto o gravamen que se cree en el futuro y que afecte al servicio prestado.',
				'El cliente podrá reclamar a la compañía los cargos facturados, dentro de los 30 días de emisión de la presente factura. Luego de ese período, la factura se considerará conformada por el cliente. Dicho reclamo podrá hacerse vía e-mail a: asistencia@telephone2.com o por fax al (011) 5279-2000 opción 1.',
				'La compañía analizará el reclamo del cliente y se expedirá sobre el particular por el medio que considere conveniente. Si la compañía no aceptara los reclamos del cliente, éste deberá abonar los cargos que hubiera reclamado. Si los aceptara, emitirá el crédito correspondiente.',
				'Si el cliente no realiza ningún pago al vencimiento, dicho incumplimiento facultará a la compañía a suspender el servicio, así como a ejercer las acciones que le provea la ley y reclamar en su caso la indemnización que correspondiera más los daños y perjuicios resultantes.',
				'Atento a lo establecido por los Art. 44 / 46 / 47 del Reglamento General de Clientes del Servicio Básico Telefónico se le informa: Artículo 44. Los prestadores, previo a concretar la suspensión, deberán informar al cliente de tal situación, telefónicamente o por otros medios al menos en DOS (2) oportunidades. Artículo 46. Los prestadores podrán dar de baja en forma definitiva cuando el cliente no abonare las facturas dentro de los SESENTA (60) días corridos posteriores a su vencimiento. Previo a concretar la baja, los prestadores deberán notificar al cliente por medio fehaciente, con al menos CINCO (5) días hábiles de anticipación, la fecha en el que se concretará la misma. La baja no implica la liberación de la obligación de pago de la deuda pendiente. Artículo 47. El servicio suspendido será rehabilitado por los prestadores dentro de las 48 horas hábiles de efectuado el pago de la deuda originaria, más los recargos por mora y el derecho de rehabilitación vigente.',
				'La compañía podrá reclamar al cliente el costo que le genere la imposibilidad del cobro de cualquier cheque o valor agregado por el cliente para la cancelación de su deuda y que fuera rechazado o por cualquier modo no pagado según los términos previstos.',
				'La compañía está facultada para aceptar o no pagos parciales. En caso de que acepte pagos parciales, el cliente reconoce que no se habrá librado de su obligación de pago, hasta el pago total de la deuda, pudiendo la compañía reclamarle la suma no abonada.',
				'La compañía se encuentra facultada a su discreción para imputar los pagos que reciba del cliente a las deudas que éste mantenga con la compañía del modo que considere más conveniente.',
				'Ante cualquier interrupción del servicio el cliente dará aviso a la compañía, con el objeto de que ésta pueda averiguar la causa de tal inconveniente y resolverlo.',
				'El servicio de PRESUSCRIPCION es brindado por Telephone 2 SA cuit 30-70726752-2'
			);

			$this->pdf->SetFont('Arial','',8.3);
		
			$this->pdf->SetY(16.2);			
			foreach ($parrafos as $linea){
				$this->pdf->Cell(3.2, 3.6, '');
				$this->pdf->MultiCell(0,3.6, chr(149) . ' ' . utf8_decode($linea));
			}
			
			$this->pdf->SetFont('Arial','B',8.5);
			$this->pdf->Text(19, 184.2, 'Contactos');
			$this->pdf->Text(83.5, 184.2, 'Formas de Pago');
			
			$this->pdf->SetFont('Arial','',8.2);
			$this->pdf->Text(13.5, 190, utf8_decode('Centro de Atención al Cliente:'));
			$this->pdf->Text(13.5, 192.9, utf8_decode('Lunes a viernes de 9 a 18 horas.'));
			$this->pdf->SetFont('Arial','B',8.2);
			$this->pdf->Text(13.5, 196.3, utf8_decode('E-mail: asistencia@telephone2.com'));
			$this->pdf->SetFont('Arial','',8.2);
			$this->pdf->Text(13.5, 199.5, utf8_decode('Teléfono: 0800-345-1070'));
			$this->pdf->Text(13.5, 202.7, utf8_decode('Humboldt 1917, Ciudad de Buenos Aires.'));
			$this->pdf->Text(13.5, 205.7, utf8_decode('C1414CTU Buenos Aires, Argentina'));
			$this->pdf->Text(13.5, 208.9, utf8_decode('www.telephone2.com'));
			
			$this->pdf->SetFont('Arial','B',8.2);
			$this->pdf->Text(79, 190, utf8_decode('Adhesión a débito automático:'));
			$this->pdf->SetFont('Arial','',8.2);
			$this->pdf->Text(79, 194, utf8_decode('Tarjeta Visa, American Express, Mastercard o Cta. Cte. / Caja de Ahorro. Solicite su adhesión'));
			$this->pdf->Text(79, 197, utf8_decode('vía e-mail a asistencia@telephone2.com.'));
			
			$this->pdf->SetFont('Arial','B',8.2);
			$this->pdf->Text(79, 201.6, utf8_decode('Débito en cuenta bancaria:'));
			
			
			$this->pdf->SetFont('Arial','',8.2);
			$this->pdf->Text(79, 205.4, utf8_decode('Por cajeros automáticos de la red Banelco o en www.pagomiscuentas.com'));
			$this->pdf->Text(79, 208.3, utf8_decode('ingresando el número de cliente o cuenta que figura en su factura.'));
			
			$this->pdf->SetFont('Arial','B',8.2);
			$this->pdf->Text(79, 213, utf8_decode('Efectivo:'));
			$this->pdf->SetFont('Arial','',8.2);
			$this->pdf->Text(79, 216.7, utf8_decode('En ventanillas del Banco Galicia, o en sucursales de Pago Fácil o Rapipago.'));
			$this->pdf->SetFont('Arial','B',8.2);
			$this->pdf->Text(79, 221.8, utf8_decode('Cheque:'));
			$this->pdf->SetFont('Arial','',8.2);
			$this->pdf->Text(79, 225, utf8_decode('En ventanillas del Banco Galicia o en Centros de servicios Pago Fácil.'));
			$this->pdf->SetFont('Arial','B',8.2);
			$this->pdf->Text(79, 229.4, utf8_decode('Pago telefónico:'));
			$this->pdf->SetFont('Arial','',8.2);
			$this->pdf->Text(79, 232.8, utf8_decode('Tarjeta Visa, American Express o Mastercard llamando a Rapipago por teléfono al '));
			$this->pdf->Text(79, 235.8, utf8_decode('0810-345-7274.'));
			
			
			
			$this->pdf->SetFont('Arial','',8);
			$this->pdf->SetY(243);			
			$this->pdf->Cell(3, 3.6, '');
			$this->pdf->MultiCell(0,3.6,utf8_decode('Señor cliente: si su reclamo no es atendido debidamente o la respuesta del prestador no es satisfactoria, comuníquese gratuitamente con la Comisión Nacional de Comunicaciones al teléfono 0800 333 3344, para recibir asesoramiento, o directamente envíe su reclamo por correo sin cargo, a través del Apartado Especial 114 (1000) Correo Central, dentro de los plazos del artículo 36 del Reglamento General del Servicio Básico Telefónico. Asimismo, si desea conocer sus derechos y obligaciones, puede consultar el texto del Reglamento General de Clientes del Servicio Básico Telefónico en la Guía Telefónica o solicitarlo a Red Alternativa S.A.'));
			
			$this->pdf->SetFont('Arial','B',8);
			$this->pdf->Text(13.5, 268, utf8_decode('Consulte términos y condiciones del servicio en www.telephone2.com'));
		}
	
	}
	
	function output($toweb = true, $toattach= false){
		$this->_setHeaders();
		$this->_setBody();
		
		if($toattach === true){
			return $this->pdf->Output('', 'S');
		}elseif($toweb){
			$this->pdf->Output('factura_'. str_replace('/', '_', $this->fecha_emision) .'.pdf', 'D');
		}else{
	
		    $nombre_pdf = $this->real_owner .'_'.$this->tipodoc_real .'_' . $this->sucdoc .'_' .$this->numdoc .'_Fecha_' . str_replace('/', '-', $this->fecha_emision) .'_Cliente_'. $this->codigo_cliente.'.pdf';
			$this->pdf->Output($toattach. '/'.$nombre_pdf, 'F');
			return $nombre_pdf;

		}
	}
		
	function output_dorso(){
		$this->_setDorso();
		
		$this->pdf->Output('factura_'. str_replace('/', '_', $this->fecha_emision) .'_dorso.pdf', 'D');
	}

}


?>

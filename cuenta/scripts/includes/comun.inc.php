<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

class Comun
{
    function enviaMailInforme($header, $listaCfg, $debug, $email_debug, $owner_debug, $HEADERS_INFORME_SEMANAL,$data, $base, $SMTP_SERVER, $log, $fecha_hasta){
        global $email_debug;
        $val= new Validator;
    
        
        if ($debug) {
        	$cust_dat["destinatario"] = $email_debug;
        	echo "se fuerza destinatario de " . $header->email . " a " . $email_debug . "\n";
        } else {
        	$cust_dat["destinatario"] = $header->email;
        }

        if ($cust_dat["destinatario"] and $val->email($cust_dat["destinatario"],150,4)) {
                
            if($debug){
                if($owner_debug > 0){
                    $datoOwner = $listaCfg[$owner_debug];
                }else{
                    $datoOwner = $listaCfg[$header->owner_id];
                }
            }else{
                $datoOwner = $listaCfg[$header->owner_id];
            }
           
            # creo el contenido que será adjuntado
            $csv_obj = new CSV();
            $csv = $csv_obj->generarCSV($HEADERS_INFORME_SEMANAL,$data);

            #configuro y envío el email
            
            $mail_obj = new Mailer($debug);
            
			$str_att=array ("informe_consumo.csv" => array("application/csv","$csv"));
			
            // $cust_dat=$datos;//QUE HACIA ESTO ACA???
           
          
            
            $cust_dat["cliente_id"]=$header->cliente_id;
            $cust_dat["rsocial"]=$header->rsocial;
            $cust_dat["fecha_hasta"] = $fecha_hasta;
        	
        	$imgs = $datoOwner["imgs"];
        	$subject = $datoOwner["subject"];
			$cust_dat["remitente"] = $datoOwner["from"];
			$cust_dat["nombre_remitente"] = $datoOwner["from_name"];
			$cust_dat["bounce"] = $datoOwner["bounce"];
        	
        	$temp_html = "templates/" . $datoOwner["carpeta"] . "/informes_mail.tpl";
        	$temp_plano = "templates/" . $datoOwner["carpeta"] . "/informes_mail.txt";
        	$img_sdir = "templates/" . $datoOwner["carpeta"] . "/imgs";
        	
        	
            
            $mail_obj->init($cust_dat, $temp_html, $imgs, $adjs, 
            	$temp_plano, $base, $img_sdir, $att_dir, $str_att, 
            	$subject, "", $SMTP_SERVER, $cust_dat["bounce"]);	
            	
        	$mail_obj->prepare();
        	
        	$res_envio = $mail_obj->send();

            if($res_envio) {	
				$log->mkLog("Mensaje enviado con exito al cliente ". $header->cliente_id ." - Email:  " . $cust_dat["destinatario"], "INFO");
				echo "Mensaje enviado con exito al cliente ". $header->cliente_id ." - Email:  " . $cust_dat["destinatario"] ."\n";
				return true;
			} else {
				$log->mkLog("Error al enviar el mail a " . $header->cliente_id . " mail: ". $cust_dat["destinatario"], "Error");
				return false;
			}
			
		} else {
			$log->mkLog("Direccion de e-mail no definida o invalida para el cliente " . $header->cliente_id . " EMAIL: ".  $cust_dat["destinatario"],"Error");
			return false;
		}
    
    }

	static function enviaMailFactura($header, $lineas, $trafico, $datos, $envio, $debug, $HEADERS_TRAFICO, $config_email, $com_obj, $base, $log, $SMTP_SERVER, $BOUNCE_MAILS_TO){
		$val= new Validator;
        global $email_debug;
		
        if ($header->email and $val->email($header->email, 150, 4)){

			$TEMPLATE_FACTURA_HTML = "templates/" . $envio->carpeta . "/factura.tpl";
			$TEMPLATE_LINEA = "templates/" . $envio->carpeta . "/linea.tpl";
			$TEMPLATE_IVA = "templates/" . $envio->carpeta . "/disciva.tpl";

            $mail_obj = new Mailer($debug);
            

            /* VIEJA FACTURA EN HTML
            
			// Genero la factura
			$factura_html = $com_obj->generarFactura($header, $lineas, $TEMPLATE_FACTURA_HTML, $TEMPLATE_LINEA, $TEMPLATE_IVA, $base, $envio->carpeta);
            
            $str_att = array ('factura.html'=> array("HTML archive", "$factura_html"));    
   
            */
            
//var_dump($header);

//echo 'php /home/httpd/zonasegura.grupoalternativa.com/cuenta/scripts/generapdf.php '.$header->cliente_id.' '. $header->owner_id .' '. $header->fechemision;

			$res1 = exec('php /home/httpd/zonasegura.grupoalternativa.com/cuenta/scripts/generapdf.php '.$header->cliente_id.' '. $header->owner_id .' '. $header->fechemision);


            $res = file_get_contents('/home/httpd/zonasegura.grupoalternativa.com/cuenta/scripts/pdf/'.$res1);
           
            $str_att = array ($res1=> array("PDF archive", "$res"));  
            
           

			if(count($trafico) and $header->detalle_consumo) {
				$csv_obj=new CSV;
				$csv=$csv_obj->generarCSV($HEADERS_TRAFICO, $trafico);
				$str_att["detalle_consumo.csv"] = array("CSV archive", "$csv");
			}

			$cust_dat = $datos;

			if ($debug) { // Envio el mail a la direccion de debug
				$cust_dat["destinatario"] = $email_debug;
			}else{
				$cust_dat["destinatario"] = $header->email;
			}

			
			// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			//$cust_dat["destinatario"] = "sebastian@promaker.com.ar";

			$cust_dat["cliente_id"] = $header->cliente_id;
			$cust_dat["rsocial"] = $header->rsocial;

			$imgs = $config_email["imgs"];

			$subject = $config_email["subject"];

			$cust_dat["remitente"] = $config_email["from"];
			$cust_dat["nombre_remitente"] = $config_email["from_name"];

			$temp_html = "templates/" . $envio->carpeta . "/facturas_mail.tpl";
			$temp_plano = "templates/" . $envio->carpeta . "/facturas_mail.txt";
			$img_sdir = "templates/" . $envio->carpeta . "/imgs";

			$mail_obj->init($cust_dat, $temp_html, $imgs, $adjs, $temp_plano, $base, $img_sdir, $att_dir, $str_att, $subject, "", $SMTP_SERVER, $BOUNCE_MAILS_TO);
			$mail_obj->prepare();
			
			print_r($cust_dat);
			echo "ENVIO A ". $cust_dat["destinatario"];
///// No se por que estaba este exit		exit;
			$res_envio = $mail_obj->send();
			
			if($res_envio) {	
				$log->mkLog("Mensaje enviado con exito al cliente ". $header->cliente_id ." - Email:  " . $cust_dat["destinatario"], "INFO");
				return true;
			} else {
				$log->mkLog("Error al enviar el mail a " . $header->cliente_id . " mail: ". $cust_dat["destinatario"], "Error");
				return false;
			}
		} else {
			$log->mkLog("Direccion de e-mail no definida o invalida para el cliente " . $header->cliente_id,"Error");
			return false;
		}

	}
	
	
    function getIvaHtml($header,$simb_moneda,$template_file)
    {
        $html=join("",file($template_file));
        $html=str_replace('<%neto%>',$simb_moneda." ".$header->neto,$html);
        $html=str_replace('<%neto27%>',$simb_moneda." ".$header->neto27,$html);
        $html=str_replace('<%iva%>',$simb_moneda." ".$header->iva,$html);
        $html=str_replace('<%iva27%>',$simb_moneda." ".$header->iva27,$html);
        $html=str_replace('<%ivani%>',$simb_moneda." ".$header->ivani,$html);
        $html=str_replace('<%iva27ni%>',$simb_moneda." ".$header->iva27ni,$html);
        $html=str_replace('<%suma%>',$simb_moneda." ".$header->total,$html);
        return $html; 
    }

    function getLineasHtml($lineas,$comprobante_id,$simb_moneda,$mercado_desc,$template_file)
    {
        $template=join("",file($template_file));
        $html="";
        foreach($lineas as $linea)
        {
            $aux=str_replace('<%comprobante_id%>',$comprobante_id,$template);
            $aux=str_replace('<%mercado_desc%>',$mercado_desc,$aux);
            $aux=str_replace('<%codlinea%>',$linea->codlinea,$aux);
            $aux=str_replace('<%linea%>',$linea->desclinea,$aux);
            $minutos=$linea->minutos!=0 ? $linea->minutos : '';
            $aux=str_replace('<%minutos%>',$minutos,$aux);
            $aux=str_replace('<%importe%>',$simb_moneda." ".$linea->subtotal,$aux);
            $html.=$aux;
        }
        return $html;
    }
    
    
    function generarBarCode($header, $topay){
        if(strstr($topay, "."))
        {
           list ($a, $b) = explode(".", $topay);
           if(strlen($b) == 1)
        $b = $b . "0";

           $cents = $b;
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
        $tipoFactura = ($header->tipodoc == "FA") ? 1 : ($header->tipodoc == "FB") ? 2 : 3;
        $mysucDoc = sprintf("%02d", (int) $header->sucdoc);


        switch($header->carpeta){
            case "telephone2":
	            $barCodeString = '364' . $importeFormateado . $fechaImpresion .  sprintf("%08d", (int) $numdoc) . $header->cliente_id . '0' . $importeFormateado .$fechaImpresion;
            break;
            case "t2":
                if(stripos($header->cliente_id, 'C') === false){
	                $cliente = $header->cliente_id;
                }else{
	                $cliente = str_replace('C', '0', $header->cliente_id);
                }
                
	            $barCodeString = '143' . $importeFormateado . $fechaImpresion .$cliente . '0' . $tipoFactura . $mysucDoc . sprintf("%06d", (int) $header->numdoc);
            break;
            case "red":
                if(stripos($header->cliente_id, 'C') === false){
	                $cliente = $header->cliente_id;
                }else{
	                $cliente = str_replace('C', '0', $header->cliente_id);
                }
	            $barCodeString = '143' . $importeFormateado . $fechaImpresion . $cliente . '0' . $tipoFactura . $mysucDoc . sprintf("%06d", (int) $header->numdoc);
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
        
        switch($header->carpeta){
            case "telephone2":
	            return 'https://webseg.telephone2.com/cuenta/bc.ca?id='. $barcode.'&h='. sha1( $barcode . "casec*911");
            break;
            case "t2":
	            return 'https://webseg.telephone2.com/cuenta/bc.ca?id='. $barcode.'&h='. sha1( $barcode . "casec*911");
            break;
            case "red":
	            return 'https://webseg.alternativa.com.ar/cuenta/bc.ca?id='. $barcode.'&h='. sha1( $barcode . "casec*911");
            break;
        }
        
        
    
    }
    
    
   
    function generarFactura($header, $lineas, $TEMPLATE_FACTURA_HTML, 
    		$TEMPLATE_LINEA, $TEMPLATE_IVA, $base, $carpetaOwnner) {

        $TEMPLATE_FACTURA_HTML="$base/$TEMPLATE_FACTURA_HTML";
        $TEMPLATE_LINEA="$base/$TEMPLATE_LINEA";
        $TEMPLATE_IVA="$base/$TEMPLATE_IVA";
        if(!is_readable($TEMPLATE_FACTURA_HTML) || !is_readable($TEMPLATE_LINEA) ||!is_readable($TEMPLATE_IVA))
        {
            return null;
        }
        else
        {
        
       
      
            $factura=join("",file($TEMPLATE_FACTURA_HTML));
            
            $mercado_desc = $carpetaOwnner; //$header->mercado == 1 ? 'red' : 'hola';
            $tipo_factura=substr($header->tipodoc,1,1);
            $nfactura=sprintf("%04d-%08d",$header->sucdoc,$header->numdoc);
            $fechaemision=substr($header->fechemision,8,2)."/".substr($header->fechemision,5,2)."/".substr($header->fechemision,0,4);
            $fechvto=substr($header->fechvto,8,2)."/".substr($header->fechvto,5,2)."/".substr($header->fechvto,0,4);

            $factura=str_replace('<%mercado_desc%>',$mercado_desc,$factura);
            $factura=str_replace('<%tipo_factura%>',$tipo_factura,$factura);
            $factura=str_replace('<%nfactura%>',$nfactura,$factura);
            $factura=str_replace('<%fechaemision%>',$fechaemision,$factura);
            $factura=str_replace('<%fechvto%>',$fechvto,$factura);
            
            $factura=str_replace('<%cae%>',$header->cae,$factura);
            $factura=str_replace('<%fvtocae%>',$header->fvtocae,$factura);
            
            $factura=str_replace('<%cpebanelco%>',$header->cpebanelco,$factura);
            $factura=str_replace('<%cuit%>',$header->cuit,$factura);
            $factura=str_replace('<%cpelink%>',$header->cpelink,$factura);
            $factura=str_replace('<%domicilio%>',$header->domicilio,$factura);
            $factura=str_replace('<%localidad%>',$header->localidad,$factura);
            $factura=str_replace('<%provincia%>',$header->provincia,$factura);
            $factura=str_replace('<%cliente_id%>',$header->cliente_id,$factura);
            $factura=str_replace('<%rsocial%>',$header->rsocial,$factura);
            $factura=str_replace('<%condpago%>',$header->condpago,$factura);
            $factura=str_replace('<%condiva%>',$header->condiva,$factura);
            $text_moneda='';
            $simb_moneda='';
            switch($header->moneda)
            {
                case '1':
                    $text_moneda="D&oacute;lares";
                    $simb_moneda='u$s';
                break;
                case '2':
                    $text_moneda="Pesos";
                    $simb_moneda='$';
                break;
                case '3':
                    $text_moneda="Pesos Mex.";
                    $simb_moneda='$';
                break;
            }
            $currency= new Currency;
            $factura=str_replace('<%valor_letras%>',"$text_moneda ".$currency->currency2Txt(number_format($header->total,2)),$factura);
            $factura=str_replace('<%total%>',"$simb_moneda ".number_format($header->total,2),$factura);
            $factura=str_replace('<%lineas%>',$this->getLineasHtml($lineas,$header->tipodoc."-".$nfactura,$simb_moneda,$mercado_desc,$TEMPLATE_LINEA),$factura);
            if($tipo_factura=='B' || $tipo_factura=='E')
            {
                $factura=str_replace('<%discrimina%>','',$factura);
            }
            else
            {
                $factura=str_replace('<%discrimina%>',$this->getIvaHtml($header,$simb_moneda,$TEMPLATE_IVA),$factura);            
            }
            
            //print_r($header);
            
            
            if($header->carpeta == 'red' || $header->carpeta == 'telephone2' || $header->carpeta == 't2'){
                //define('INCLUDE_PATH', '../inc/');
                //require_once('../inc/data/payment_gateways.php');
                //require_once('../inc/data/payment_gateways_pago_facil.php');
                
                //$barcode_total = p_gateways_pago_facil::static_get_barcode_number($ticketid, $tipodoc, $sucdoc, $numdoc, $myticket, $real_ticket->itotal, ca_session::get_userid());
              
                
                

                $url_barcode = self::generarBarCode($header, $header->total);
                $factura=str_replace('<%urlbarcode%>',$url_barcode,$factura);
                
                
                /* REVISAR INTEGRACION O COPIAR QUERY
                $desde = '01/01/1990';
				$hasta_tmp = explode("/", $header->fechemision); // Tiene que estar en mm/dd/YYYY
				$hasta = $hasta_tmp[1] ."/" .$hasta_tmp[0] ."/". $hasta_tmp[2];
				
				$ccd = new ca_cc($header->cliente_id, $desde, $hasta);
				
				$saldo = $ccd->cc_get_saldo_final($desde, $hasta);
				
				$saldo = $saldo - $header->total;
				
				$saldo = number_format(($saldo + $real_ticket->itotal), 2, '.', '');
                
                echo $saldo;
                */
                
            }
            
            
            
           
            
            return $factura;
        }
    }

    ###############################################################################################################################
    ##############################################     Funciones de Soporte     ###################################################
    
    function createPidFile($pidfile)
    {
        if(!file_exists ($pidfile))
        {
            return touch($pidfile);
        }
        else
        {
            return 0;
        }
    }

    ##############################################     Funciones de Soporte     ###################################################
    ###############################################################################################################################

}
?>

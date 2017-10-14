<?php

define('DEBUG', true);


$pidfile = '/home/httpd/zonasegura.grupoalternativa.com/html/cobranzas/procesa_pagos.pid';

$myFile = "log_procesa_pagos.log";
$fh = fopen($myFile, 'a');

fwrite($fh, date("H:i:s") . " - INICIA LA EJECUCION DEL SCRIPT \n");

if(file_exists($pidfile)){
    echo "EL PROCESO YA SE ESTA CORRIENDO";
    fwrite($fh, date("H:i:s") . " - EL PROCESO YA ESTA CORRIENDO. EXIT. \n");
    exit;
}

$res = touch($pidfile);

if(!$res){
    echo "NO PUEDO GENERAR PID";
    fwrite($fh, date("H:i:s") . " - NO SE PUEDE GENERAR EL PID. EXIT \n");
    exit;
}




if(DEBUG){ 
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);


}else{ 
	ini_set('display_errors', 0);
	ini_set('error_reporting', 0);
}

require('inc/conf.php');


// ADODB
require_once('inc/adodb/adodb-exceptions.inc.php');
require_once('inc/adodb/adodb.inc.php');
$db = ADONewConnection('mssql');
$db->Connect(MSSQL_DB_SERVER, MSSQL_DB_USERNAME, MSSQL_DB_PASSWORD, MSSQL_DB_NAME);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;


require_once ('inc/litle/LitleOnline.php');  

// TEST!
//$res = $db->getAll("SELECT *, CONVERT(CHAR(10), fecha_carga, 103) as f_fecha_carga FROM cobranzas_Litle WHERE estado_presentacion = 1 AND litle_estado = 1 ORDER BY fecha_carga");

// OK
$res = $db->getAll("SELECT *, CONVERT(CHAR(10), fecha_carga, 103) as f_fecha_carga FROM cobranzas_Litle WHERE estado_presentacion = 1 AND  litle_estado = 0 ORDER BY fecha_carga");

print_r($res);

foreach($res as $r){
	fwrite($fh, date("H:i:s") . " - PROCESO PAGO ID ". $r['id'] ." \n");
    if($r['tipo_transac'] == 1){ // SALE
        echo "Procesa SALE ID ". $r['id'] ."\n";
        

        if (strtoupper($r['tipo']) == 'TOKEN'){
            $sale_info = array(
            'orderId' => $r['id'],
            'id' => $r['id'],
            'amount' => str_replace('.', '', $r['importe']),
            'orderSource'=>'ecommerce',
            'token'=>array(
                'litleToken' =>$r['numero'],
                'expDate' => $r['vto'],
                ),
            'billToAddress'=>array(
                'name' => $r['Nombre'],
                'addressLine1' => $r['Direccion'],
                'phone' => $r['Telefono']
                )
            );
        
        
        }else{ // Tarjeta
        
            $sale_info = array(
            'orderId' => $r['id'],
            'id' => $r['id'],
            'amount' => str_replace('.', '', $r['importe']),
            'orderSource'=>'ecommerce',
            'card'=>array(
                'number' =>$r['numero'],
               	'expDate' => $r['vto'],
                'type' => $r['tipo']
                ),
            'billToAddress'=>array(
                'name' => $r['Nombre'],
                'addressLine1' => $r['Direccion'],
                'phone' => $r['Telefono'],
                'zip' => trim($r['zip']),
                'country' => trim($r['pais'])
                )
            );
        
        }
        
        $initilaize = new LitleOnlineRequest();
        $saleResponse = $initilaize->saleRequest($sale_info);
        
        $response = (XmlParser::getNode($saleResponse,'response'));
        $message = XmlParser::getNode($saleResponse,'message');
        $token =  XmlParser::getNode($saleResponse ,'litleToken');
        $litle_id = XmlParser::getNode($saleResponse,'litleTxnId');
        
       // var_dump($response);
        echo "response: ". $response ."\n";
		fwrite($fh, date("H:i:s") . " - RESPONSE ". $response ." \n");
        
       // var_dump($message);
        echo "message: ". $message ."\n";
        
       // var_dump($token);
        echo "token: ". $token ."\n";
        
       // var_dump($litle_id);
        echo "litle_id: ". $litle_id ."\n";            
        
        fwrite($fh, date("H:i:s") . " - ACTUALIZO PAGO ID ". $r['id'] .", MESSAGE: ". $message ." \n");
        $db->execute("UPDATE cobranzas_Litle SET litle_estado = 1, litle_fecha = GETDATE(), litle_token = ?, litle_observacion = ?, litle_id = ? WHERE id = ?", array($token, $message, $litle_id, $r['id']) );
        
        
        
    }else if($r['tipo_transac'] == 2){ // CREDIT
    	echo "Procesa CREDIT ID ". $r['id'] ."\n";
    
        $credit_info = array(
                'litleTxnId'=>$r['numero'],
                'id' => $r['id'],
                'amount'=> str_replace('.', '', $r['importe'])
        );
        $initilaize = new LitleOnlineRequest();
        $creditResponse = $initilaize->creditRequest($credit_info);

        #display results
        echo ("Response: " . (XmlParser::getNode($creditResponse,'response')) . "<br>");
        echo ("Message: " . XmlParser::getNode($creditResponse,'message') . "<br>");
        echo ("Litle Transaction ID: " . XmlParser::getNode($creditResponse,'litleTxnId'));
        
        
        
        $response = (XmlParser::getNode($creditResponse,'response'));
        $message = XmlParser::getNode($creditResponse,'message');
        $litle_id = XmlParser::getNode($creditResponse,'litleTxnId');
        
		fwrite($fh, date("H:i:s") . " - RESPONSE ". $response ." \n");
       // var_dump($response);
        echo "response: ". $response ."\n";
        
       // var_dump($message);
        echo "message: ". $message ."\n";
        
       // var_dump($litle_id);
        echo "litle_id: ". $litle_id ."\n";            
        
        fwrite($fh, date("H:i:s") . " - ACTUALIZO PAGO ID ". $r['id'] .", MESSAGE: ". $message ." \n");
    
        $db->execute("UPDATE cobranzas_Litle SET litle_estado = 1, litle_fecha = GETDATE(), litle_observacion = ?, litle_id = ? WHERE id = ?", array($message, $litle_id, $r['id']) );
    
    }else{
        echo "OPERACION NO SOPORTADA!";
    }
    

    
        
        
}
fwrite($fh, date("H:i:s") . " - UNLINK PID...  ");
unlink($pidfile);
fwrite($fh, " OK! \n");

fwrite($fh, date("H:i:s") . " - FINALIZA EL SCRIPT \n");
fclose($fh);

?>

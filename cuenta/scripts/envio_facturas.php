<?php

 
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

# Este script envia informes de trafico no facturado por e-mail a los clientes
# que lo solicitaron.  Se debe correr a partir de un crontab con la frecuencia
# que se considere necesaria.  Cada vez que se ejecuta envia un e-mail a cada 
# usuario que lo solicito.

//$debug = true;	//Esta bandera activa el modo de debug

$base_debug = "/home/httpd/zonasegura.grupoalternativa.com/cuenta/scripts";
$email_debug = "sebastian@promaker.com.ar";
//$email_debug = "rcelle@alternativa.com.ar";
//$email_debug = "ldartigue@alternativa.com.ar";
//$email_debug = "geraldine@promaker.com.ar";
//$email_debug = "agarcia@alternativa.com.ar";
//$email_debug = "fstecher@alternativa.com.ar";

date_default_timezone_set('America/Buenos_Aires');


$_owner_debug = 't2';

switch($_owner_debug){

    case 't2':

        $mercado_debug = "7";
        $empresa_debug =  "1";
        $owner_id_debug = "8";
        $carpeta_debug = "t2";
    break;
    case 'red':

        $mercado_debug = "1";
        $empresa_debug =  "1";
        $owner_id_debug = "1";
        $carpeta_debug = "red";
    break;
}


$fecha_hoy_debug = "2013-02-28 00:00:00";

//$email_recibe_log = "sebastian@promaker.com.ar";
//$email_recibe_log = "agarcia@alternativa.com.ar";
$email_recibe_log = "ldartiguelongue@alternativa.com.ar,agarcia@alternativa.com.ar";


require "includes/adodb/adodb.inc.php";   // abstracción de base de datos
require "includes/db.inc.php";   // modulo de manejo de base de datos
require "includes/config.inc.php";    // conexión a base de datos y demases y módulo de obtención y manejo de datos de configuración
require "includes/cliente.inc.php";    // módulo de obtención y manejo de datos de clientes
require "includes/mailer.inc.php";        // construcción y envío de mails
require "includes/fecha.inc.php";         // facilidades para la fecha
require "includes/validacion.inc.php";    // módulo de validación
require "includes/comun.inc.php";         // funciones comunes
require "includes/log.inc.php";           // módulo de logeo
require "includes/csvGenerator.inc.php";	  //construye los csv que se enviarán adjuntos
require "includes/currency.inc.php";
require "includes/class.phpmailer.php";


// inicializo objetos y variables -----------------------------------------------------------------

$config = new Config();

//Variables de debug
if ($config->getValue('Factura_debug') === '1'){
	$debug = true;  //Esta bandera activa el modo de debug
}else{
    $debug = false;
}


// COMENTAR !!!!!!!!!!!!!!!
//$debug = true;

$base_debug      = "/home/httpd/zonasegura.grupoalternativa.com/cuenta/scripts";

//if(!isset($email_debug)){
//	$email_debug     = $config->getValue('Email_debug');
//}


$email_debug     = $config->getValue('Email_debug');
$mercado_debug   = $config->getValue('Mercado_debug');
$empresa_debug   = $config->getValue('Empresa_debug');
$owner_id_debug  = $config->getValue('Owner_id_debug');
$carpeta_debug   = $config->getValue('Carpeta_debug');
$fecha_hoy_debug =  $config->getValue('Fecha_debug');


$HEADERS_TRAFICO = array('Fecha', 'Hora', 'Origen', 'Destino', 'Duracion (minutos)', 'Importe');

$LOGFILE = $config->getValue('Facturas_Logfile');
$PIDFILE = $config->getValue('Facturas_Pidfile');

$SMTP_SERVER = $config->getValue('SMTP_Server');
$FROM = $config->getValue('Mail_From');
$FROM_NAME = $config->getValue('Mail_From_Name');
$BOUNCE_MAILS_TO = $config->getValue('Bounce_Mails_To');

$ENVIAR_SIN_TRAFICO = 1;				    //Enviar el informe incluso si no hay trafico
$exit='';						            //valor de la salida
$advise_to = 'agarcia@grupoalternativa.com';  // A dónde avisa cuando no hay logs
$advise_from = 'agarcia@red-alternativa.com'; // Quién avisa cuando no ay logs
$s_app = "Envío de Facturas";

# query lineas de la factura
$query_lineas = "
	SELECT 
		desclinea, minutos, codlinea, (importe+iva) as subtotal 
	FROM 
		factlineas 
	WHERE numdoc = ? AND tipodoc = ? AND sucdoc = ? AND trim(cliente_id) = ?;";

# defino la query que trae el tráfico
$query_trafico = "
	SELECT 
		fecha, hora, origen, destino, duracion, importe 
	FROM 
		traficohistorico 
	WHERE 
		cliente_id = ? AND numdoc = ? AND tipodoc = ? AND sucdoc= ? 
	ORDER BY fecha, hora";


if ($debug) {
	$base = $base_debug;
} else {
	$base = $config->getValue('base_scripts');
}


$log = new Loger($debug);
$aux = $log->init($LOGFILE, $s_app, $advise_to, $advise_from);

if(!$aux) exit();

$com_obj= new Comun();

if (!$debug) {
	if (!$com_obj->createPidFile($PIDFILE)) {
		$log->mkLog("No se pudo crear (pidfile) $PIDFILE", "FATAL");
	    exit;
	}
}

//inicializo variables para el email
$img_dir = "imgs";	// tb a base de datos
$atts_dir = "atts"; // id
$datos = array(
	"remitente" => "$FROM",
    "cc" => "",
    "cco" => ""
);


$adjs = array();

$fecha= new Fecha();

if ($debug) {
	$hoy = $fecha_hoy_debug;
} else {
	$hoy=$fecha->hoy(1); #arma la fecha de límite en formato sql (el día actual a las 0 hs)
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Busco la lista de envios
$SQLQry = "SELECT o.mercado, o.empresa, o.carpeta, o.owner_id, o.nombre, p.fechaemision FROM procesos p INNER JOIN owner o ON p.owner_id = o.owner_id where fechaejec = ?;";

	
$db_obj = new Db;    
$db=$db_obj->dbConnect();
$params = array($hoy);

if($debug){
	class dummyobj{
	
	}
	$test = new dummyobj();
	$test->mercado = $mercado_debug;
	$test->empresa = $empresa_debug;
	$test->owner_id = $owner_id_debug;
	$test->fechaemision = $fecha_hoy_debug;
	$test->carpeta = $carpeta_debug;
	$test->nombre = '';
	
	$envios = array();
	array_push($envios, $test);

}else{
	$envios = $db_obj->getMultiTuplasObject($SQLQry, $params);   //obtengo los envíos que hay que hacer
}


if(!is_array($envios)) {
    $log->mkLog("Ocurrieron errores al buscar envíos de la fecha.  No se envio ningun mail","Error");    #si había errores de búsqueda logeo 
    if (!$debug) unlink($PIDFILE); 	#borro el PID
    exit($exit);					#salgo
}

$errors=0; // Contador de errores
$envios_ok = 0; // emails enviados ok
$errores_envio = 0; // emails que no fueron enviados

echo "ENVIOS: \n\n";
print_r($envios);

foreach($envios as $envio) {    
	// Busco la lista de clientes
    $c_handler = new Cliente($debug);
    $clientes = $c_handler->buscarParaEnvioFacturas($envio->mercado, $envio->empresa, $envio->fechaemision);	    

    if(is_array($clientes)) {
		#logea la cantidad de clientes(fact);
	    $log->mkLog("Procesando " . count($clientes) . " clientes para el owner " . $envio->nombre . " con fecha de emisión: " . $envio->fechaemision, "INFO");
      	if (!$debug) {
	        $SQLCmd = "UPDATE procesos SET registros=?, fechainicio=now() WHERE proceso = 'MailFactura' AND mercado = ? AND fechaemision = ?";
	        if(!$db_obj->setSingleValue($SQLCmd, array(count($clientes),$envio->mercado,$envio->fechaemision))) {
	            $log->mkLog("No se pudo actualizar el contador de registros ni la fecha de inicio en la tabla para el envio del owner ".$envio->nombre." con fecha de emisión: ".$envio->fechaemision,"WARN");
	        }
        }
		
		// Cargo la configuracion del owner
		
		$fileName = $base . "/templates/" . $envio->carpeta . "/cfg.inc.php";
		if (file_exists($fileName)) {
			include($fileName);
			$config_email = $cfg;
		} else {
			$log->mkLog("fallo en la carga de config: " . $envio->carpeta . "; problema: no se  halla " . $fileName . "\n");
			exit();
		}
		
		//var_dump($clientes);

    	foreach ($clientes as $cliente) {
	//	echo "\n\nproceso cliente ". $cliente->cliente_id;
           
            $aux = array($cliente->numdoc, $cliente->tipodoc, $cliente->sucdoc, $cliente->cliente_id);
           
            $lineas=$db_obj->getMultiTuplasObject($query_lineas, $aux);
            //echo $query_lineas;
           // print_r($aux);
           
            if(!is_array($lineas)) {

    			$log->mkLog("Error al ejecutar el query de lineas para el cliente " . $cliente->cliente_id,"Error");	#si hubo error lo logeo
                $errors++;	#e incremento el número de error
                continue;
            }

            $aux = array($cliente->cliente_id, $cliente->numdoc, $cliente->tipodoc, $cliente->sucdoc);
            $trafico = $db_obj->getMultiTuplas($query_trafico, $aux);

            if(is_array($trafico)) {
            	#creo una entrada para este cliente y agrego las lineas de la factura
                /*
                $resultado = Comun::enviaMailFactura($cliente, $lineas, $trafico, $datos, $envio, $debug, $HEADERS_TRAFICO, $config_email, $com_obj, $base, $log, $SMTP_SERVER, $BOUNCE_MAILS_TO);
                */
                if($debug){ // para que tome toda la info de debug
                    $cliente->carpeta = $carpeta_debug;
                }

                $resultado = Comun::enviaMailFactura($cliente, $lineas, $trafico, $datos, $envio, $debug, $HEADERS_TRAFICO, $config_email, $com_obj, $base, $log, $SMTP_SERVER, $config_email["bounce"]);
				 if($resultado){
					$envios_ok++;
				 }else{
					$errores_envio++;
				 }
				
            } else {
                $log->mkLog("Error al ejecutar el query de trafico para el cliente " . $cliente->cliente_id,"Error");   #si hubo error lo logeo 
                $errors++;  #e incremento el número de error
            }
        }
    }
    $log->mkLog("Proceso finalizado.  $envios_ok envios OK; $errores_envio errores de envio","INFO");	#logeo el fin del proceso

	if (!$debug) {
		$SQLCmd = "UPDATE procesos SET fechafin=now() WHERE proceso='MailFactura' AND mercado = ? AND fechaemision = ?;";
		if(!$db_obj->setSingleValue($SQLCmd, array($envio->mercado, $envio->fechaemision))) {
			$log->mkLog("No se pudo actualizar la fecha de finalizacion en la tabla para el envio con owner ".$envio->nombre." con fecha de emisión: ".$envio->fechaemision,"WARN"); 
		}
	}
}


// Envio el log por mail
$res = $log->sendLog($email_recibe_log);      
if(!$res){
	$log->mkLog("Error al enviar el informe por mail a " . $email_recibe_log,"Error"); 
}

if (!$debug) unlink($PIDFILE);	#borro el PID
if ($exit) {			
	exit($exit);	#salgo					
}
?>

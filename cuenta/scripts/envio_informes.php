<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

# Este script envia informes de trafico no facturado por e-mail a los clientes
# que lo solicitaron.  Se debe correr a partir de un crontab con la frecuencia
# que se considere necesaria.  Cada vez que se ejecuta envia un e-mail a cada 
# usuario que lo solicito.

$debug = true;	//Esta bandera activa el modo de debug

$base_debug = "/home/httpd/zonasegura.grupoalternativa.com/beta-cuenta/scripts";
$email_debug = "sebastian@promaker.com.ar";
//$email_debug = "fstecher@alternativa.com.ar";

//$email_recibe_log = "sebastian@promaker.com.ar";
$email_recibe_log = "agarcia@alternativa.com.ar";

// Fuerza el envio al skin de un determinado owner. Si es 0 se toma el owner real del cliente.
$owner_debug = "1"; 

date_default_timezone_set('America/Buenos_Aires');

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
require "includes/class.phpmailer.php";


//inicializo objetos y variables -----------------------------------------------------------------
$config= new Config();

$HEADERS_INFORME_SEMANAL = array('Clasificador', 'Tipo de servicio', 'Cuenta', 'Fecha', 'Hora', 'Origen', 'Destino', 'Descripcion del destino', 'Duracion (minutos)', 'Moneda', 'Importe');

$LOGFILE = $config->getValue('InformesMail_Logfile');
$PIDFILE = $config->getValue('InformesMail_Pidfile');

$SMTP_SERVER = $config->getValue('SMTP_Server');
$FROM = $config->getValue('Mail_From');
$FROM_NAME = $config->getValue('Mail_From_Name');
$BOUNCE_MAILS_TO = $config->getValue('Bounce_Mails_To');

$ENVIAR_SIN_TRAFICO = 1;				    //Enviar el informe incluso si no hay trafico
$exit='';						            //valor de la salida
$advise_to = $config->getValue('Advise_To_Email');   // A dónde avisa cuando no hay logs
$advise_from = $config->getValue('Advise_From_Email');  // Quién avisa cuando no ay logs
$s_app="Envío de informes de Tráfico";

if ($debug) {
	$base = $base_debug;
} else {
	$base = $config->getValue('base_scripts');
}

$log = new Loger($debug);
$aux = $log->init($LOGFILE, $s_app, $advise_to, $advise_from);
if(!$aux) exit;
    
$com_obj= new Comun();

if (!$debug) {
	if (!$com_obj->createPidFile($PIDFILE)) {
		echo "No se pudo crear pidfile";
		$log->mkLog("No se pudo crear (pidfile) $PIDFILE", "FATAL");
	    exit;
	}
}

// Obtengo los nombres de las carpetas de configuracion x owner
$SQLQry = "SELECT owner_id, carpeta FROM owner";
$db_obj = new Db;    
$db = $db_obj->dbConnect();
$listaOwner = $db_obj->getMultiTuplasObject($SQLQry);
$listaCfg = array();

foreach ($listaOwner as $owner) {
			
	$fileName = $base . "/templates/" . $owner->carpeta . "/cfg_informe.inc.php";
	if (file_exists($fileName)) {
		include($fileName);
		$cfg['carpeta'] = $owner->carpeta;
	} else {
		if (!$debug) {
			$log->mkLog("fallo en la carga de config: " . $owner->carpeta . "; problema: no se  halla " . $fileName . "\n");
		}
		exit();
	}
	$listaCfg[$owner->owner_id] = $cfg;
	
}


//inicializo variables para el email

$adjs = array();

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

# Busco todos los clientes que solicitaron el envio

$c_handler= new Cliente($debug);
$clientes = $c_handler->buscarConEnvioInformes();	#trae una lista con los clientes solicitados( array de objects )

if(is_array($clientes)) {

    $fecha= new Fecha;
    
    $fecha_limite=$fecha->hoy(1); #arma la fecha de límite en formato sql (el día actual a las 0 hs)
	$fecha_limite_mail = $fecha->ayer(1);	#fecha de ayer en formato sql 0 hs
    $fecha_limite_txt = $fecha->ayer("d/m/Y");  #formateo la fecha de envio
    
    $datos["fecha_hasta"]=$fecha_limite_txt;
	
  
	$query_trafico = "
		select clasificador, tiposervicio, linea, to_char(fecha, ".DATE_FORMAT."), 
		hora, origen, destino, destinotxt, duracion, moneda, importe 
		from trafico where cliente_id = ?;";

    $db_obj = new Db();
    $db=$db_obj->dbConnect();
    $sth_trafico = $db->prepare($query_trafico);

	if (!$debug) {
		$log->mkLog("Procesando " . count($clientes) . " clientes hasta $fecha_limite","INFO");	#logea la cantidad de clientes
	}
	
	# Recorrer cada cliente del array
	
	$informes = array();					# inicializa un array con los informes
	$errors=0;						        # inicializa un contador de errores
	$envios_ok=0;
	$errores_envio =0;

	foreach ($clientes as $cliente) 		# por cada cliente
    {
        # Buscar el trafico no facturado
        
		$aux=array($cliente->cliente_id);

        $result=$db->execute($sth_trafico,$aux); 	#trae el tráfico no facturado 

        if($result)
        {
            $data=array();
			$hayFilas = 0;						#y un flag para ver si hay datos
			while($row = $result->FetchRow())
            {	                                #por cada fila de datos para ese cliente
				$hayFilas = 1;				    #cambia el estado del sin datos
				array_push($data,$row) ;				#agrega la fila en el buffer
			}
            if(count($data)||$ENVIAR_SIN_TRAFICO)
            {
            	$resultado = Comun::enviaMailInforme($cliente, $listaCfg, $debug, $email_debug, $owner_debug, $HEADERS_INFORME_SEMANAL,$data, $base, $SMTP_SERVER, $log, $datos["fecha_hasta"]);
			    if($resultado){
					$envios_ok++;
				}else{
					$errores_envio++;
				}
            }
		} 
        else 
        {
			$log->mkLog("Error al ejecutar el query de trafico para el cliente " . $cliente->cliente_id,"Error");	#si hubo error lo logeo
			$errores_envio++;	#e incremento el número de error
		}
        
	}

	$log->mkLog("Proceso finalizado.  $envios_ok envios OK; $errores_envio errores de envio","INFO");	#logeo el fin del proceso
	
} else {
	
	$log->mkLog("Error al buscar los clientes para procesar","Error");		#si no pude traer los datos de los clientes
	$exit=1;								#confirmo la salida
	
}

$log->sendLog($email_recibe_log);

if (!$debug) unlink($PIDFILE);	#borro el PID
if ($exit) {			
	exit($exit); #salgo					
}
?>

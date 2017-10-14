<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

# Este script envia alertas de trafico por e-mail a los clientes
# que lo solicitaron.  Estos definen un limite en minutos o en importe, pasado
# el cual se debe enviar la alerta.
# El script se debe correr a partir de un crontab una vez por dia.


$debug = true;	//Esta bandera activa el modo de debug

$base_debug = "/home/httpd/zonasegura.grupoalternativa.com/beta-cuenta/scripts"; // Cuando debug = false el path se toma de la base de datos
$email_debug = "sebastian@promaker.com.ar";
//$email_debug = "fstecher@alternativa.com.ar";
$alertas_enviadas_debug = 1; // 0 o 1, para probar ambos template de mails

//$params_debug permite forzar la selecion de un ownner (mercado, empresa)
//$params_debug = array(-1, -1);	//permite que se elija el que fija el dato del cliente
//$params_debug = array(6, 2);		
$params_debug = array(7, 3);		//T2

$email_recibe_log = "agarcia@alternativa.com.ar";
//$email_recibe_log = "sebastian@promaker.com.ar";
//$email_recibe_log = "asistencia@alternativa.com.ar, ldartiguelongue@alternativa.com.ar";

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
require "includes/csvGenerator.inc.php";      //construye los csv que se enviarán adjuntos
require "includes/class.phpmailer.php";

// inicializo objetos y variables


$config= new Config();

$HEADERS_ALERTA_CONSUMO = array('Clasificador', 'Tipo de servicio', 'Cuenta', 'Fecha', 'Hora', 'Origen', 'Destino', 'Descripcion de
l destino', 'Duracion (minutos)', 'Moneda', 'Importe');

$LOGFILE = $config->getValue('AlertasMail_Logfile');
$PIDFILE = $config->getValue('AlertasMail_Pidfile');

/*depreciadas
$TEMPLATE1 = $config->getValue('AlertasMail_Template');
$TEMPLATE2 = $config->getValue('AlertasMail2_Template');
$TEMPLATE_TXT1 = $config->getValue('AlertasMail_Template_txt');
$TEMPLATE_TXT2 = $config->getValue('AlertasMail2_Template_txt');
*/

$SMTP_SERVER = $config->getValue('SMTP_Server');
$BOUNCE_MAILS_TO = $config->getValue('Bounce_Mails_To');

$COUNTER_KEY = 'Alertas_Counter';
$MAX_ALERTAS_MES = 2;        						# Cantidad maxima de alertas a enviar por mes

# Obtener la cotizacion del dolar
$COTIZACION_USD = $config->getValue('Cotizacion_USD');
$updates=array();


$exit='';                                   //valor de la salida
$advise_to='agarcia@alternativa.com.ar';   // A dónde avisa cuando no hay logs
$advise_from='agarcia@alternativa.com.ar';  // Quién avisa cuando no ay logs
$s_app="Envío de alertas de Tráfico";

if ($debug) {
	$base = $base_debug;
} else {
	$base = $config->getValue('base_scripts');
}

$log= new Loger($debug);
$com_obj= new Comun;

$aux = $log->init($LOGFILE,$s_app,$advise_to,$advise_from);
if(!$aux) exit();

if (!$debug) {
	if (!$com_obj->createPidFile($PIDFILE)) {
		$log->mkLog("No se pudo crear (pidfile) $PIDFILE", "FATAL");
	    exit;
	}
}

// inicializo variables para el email
$img_dir = "imgs";                      // tb a base de datos
$atts_dir = "atts";                     // id
$datos = array(
	"cc" => "",
	"cco" => ""
);

/*
$imgs_red=array ("top.gif","pie.gif","arrow_ball.gif");
$imgs_hola=array ("top1.gif","pie.gif","bullet.gif");
$subject_ra_2="Mi Panel - SEGUNDO AVISO - Alerta de consumo";
$subject_ra="Mi Panel -  Alerta de consumo";
$subject_ha_2="Mi Panel - SEGUNDO AVISO- Alerta de Consumo";
$subject_ha="Mi Panel - Alerta de Consumo";
$adjs = array();
*/

# Buscar todos los clientes que solicitaron el envio

$c_handler = new Cliente($debug);
$clientes = $c_handler->buscarConEnvioAlertas();

if(is_array($clientes)) {
    
    $fecha= new Fecha;
    
    $fecha_limite = $fecha->hoy(1); #arma la fecha de límite en formato sql (el día actual a las 0 hs)
    $fecha_limite_mail = $fecha->ayer(1);   #fecha de ayer en formato sql 0 hs
    $fecha_limite_txt = $fecha->ayer("d/m/Y");  #formateo la fecha de envio
    
    $datos["fecha_hasta"]=$fecha_limite_txt;
    
	$query_minutos = 'select sum(duracion) from trafico where cliente_id = ? and fecha <= ? and fecha >= current_date - cast (EXTRACT(DAY FROM current_date)-1 as integer)';
    $query_importe = 'select sum(importe) from trafico where cliente_id = ? and fecha <= ? and fecha >= current_date - cast (EXTRACT(DAY FROM current_date)-1 as integer)';
    
    $log->mkLog("Procesando " . count($clientes) . " clientes hasta $fecha_limite","INFO"); #logea la cantidad de clientes
                
	# Recorrer cada cliente del array
    $alertas = array();                    # inicializa un array con los informes
    $errors=0;                             # inicializa un contador de errores

    foreach ($clientes as $cliente) 
    {
	# Verificar que no se le haya enviado ya el limite de alertas mensuales
	
	if($debug){
		$alertas_enviadas = $alertas_enviadas_debug;
	}else{
		$alertas_enviadas = $config->getValue($COUNTER_KEY,$cliente->cliente_id);
	}
	
	if (!is_array($alertas_enviadas) and ($alertas_enviadas >= $MAX_ALERTAS_MES)) 
	{
		//YA SE LE ENVIARON TODAS LAS ALERTAS PARA EL MES
		continue;
	} 
	else if (is_array($alertas_enviadas)) 
	{
		//hubo un error al buscar alertas para este cliente
		$log->mkLog("No se pudo obtener la cuenta de alarmas enviadas para el cliente ".$cliente->cliente_id,"ERROR");
	}
	else if(!$alertas_enviadas)
	{
		# Por si no tiene seteado el valor en la tabla
		$alertas_enviadas = 0;
	}
	
	# Ver que tipo de limite tiene
	$limite_minutos = $config->getValue('AlertaConsumos_LimiteMinutos',$cliente->cliente_id);
	$limite_importe = $config->getValue('AlertaConsumos_LimiteImporte',$cliente->cliente_id);
	$moneda = $config->getValue('AlertaConsumos_ImporteMoneda',$cliente->cliente_id);
	$alerta_minutos='';
	$alerta_importe='';
	$db_obj=new Db;
	
	if (!is_array($limite_minutos) and ($limite_minutos > 0)) 
	{
		# Correr la consulta de minutos
		$vals=array($cliente->cliente_id, $fecha_limite);
		$minutos=$db_obj->getSingleValue($query_minutos,$vals);
		if(!is_array($minutos))
		{
			if($minutos)
			{
				if($minutos>=$limite_minutos)
				{
					$alerta_minutos=$minutos;
				}
			}
			else
			{
				$log->mkLog("Query de count minutos no devolvio filas para el cliente ".$cliente->cliente_id,"INFO");
				//originalmente comentada, la dejo
				//$errors++;
			}
		} 
		else 
		{
			$log->mkLog("Error al ejecutar query de count minutos: " . $sth_minutos->errstr,"WARNING");
			$errors++;
		}
	}
	if (!is_array($limite_importe) and ($limite_importe > 0)) 
	{
		# Correr la consulta de importe
		$vals=array($cliente->cliente_id, $fecha_limite);
		$importe=$db_obj->getSingleValue($query_importe,$vals);
		if (!is_array($importe)) 
		{
			if ($importe) 
			{
				if ($moneda and ($moneda == DOLARES)) 
				{	
					# El valor ingresado como limite esta en dolares.
					# Dividir el importe por la cotizacion del dolar
					$importe = sprintf("%.2f", $importe / $COTIZACION_USD);
				} 
				else if (!$moneda) 
				{
					$moneda = PESOS;
				}
				if ($importe >= $limite_importe) {
					$alerta_importe = $importe;
				}
			} 
			else 
			{
				$log->mkLog("Query de count importe no devolvio filas para el cliente ".$cliente->cliente_id,"INFO");
				//$errors++;
			}
		} 
		else 
		{
			$log->mkLog("Error al ejecutar query de count importe: " . $sth_importe->errstr,"WARNING");
			$errors++;
		}
	}
	if ($alerta_minutos or $alerta_importe) 
	{
		$aux=array($cliente, $alerta_minutos, $alerta_importe, $moneda, $alertas_enviadas);
		array_push($alertas,$aux);
	}

}
	
    if (!$errors) {
		
		//Inicializo el array de configuraciones
	    $SQLQry = "
	    	SELECT carpeta 
	    	FROM owner;";
		$db_obj = new Db;    
		$db = $db_obj->dbConnect();
		$params = array();
		$listaOwner = $db_obj->getMultiTuplasObject($SQLQry, $params);
		
		$listaCfg = array();
		/*
			se busca la configuracion para cada owner en el path:
		
			"templates/[carpeta]/cfg_alert.inc.php";
		
			formato del array de config (notar qu este distibguira los elementos
			basado en la cantidad de alertas 0 ó 1 inicialmente:
			
			$cfg = array(
				"0" => array(
					"imgs" => array("top.jpg", "pie.gif"), 
					"subject" => "Alternativa - Factura y detalle de consumo",
					"from" => "asistencia@alternativa.com.ar"
				),
				"1" => array(
					"imgs" => array("top.jpg", "pie.gif"), 
					"subject" => "Alternativa - Factura y detalle de consumo",
					"from" => "asistencia@alternativa.com.ar"
				)
			);
		*/
		foreach ($listaOwner as $owner) {
			
			$fileName = $base . "/templates/" . $owner->carpeta . "/cfg_alert.inc.php";
			if (file_exists($fileName)) {
				//if ($debug) echo "exito en la carga de config: " . $owner->carpeta . "<br />";
				include($fileName);
			} else {
				$log->mkLog("fallo en la carga de config: " . $owner->carpeta 
					. "; problema: no se  halla " . $fileName . "\n");
				exit();
			}
			$listaCfg[$owner->carpeta] = $cfg;
			
		}
		
		# Realizar el envio de los mails
		$envios_ok=0;
        $errores_envio=0;
        $val= new Validator;
        
        
        echo "ALERTAS";
        
        print_r($alertas);
        
        foreach ($alertas as $alerta) 
        {
			list ($cliente, $alerta_minutos, $alerta_importe, $moneda, $alertas_enviadas) = $alerta;
			if ($cliente->email and $val->email($cliente->email,150,4)) { 
                
                /*
	            originalmente:
	            $mercado = ($cliente->mercado==1)? 'red' : 'hola';
	            
	            ahora:
	            el template del mail esta def. por el owner.
	            una combinacion de mercado, empresa deberia identificar de forma univoca dicho owner
	            (nota: al momento de reescribir esta seccion del codigo se encontro una anomalia
	                   una misma combinacion de mercado, empresa corresponde a 2 owner por tanto
	                   procedo a añadir la hipoteis adicional: tomo el 1er elemento)
	            */
	            $SQLQry = "
	            	SELECT 
	            		owner_id, carpeta 
	            	FROM 
	            		owner  
	            	WHERE 
	            		mercado = ? 
	            		AND empresa = ? 
	            	LIMIT 1;";
				$db_obj = new Db;    
				$db = $db_obj->dbConnect();
				
				if ($debug) {
					if ($params_debug[0] == -1) {
						$params = array($cliente->mercado, $cliente->empresa);
					} else {
						$params = $params_debug;
					}
				} else {
					$params = array($cliente->mercado, $cliente->empresa);
				}
			
				$listaDatoOwner = $db_obj->getMultiTuplasObject($SQLQry, $params);
	            
	            //echo "*************************<hr /><pre>" . var_export($params, true). "</pre>";
	            
	            //(!)pensar un poco mas esto, se envian algunos si y otros no? despues retoma donde quedo?
	            if(!is_array($listaDatoOwner)) {
				    $log->mkLog("Ocurrio un error al ejecutar la consulta: " . $SQLQry, "Error");
				    if (!$debug) unlink($PIDFILE);
				    exit($exit);
				}
	            
	         
	            $datoOwner = $listaDatoOwner[0];
	            
	            
	             $adjs=array();
	            
	            if(!$alertas_enviadas) {
	            	$itmCfg = $listaCfg[$datoOwner->carpeta]["0"];
	            } else {
	            	$itmCfg = $listaCfg[$datoOwner->carpeta]["1"];
	            }
	            
                $moneda_txt='';
                switch($moneda)
                {
                    case 'ARS':
                        $moneda_txt='$';
                    break;
                    case 'USD':
                        $moneda_txt='USD';
                    break;
                }
				
                # determino el mensaje de alerta

                $alerta_txt="";
                if($alerta_minutos && $alerta_importe)
                {
                    $alerta_txt=str_replace('<%minutos%>',$alerta_minutos,$itmCfg['txt_alerta_ambos']);
                    $alerta_txt=str_replace('<%importe%>',$alerta_importe,$alerta_txt);
                    $alerta_txt=str_replace('<%simbolo%>',$moneda_txt,$alerta_txt);
                }
                else if($alerta_minutos)
                {
                    $alerta_txt=str_replace('<%minutos%>',$alerta_minutos,$itmCfg['txt_alerta_minutos']);
                }
                else if($alerta_importe)
                {
                    $alerta_txt=str_replace('<%importe%>',$alerta_importe,$itmCfg['txt_alerta_importe']);
                    $alerta_txt=str_replace('<%simbolo%>',$moneda_txt,$alerta_txt);
                }
                else
                {
                    $log->mkLog("Contradicción en la determinación de alertas cliente:".$cliente->cliente_id,"WARN");
                }
                $mail_obj=new Mailer($debug);
                $str_att=array();
                $cust_dat=$datos;
                
                //$cust_dat["remitente"]=($cliente->mercado==1) ? 'asistencia@alternativa.com.ar' : 'asistencia@holaargentina.com';
               
                if ($debug) {
	            	$cust_dat["destinatario"] = $email_debug;
	            	echo "se fuerza destinatario de " . $cliente->email . " a " . $email_debug . "\n";
	            } else {
	            	$cust_dat["destinatario"] = $cliente->email;
	            }
                
                $cust_dat["cliente_id"]=$cliente->cliente_id;
                $cust_dat["rsocial"]=$cliente->rsocial;
                $cust_dat["alerta"]=$alerta_txt;
                
              
	            
				$cust_dat["remitente"] = $itmCfg["from"];
				$cust_dat["bounce"] = $itmCfg["bounce"];
                $cust_dat["nombre_remitente"] = $itmCfg["from_name"];
                
            	$imgs = $itmCfg["imgs"];
            	$subject = $itmCfg["subject"];
            	
                if(!$alertas_enviadas) {
                	$temp_html = "templates/" . $datoOwner->carpeta . "/alertas_mail1.tpl";
	            	$temp_plano = "templates/" . $datoOwner->carpeta . "/alertas_mail1.txt";
	            } else {
	            	$temp_html = "templates/" . $datoOwner->carpeta . "/alertas_mail2.tpl";
	            	$temp_plano = "templates/" . $datoOwner->carpeta . "/alertas_mail2.txt";
	            }
	            
	            $img_sdir = "templates/" . $datoOwner->carpeta . "/imgs";
	            /*
	            $mail_obj->init($cust_dat, $temp_html, $imgs, $adjs, 
	            	$temp_plano, $base, $img_sdir, $att_dir, $str_att, 
	            	$subject, "", $SMTP_SERVER, $BOUNCE_MAILS_TO);
	            */
	            
	            $mail_obj->init($cust_dat, $temp_html, $imgs, $adjs, 
	            	$temp_plano, $base, $img_sdir, $att_dir, $str_att, 
	            	$subject, "", $SMTP_SERVER, $cust_dat["bounce"]);
	            	
	            $mail_obj->prepare();
	            
                if($mail_obj->send())
                {
                    if (!$debug) {
                    	//nota: por si es neceario
                    	//cmd SQL para neutralizar el efecto del incremento sobre la clave Alertas_Counter
                    	//(ej sobre el client_id = 'C103443) producto de ejecutar la ln de set value
                    	//UPDATE cliente_config SET "valor" = 0 WHERE "cliente_id" LIKE 'C103443' AND "clave" = 'Alertas_Counter';
	                    if(!$config->setValue($COUNTER_KEY, ($alertas_enviadas+1), $cliente->cliente_id)) {
	                        $log->mkLog("No se pudo incrementar el contador de envíos para el cliente " . $cliente->cliente_id,"ERROR");
	                    }
	                }
                    $envios_ok++;       #si en envio está ok incrementa el contador de ok
                }
                else
                {
                    $errores_envio++;   #si no incrementa el contador de errores
                    $log->mkLog("Error al enviar el mail a " . $cliente->cliente_id,"Error");
                }
			} 
            else
            {
				$log->mkLog("Direccion de e-mail no definida o invalida para el cliente " . $cliente->cliente_id,"ERROR");
				$errores_envio++;
			}
		}
		$log->mkLog("Proceso finalizado.  $envios_ok envios OK; $errores_envio errores de envio", "INFO");
	} 
    else 
    {
		$log->mkLog("Ocurrieron errores.  No se envio ningun mail","ERROR");
		$exit=1;
	}

} 
else 
{
	$log->mkLog("Error al buscar los clientes para procesar","ERROR");
	$exit=1;
}

$log->sendLog($email_recibe_log);

if (!$debug) unlink($PIDFILE);
if ($exit) {
	exit($exit);
}
?>

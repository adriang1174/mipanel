<?php 
 
define('PG3_DB_SERVER', 'localhost');
define('PG3_DB_NAME', 'ra_cuenta');
define('PG3_DB_USERNAME', 'site_cuenta');
define('PG3_DB_PASSWORD', 'cuenta*111');
define('WEBSERVICE_USERNAME', 'test');
define('WEBSERVICE_PASSWORD', 'test123');

$strConnection_cuenta = "host=" . PG3_DB_SERVER ." dbname=" . PG3_DB_NAME . " user=" . PG3_DB_USERNAME . " password=" . PG3_DB_PASSWORD . "";
	
$idCn_cuenta = @pg_connect($strConnection_cuenta);
if (!$idCn_cuenta) {
	echo "NO PUEDO CONECTAR CON LA DB POSTGRE";
	exit;
}

require("includes/class.phpmailer.php");
require("includes/nusoap/nusoap.php");

function _enviarMail($nombre, $apellido, $email, $did){
	$mail = new PHPMailer();		
	$mail->From     = "asistencia@segundalinea.com";
	$mail->FromName = utf8_decode("Segunda Línea");			
	$email_template = implode("", file("/home/httpd/zonasegura.grupoalternativa.com/html/alternativa/tpl/mails/registro_did.tpl"));			
	$search = array("{NOMBRE_APELLIDO}", "{NUMERO_DID}");	
	
	
	//$soapclient = new soapclient2('https://zonasegura.grupoalternativa.com/services/index.php');
	$soapclient = new soapclient2('https://webseg.alternativa.com.ar/services/index.php');
	if (!$soapclient->getError()) {
		// obtengo un token
		$token = $soapclient->call('core_auth', 
			array(
				'username'=>WEBSERVICE_USERNAME,
				'password'=>WEBSERVICE_PASSWORD
			));
	}

	if (!$soapclient->fault && !$soapclient->getError()) {
		// obtengo un array con el listado de provincias
		$result = $soapclient->call('servicios_getAniInfo', array('token'=>$token,
				                                                'ani' => trim($did),
				                                                'mostrar_codigo_pais' => true
				                                                ));
		if($result['numero_formateado'] != ''){
			$numero_formateado = $result['numero_formateado'];
		}else{
			$numero_formateado = trim($did);
		}

	}else{
		$numero_formateado = trim($did);
	}
	
			
	$replace = array($nombre . ' ' . $apellido, $numero_formateado);
	$email_template = str_replace($search, $replace, $email_template);		
	$mail->Subject = utf8_decode("¡Ya tenés tu número de Segunda Línea!");
	$mail->Body    = $email_template;
	$mail->AltBody = strip_tags($email_template);		
	$mail->AddAddress($email, $nombre . " ". $apellido);
	//$mail->AddAddress("sebastianhgil@gmail.com", $nombre . " ". $apellido);
	
	
	return ($mail->Send());
}

$q = "SELECT u.nombre, u.apellido, u.email, s.numerocompleto, s.callerid, s.name 
		FROM str_2linea s 
		INNER JOIN usuarios u ON s.name = u.numero_sip
		WHERE bienvenida = 0 ";	
$rst = pg_query($idCn_cuenta, $q);
while($row = pg_fetch_assoc($rst)){
print_r($row);
	$res = _enviarMail($row["nombre"], $row["apellido"], $row["email"], $row["numerocompleto"]);
	if($res){
		$q_update = "UPDATE str_2linea SET bienvenida = 1 WHERE numerocompleto = '". $row['numerocompleto'] ."'";
		//echo $q_update; // <----------------------------------------------------------------- DEBUG !!!!!!!!!!!!!!!!!!!!!!!!!!!
		pg_query($idCn_cuenta, $q_update);
	}
	
}




?>

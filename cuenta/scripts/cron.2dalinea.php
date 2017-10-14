<?php

define('PG3_DB_SERVER', 'localhost');
define('PG3_DB_NAME', 'ra_cuenta');
define('PG3_DB_USERNAME', 'site_cuenta');
define('PG3_DB_PASSWORD', 'cuenta*111');


define('MSSQL2_DB_SERVER', 'TRANSAC');
define('MSSQL2_DB_NAME', 'RASA');
define('MSSQL2_DB_USERNAME', 'sa');
define('MSSQL2_DB_PASSWORD', 'transac*321');

$strConnection_cuenta = "host=" . PG3_DB_SERVER ." dbname=" . PG3_DB_NAME . " user=" . PG3_DB_USERNAME . " password=" . PG3_DB_PASSWORD . "";
	
$idCn_cuenta = @pg_connect($strConnection_cuenta);
if (!$idCn_cuenta) {
	echo "NO PUEDO CONECTAR CON LA DB POSTGRE";
	exit;
}

$idCn2 = @mssql_connect(MSSQL2_DB_SERVER, MSSQL2_DB_USERNAME, MSSQL2_DB_PASSWORD);
if (!$idCn2) {
	echo "NO ME PUEDO CONECTAR A LA DB MSSQL";
	exit;
}
if (!@mssql_select_db(MSSQL2_DB_NAME, $idCn2)) {
	echo "NO PUEDO SELECCIONAR LA DB";
}

require("includes/class.phpmailer.php");

function _generarStr($len = 40){
	$str = '';
	while(strlen($str) < $len){
		if(rand(0,1) == 1){ // mayusculas
			$rand = rand(65, 90);
		}else if(rand(0,1) == 1){  // minusculas
			$rand = rand(97, 122);
		}else{ // numeros
			$rand = rand(48, 57);
		}
		$str .= chr($rand);	
	}
	return $str;
}

function _generarCodigo(){
	global $idCn_cuenta;
	$es_valido = false;
	while(!$es_valido){
		$codigo = _generarStr();
		$check = "SELECT * FROM usuarios WHERE \"codigo_activacion\" = '". $codigo ."'";
		$rst = pg_query($idCn_cuenta, $check);
		if(pg_num_rows($rst) == 0){
			$es_valido = true;
		}
	}
	return $codigo;
}

function _enviarMail($codigo, $nombre, $apellido, $email, $sip, $password_sip, $domain_sip){
	$mail = new PHPMailer();		
	$mail->From     = "asistencia@segundalinea.com";
	$mail->FromName = "Segunda Línea";			
	$email_template = implode("", file("/home/httpd/zonasegura.grupoalternativa.com/html/alternativa/tpl/mails/bienvenido.tpl"));			
	$search = array("{PATH_SITE}", "{NOMBRE_APELLIDO}", "{NUMERO_SIP}", "{CODIGO_ACTIVACION}", "{PASSWORD_SIP}", "{DOMAIN_SIP}");			
	$replace = array("https://zonasegura.grupoalternativa.com/alternativa/", $nombre . " ". $apellido, $sip, $codigo, $password_sip, $domain_sip);
	$email_template = str_replace($search, $replace, $email_template);		
	$mail->Subject = "¡Ya te registraste a Netfono!";
	$mail->Body    = $email_template;
	$mail->AltBody = strip_tags($email_template);		
	$mail->AddAddress($email, $nombre . " ". $apellido);

	return ($mail->Send());
}

$q = "SELECT * FROM usuarios WHERE fecha_envio_mail IS NULL AND origen = 'SegundaLinea'";	
$rst = pg_query($idCn_cuenta, $q);
while($row = pg_fetch_assoc($rst)){
print_r($row);
	$q_check = "exec C_SIP_ACTIVO '". $row["numero_sip"] ."'";
	$rst_check = mssql_query($q_check, $idCn2);
	$row_check = mssql_fetch_array($rst_check);
var_dump($row_check);
	if($row_check[0] == 1){
		$codigo = _generarCodigo();
		$res = _enviarMail($codigo, $row["nombre"], $row["apellido"], $row["email"], $row["numero_sip"], $row["password_sip"], $row["domain_sip"]);
		var_dump($res);
		if($res){

			$q_update = "UPDATE usuarios SET sip_activo = true, codigo_activacion = '". $codigo ."', fecha_envio_mail = NOW() WHERE id_usuario = ". $row["id_usuario"];
			pg_query($idCn_cuenta, $q_update);
		}
	}
	
}



?>

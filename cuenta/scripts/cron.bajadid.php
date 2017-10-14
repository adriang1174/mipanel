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

function _enviarMail($nombre, $email, $did){
	$mail = new PHPMailer();		
	$mail->From     = "asistencia@segundalinea.com";
	$mail->FromName = utf8_decode("Segunda Línea");			
	$email_template = implode("", file("/home/httpd/zonasegura.grupoalternativa.com/html/alternativa/tpl/mails/baja_did.tpl"));			
	$search = array("{NOMBRE_APELLIDO}", "{DID}");	
			
	$replace = array($nombre, $did);
	$email_template = str_replace($search, $replace, $email_template);		
	$mail->Subject = utf8_decode("Solicitud de baja de tu Segunda Línea");
	$mail->Body    = $email_template;
	$mail->AltBody = strip_tags($email_template);		
	$mail->AddAddress($email, $nombre);
	//$mail->AddAddress("sebastianhgil@gmail.com", $nombre); // <------------- TEST !!!!
	
	
	return ($mail->Send());
}

$q = "SELECT *
		FROM bajas_did
		WHERE baja = 0 ";	
$rst = pg_query($idCn_cuenta, $q);
while($row = pg_fetch_assoc($rst)){
print_r($row);
	$q_check = "exec B_DID_2LINEA '". $row["did"] ."'";
	$rst_check = mssql_query($q_check, $idCn2);
	echo $q_check;
	var_dump($rst_check);
	$row_check = mssql_fetch_array($rst_check);
print_r($row_check);
	if($row_check[0] > 0){
		$res = _enviarMail($row["nombre_apellido"], $row["email"], $row["did"]);
		if($res){
			$q_update = "UPDATE bajas_did SET baja = 1 WHERE did = '". $row['did'] ."'";
			//echo $q_update; // <----------------------------------------------------------------- DEBUG !!!!!!!!!!!!!!!!!!!!!!!!!!!
			pg_query($idCn_cuenta, $q_update);
		}
	}else{
		echo "Fallo la SP";
	}
}




?>

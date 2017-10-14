<?php
if (!defined('LLAVE_ENCRIPTACION_PAGOS_ONLINE')) 
	define('LLAVE_ENCRIPTACION_PAGOS_ONLINE', '1111111111111111');
if (!defined('ID_USUARIO_PAGOS_ONLINE')) define('ID_USUARIO_PAGOS_ONLINE', '2');

class pagos_online {
	
	function pagos_online(){

	}
	
	function dbConn(){
		
		//$conn = pg_connect("host=localhost port=5432 dbname=ra_customer_warehouse user=promaker password=promaker");
		$conn = pg_connect("host=db-mipanel.alternativa.com.ar port=5432 dbname=ra_cuenta user=site_cuenta  password=cuenta*111");
		//var_dump($conn);
		return $conn;
		
	}
	
	function procesaRespuesta() {

		$auxVerif = LLAVE_ENCRIPTACION_PAGOS_ONLINE . "~" . ID_USUARIO_PAGOS_ONLINE . 
			"~".pg_escape_string($_POST['ref_venta'])."~". pg_escape_string($_POST['valor']) . 
			"~".pg_escape_string($_POST['moneda'])."~" . pg_escape_string($_POST['estado_pol']);
		//$auxVerif = md5($auxVerif);
		//if ($auxVerif != $_POST['firma']) die ();	//"intento de acceso ilegal");
		$query = "INSERT INTO pagos_online (
			usuario_id,
			estado_pol,
			riesgo,
			codigo_respuesta_pol,
			ref_venta,
			ref_pol,
			extra1,
			extra2,
			firma,
			medio_pago,
			tipo_medio_pago,
			valor,
			iva,
			moneda,
			fecha_transaccion,
			codigo_autorizacion,
			prueba,
			cus			
			) VALUES (
			'" . pg_escape_string($_POST['usuario_id']) . "' ,
			'" . pg_escape_string($_POST['estado_pol']) . "' ,
			'" . pg_escape_string($_POST['riesgo']) . "' ,
			'" . pg_escape_string($_POST['codigo_respuesta_pol']) . "' ,
			'" . pg_escape_string($_POST['ref_venta']) . "' ,
			'" . pg_escape_string($_POST['ref_pol']) . "' ,
			'" . pg_escape_string($_POST['extra1']) . "' ,
			'" . pg_escape_string($_POST['extra2']) . "' ,
			'" . pg_escape_string($_POST['firma']) . "' ,
			'" . pg_escape_string($_POST['medio_pago']) . "' ,
			'" . pg_escape_string($_POST['tipo_medio_pago']) . "' ,
			'" . pg_escape_string($_POST['valor']) . "' ,
			'" . pg_escape_string($_POST['iva']) . "' ,
			'" . pg_escape_string($_POST['moneda']) . "' ,
			'" . pg_escape_string($_POST['fecha_transaccion']) . "' ,
			'" . pg_escape_string($_POST['codigo_autorizacion']) . "' ,
			'" . pg_escape_string($_POST['prueba']) . "' ,
			'" . pg_escape_string($_POST['cus']) . "'
			);";

		//pagos_online::saveDebug($query);
		//echo "<hr />consulta: " . $query . "<hr />";
		
		
		if(pg_query(pagos_online::dbConn(), $query)) {
			//echo "ejecucion exitosa de " . $query . ";";
			return true;
		} else {
			//echo "ejecucion fallida de " . $query . "<hr />" . pg_last_error() . "<hr />" . pg_result_error();
			return false;
		}

	}
	
	function verificaRespuesta($ref_venta) {
		
		//(!)completar
		$msgError = "";
		$idResultado = 0;
		
		//tabla de idResultado
		//	0 = aun no se encontro el registro
		//	1 a 14 <=> tabla codigo respuesta pol
		//	-1 = error en la ejecucion de la consulta
		
		$query = "SELECT * FROM pagos_online WHERE ref_venta = '" . $ref_venta . "';";
		$resultset = @pg_query(pagos_online::dbConn(), $query);
		if(!$resultset) {
			$idResultado = -1;
		} else {
			if (pg_num_rows($resultset) == 1) {
				$row = pg_fetch_assoc($resultset);
				$idResultado = $row['codigo_respuesta_pol'];
			}
		}
		return $idResultado;
		
	}
	
}
?>

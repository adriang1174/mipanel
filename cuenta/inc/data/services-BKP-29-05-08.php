<?
require_once(INCLUDE_PATH . "db.php");

class services
{

	function getLinesByUser($userId){
		db::init();
		$query = "SELECT s.id_servicio, s.servicio, login FROM cuentas c INNER JOIN servicios_conf s ON c.id_servicio = s.id_servicio WHERE cliente_id = '$userId' AND s.configura = 1 ORDER BY s.servicio";
		//$query = "SELECT s.id_servicio, s.servicio, login FROM cuentas c INNER JOIN servicios_conf s ON c.id_servicio = s.id_servicio WHERE cliente_id = '$userId' AND s.id_servicio IN ('OFG', 'OFG2', 'HAFull', 'NetFono') ORDER BY s.servicio";
		return db::get_rows_as_array($query);
	}
	
	function getActionsByLine($line){
		db::init();
		$query = "SELECT accion, descripcion, template, sa.id
					FROM cuentas c
					INNER JOIN servicios_conf sc ON c.id_servicio = sc.id_servicio
					INNER JOIN servicios_acciones sa ON c.id_servicio = sa.id_servicio
					WHERE login = '". $line ."' ORDER BY orden";
		return db::get_rows_as_array($query);
	}
	
	function getActionInfo($action){
		db::init();
		$query = "SELECT accion, descripcion, template
					FROM servicios_acciones
					WHERE id = '". $action ."'";
		return db::get_rows_as_hash($query);
	}
	
	function getServiceInfo($line){
		db::init();
		$query = "SELECT sc.servicio, sc.id_servicio FROM cuentas c 
					INNER JOIN servicios_conf sc ON c.id_servicio = sc.id_servicio
					WHERE login = '". $line ."'";
		return db::get_rows_as_hash($query);
	}
	
	function getServiceSp($type, $serviceId){
		db::init();
		$query = "SELECT id_sp, variable FROM servicios_sp
					WHERE tipo = '". $type ."'
					AND id_servicio = '". $serviceId ."'";
		return db::get_rows_as_array($query);
	}

	function getActionSp($type, $actionId){
		db::init();
		$query = "SELECT id_sp, variable, accion, txt_comunic_usuario FROM acciones_sp
					WHERE tipo = '". $type ."'
					AND id_accion = '". $actionId ."'";
		return db::get_rows_as_array($query);
	}	
	
	function execSP($id_sp, $variables, $return_data = true, $log = false, $user_id = NULL, $customer = NULL, $accion = NULL, $texto_accion = NULL){
		db::init();
		// Agarro los datos de la sp
		$query = "SELECT nombre, servidor, db, login, password, tipo_servidor FROM procedimientos
					WHERE id_sp = ". $id_sp ;
		$info_sp = db::get_rows_as_hash($query);
		
		$query_parameters = "SELECT tipo_dato, dato, prefix, postfix FROM procedimientos_parametros WHERE id_sp = ". $id_sp ." ORDER BY nro_orden";
		$parameters_sp = db::get_rows_as_array($query_parameters);

		if($info_sp["tipo_servidor"] == "mssql"){
			$query_sp = "EXEC ". $info_sp["nombre"] . " ";
			foreach($parameters_sp as $param){
				if ($param[0] == "F"){
					$query_sp .= "'". db::mssql_escape_string($param[1]) . "', ";
				}else{
					$query_sp .= "'". db::mssql_escape_string($param[2]) . db::mssql_escape_string(trim($variables[$param[1]])) . db::mssql_escape_string($param[3]) ."', ";
				}
			}
			$query_sp = substr($query_sp, 0, (strlen($query_sp) -2));
//echo $query_sp . "<br>";
			if($log){
				Misc::log_action($user_id, $query_sp, $accion, $customer);
			}
			if($variables["process"] == 1 && trim($user_id) != ""){
				Misc::enviar_mail_GM($user_id, $accion, $variables);
				$profile = new profile( ca_session::get_userid( ));
		        $actual_email = $profile->get_mail_admin( );
  			    $user = new user( ca_session::get_userid( ));
                $titular = $user->get_titular( );
				Misc::enviar_mail_usuario($titular, $actual_email, lang($texto_accion));
			}
			$con = mssql_connect($info_sp["servidor"], $info_sp["login"], $info_sp["password"]);
			
			mssql_select_db($info_sp["db"], $con);
			$result = mssql_query($query_sp, $con);
//echo "--- ". $query_sp . " ---";
			if ($return_data == true){
				$i=0;
				while ($row = mssql_fetch_assoc($result)){
					foreach(array_keys($row) as $key){
						$data[$i][$key] = $row[$key];
					}
					$i++;
				}
				return $data;
			}else{
				return true;
			}
			
		}
		

	}
	
	
	
}

?>

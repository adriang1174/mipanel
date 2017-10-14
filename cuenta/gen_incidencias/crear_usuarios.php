<?php




define('DEBUG', true);

define('DB_SERVER', '201.216.230.56:1435');
define('DB_DATABASE', '');
define('DB_USER', 'report');
define('DB_PASS', '!report**');




if(DEBUG){
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL & ~E_NOTICE);	
}else{
	ini_set('display_errors', 0);
	ini_set('error_reporting', 0);
}

// ADODB
require_once('adodb/adodb-exceptions.inc.php');
require_once('adodb/adodb.inc.php');

$db =& ADONewConnection('mssql');
$db->Connect(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;


include_once('vtwsclib/Vtiger/WSClient.php');

$url = 'http://201.216.230.56';
$client = new Vtiger_WSClient($url);
$login = $client->doLogin('admin', 'bWo0eLUZ1BLcXZxm'); 


/*
$describe = $client->doDescribe('Accounts');
$cancreate = $describe[createable];
$canupdate = $describe[updateable];
$candelete = $describe[deleteable];
$canread = $describe[retrieveable];
$fields = $describe[fields];
print_r($fields);
exit;
*/


$incidencias = $db->getAll("select * from reportes..VTigerGeneraAccounts ");

print_r($incidencias);
foreach($incidencias as $incidencia){
	/*
	$query = "SELECT * FROM Accounts WHERE cf_604 = '". $incidencia['ca_cnro'] ."'";
	$records = $client->doQuery($query);
	
	$incidencia['Texto'] = utf8_encode($incidencia['Texto']);
	

	
	$fecha_creacion = explode(" ", $incidencia['FechaCreacion']); // Separo fecha de hora
	$fecha_creacion = explode("-", $fecha_creacion[0]);
	$fecha_creacion = $fecha_creacion[2] . "/" . $fecha_creacion[1] ."/" .$fecha_creacion[0];

	$res = $client->doCreate('HelpDesk', 
					array(
						'ticketcategories' => $incidencia['Categoria'],
						'cf_601' => $incidencia['SubCategoria'],
						'createdtime' => $fecha_creacion,
						'description' => utf8_decode($incidencia['Texto']),
						'modifiedtime' => $fecha_creacion,
						'parent_id' => $records[0]['id'],
						'ticketpriorities' => 'Normal',
						'ticketseverities' => 'Minor',
						'assigned_user_id' => $incidencia['Usuario'],
						'ticketstatus' => $incidencia['IncidenciaEstado'],
						'ticket_title' => $incidencia['Referencia']
							));
	if($res){
		echo "ENVIO OK. ID: ". $incidencia['id'] ."\n";
	}else{
		echo "ERROR AL CREAR EL TICKET. ID: ". $incidencia['id'] . " ERROR: ". $client->lastError()."\n";
	}
	$res2 = $db->execute("update reportes..VtigerGeneraIncidencias set estado = 1 where id = ?", array($incidencia['id']));
	if(!$res2){
		echo "ERROR AL ACTUALIZAR EL ESTADO DEL TICKET. ID: ". $incidencia['id']."\n";
	}
	*/
}

exit;

?>

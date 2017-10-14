<?php

include_once('vtwsclib/Vtiger/WSClient.php');
$url = 'http://201.216.230.56';
$client = new Vtiger_WSClient($url);


$login = $client->doLogin('admin', 'bWo0eLUZ1BLcXZxm'); //bWo0eLUZ1BLcXZxm
if(!$login){ 
	echo 'Login Failed';
	exit;
}


/*

echo "<pre>";
$modules = $client->doListTypes();
print_r($modules);
foreach($modules as $modulename => $moduleinfo) { 
$describe = $client->doDescribe($modulename);
print_r($describe);
$cancreate = $describe[createable];
$canupdate = $describe[updateable];
$candelete = $describe[deleteable];
$canread = $describe[retrieveable];
$fields = $describe[fields];
}

*/


$query = "SELECT * FROM Accounts WHERE cf_604 = 'C100624'";
$records = $client->doQuery($query);


print_r($records);





$res = $client->doCreate('HelpDesk', 
						array(
							'ticketcategories' => 'Cobranzas',
							'cf_601' => 'Cambio de Datos',
							'createdtime' => date('d/m/Y'),
							'description' => 'Cambio de forma de pago desde Mi Panel',
							'modifiedtime' => date('d/m/Y'),
							'parent_id' => $records[0]['id'],
							'ticketpriorities' => 'Normal',
							'ticketseverities' => 'Minor',
							'assigned_user_id' => '20x70',
							'ticketstatus' => 'Closed',
							'ticket_title' => 'Cambio de forma de pago desde Mi Panel'
								));
											

var_dump($res);

?>

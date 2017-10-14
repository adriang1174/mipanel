<?

require_once(INCLUDE_PATH . "db.php");
require_once("cc.php");
require_once("traff_nf.php");
require_once("traff_p.php");
require_once("traff_f.php");
require_once("ccenter.php");
require_once("rcall.php");
require_once("rates.php");
require_once("profile.php");

class ticket_list_item
{
	var $ticketid;
	var $date;
	var $importe;

	function ticket_list_item( $ticketid, $date, $importe)
	{
		$this->ticketid = $ticketid;
		$this->date = $date;
		$this->importe = $importe;
	}
}

class ticket_consumo_list_item
{
	var $description;
	var $units;
	var $importe;
	var $isdetailed;
	var $itemid;

	function ticket_consumo_list_item( $description, $units, $importe, $isdetailed, $itemid)
	{
		$this->description = $description;
		$this->units = $units;
		$this->importe = $importe;
		$this->isdetailed = $isdetailed;
		$this->itemid= $itemid;
	}
}

class ticket
{
	var $ticketid;
	var $factura_tipo;
	var $factura_nro;
	var $titular;
	var $address;
	var $city;
	var $state;
	var $userid;
	var $condpago;
	var $condiva;
	var $date;
	var $date_expire;
	var $cuit;
	var $passwd_banelco;
	var $passwd_link;
	var $comsumo_list;
	var $neto21;
	var $neto27;
	var $iva21;
	var $iva27;
	var $iva21ni;
	var $iva27ni;
	var $subtotal;
	var $total;
	var $itotal;
	var $total_string;
	var $monedaid;
}

class receipt
{
	var $receiptid;
	var $receipt_type;
	var $receipt_number;
	
	var $date;

	var $titular;
	var $cuit;
	var $userid;

	var $total;
	var $itotal;
	var $total_string;
	var $pay_date;
	var $item_list;
}

class receipt_list_item
{
	var $desc;
	var $bank;
	var $paycheck;
	var $date;
	var $amount;
	function receipt_list_item($desc, $bank, $paycheck, $date, $amount)
	{
		$this->desc = $desc;
		$this->bank = $bank;
		$this->paycheck = $paycheck;
		$this->date = $date;
		$this->amount = $amount;
	}
}


class ticket_item_detail
{
	var $itemid;
	var $ticketid;
	var $date;
	var $titular;
	var $items_list;
	var $total_calls;
	var $total_duration;
	var $total_price;
}

class ticket_item_detail_list
{
	var $pinid;
	var $servicetype;
	var $pin;
	var $calls;
	var $duration;
	var $price;

	function ticket_item_detail_list( $pinid, $servicetype, $pin, $calls, $duration, $price)
	{
		$this->pinid = $pinid;
		$this->servicetype = $servicetype;
		$this->pin = $pin;
		$this->calls = $calls;
		$this->duration = $duration;
		$this->price = $price;
	}
}

class ticket_item_traff
{
	var $ticketid;
	var $date;
	var $titular;
	var $itemid;
	var $traff_list;
	var $total_duration;
	var $total_price;
}

class ticket_item_traff_list
{
	var $date;
	var $hour;
	var $source;
	var $called;
	var $target;
	var $duration;
	var $price;

	function ticket_item_traff_list( $date, $hour, $source, $called, $target, $duration, $price)
	{
		$this->date = $date;
		$this->hour = $hour;
		$this->source = $source;
		$this->called = $called;
		$this->target = $target;
		$this->duration = $duration;
		$this->price = $price;
	}
}

function adminlogin($cliente_id){

	 $query = "
    	SELECT upper(cliente_id) AS cliente_id, password
    	FROM clientes c
    	INNER JOIN estados e ON c.estado_id = e.estado_id
    	WHERE lower(cliente_id) = '". strtolower($cliente_id) ."'";
     $res = db::get_rows_as_array_of_hashes($query);
     if($res[0]){
     	if(ca_session::login( $res[0]["cliente_id"], $res[0]["password"])){
     		return true;
     	}else{
     		return false;
     	}
     }else{
     	return false;
     }
}

function user_login(&$username, $password, &$mercado, &$idOwner) {

    $loguser = false;
	//añado restricción de seguridad, lo que de paso me permite simplificar la consulta
	if (strlen($username) == 0) return false;
	
	db::init();


    $l_user = strtolower($username);
    $l_pass = strtolower($password);
    
    if (!empty($_SERVER['HTTP_CLIENT_IP'])){
		$ip=$_SERVER['HTTP_CLIENT_IP'];
	}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
		$ip=$_SERVER['REMOTE_ADDR'];
	}
	
	/*
    require('Browscap.php');
	require('geoip.inc');
	
	$bc = new Browscap(INCLUDE_PATH .'data/browscap_cache');
	$current_browser = $bc->getBrowser();
	
	$gi = geoip_open(INCLUDE_PATH ."data/GeoIP.dat",GEOIP_STANDARD);

	$country_code = geoip_country_code_by_addr($gi, $ip);

	geoip_close($gi);
    */

    //09-04-06 Se amplia el criterio de login al uso opcional de cliente_id ó cuil
    $query = "
    	SELECT upper(cliente_id) AS cliente_id, mercado, empresa, e.descripcion as estado_cliente 
    	FROM clientes c
    	INNER JOIN estados e ON c.estado_id = e.estado_id
    	WHERE 
    		(lower(cliente_id) = '$l_user' OR lower(cuit) = '$l_user' OR (mail_admin_verif = 1 AND mail_admin = '$l_user') ) 
    		AND lower(password) = '$l_pass'";
    $res = db::get_rows_as_array_of_hashes($query);
    if(count($res) > 1){

    	return array(false, 2);
    }

    
    if(!$res[0]) { // Me fijo si existe un usuario asociado a un cliente
    	$query = "
			SELECT upper(u.cliente_id) AS cliente_id, mercado, empresa, e.descripcion as estado_cliente, grupo 
			FROM usuarios_mipanel u
			INNER JOIN clientes c ON u.cliente_id = c.cliente_id 
			INNER JOIN estados e ON c.estado_id = e.estado_id
			WHERE lower(u.usuario) = '$l_user' AND lower(u.password) = '$l_pass' AND u.activo = 1";

		$res = db::get_rows_as_array_of_hashes($query);
		$loguser = array(true);
    }
    
    if(!$res[0]) { // Me fijo si existe un usuario customer
    	$query = "
			SELECT usuario, grupo , usuario_id
			FROM usuarios_mipanel u
			WHERE lower(u.usuario) = '$l_user' AND lower(u.password) = '$l_pass' AND u.activo = 1";

		$res = db::get_rows_as_array_of_hashes($query);
		if($res[0]) {
		    //$ips_validas_admin = array('201.216.230.56', '201.216.230.57', '190.245.18.241');
		    $ips_validas_admin = array('201.216.230.56', '201.216.230.57','201.216.209.57');

		    if(!in_array($ip, $ips_validas_admin)){
		        echo "Forbidden";
		        exit;
		    }

			ca_session::set('admin_access', true);
			ca_session::set('admin_username', $l_user);
			ca_session::set('admin_group', $res[0]['grupo']);
			ca_session::set('admin_usuario_id', $res[0]['usuario_id']);
			
			
			$res = db::DoIt("INSERT INTO logaccesos (cliente_id, fecha, ip, browser, pais, accion, usuario) VALUES ('', current_timestamp, '". $ip ."', '". $current_browser->Browser ." ". $current_browser->Version ."', '". $country_code ."', 'login', '". $l_user ."')");

			header("location: admin_home.ca");
			exit;
		}
    }
    
  
	if($res[0]) {
		$username = $res[0]["cliente_id"];
		//echo "<pre>" . var_dump($res[0], true) . "</pre>";
		
		//no quiero cambiar la firma de la funcion (ret de empresa)
		//ni tomar el riesgo de que no se asigne a la var de session
		//en el metodo que rigino la llamada asi que lo asigno a la 
		//var de Session
		ca_session::set('mercado', $res[0]["mercado"]);
		ca_session::set('empresa', $res[0]["empresa"]);
		ca_session::set('estado_cliente', $res[0]["estado_cliente"]);
		
	
		$SQLQry = "SELECT carpeta, owner_id FROM owner "
			. " WHERE \"mercado\" = " . $res[0]['mercado'] 
			. " AND \"empresa\" = " . $res[0]['empresa'] . ";";
		//$SQLQry = "SELECT carpeta, owner_id FROM owner WHERE owner_id = " . $res[0]['mercado'] . ";";
		$res2 = db::get_rows_as_array_of_hashes($SQLQry);
		
		if (count($res2) > 0) {
			
			//estas var. estan por referencia
			$mercado = $res2[0]["carpeta"];
			$idOwner = $res2[0]["owner_id"];
			
		} else {
			$SQLQry = "SELECT carpeta, owner_id FROM owner WHERE owner.\"default\" = true;";
			$res2 = db::get_rows_as_array_of_hashes($SQLQry);
			
			//estas var. estan por referencia
			$mercado = $res2[0]["carpeta"];
			$idOwner = $res2[0]["owner_id"];
			
		}
		
		
		
		if($loguser){
			db::DoIt("INSERT INTO logaccesos (cliente_id, fecha, ip, browser, pais, accion, usuario) VALUES ('". $username ."', current_timestamp, '". $ip ."', '". $current_browser->Browser ." ". $current_browser->Version ."', '". $country_code ."', 'login', '". $l_user ."')");
		}else{
			db::DoIt("INSERT INTO logaccesos (cliente_id, fecha, ip, browser, pais, accion) VALUES ('". $username ."', current_timestamp, '". $ip ."', '". $current_browser->Browser ." ". $current_browser->Version ."', '". $country_code ."', 'login')");
		}

		return array(true);
		
	} else {

		return array(false, 1);
		
	}

}
/*
function user_login(&$username, $password, &$mercado, &$idOwner) {
   
	//añado restricción de seguridad, lo que de paso me permite simplificar la consulta
	if (strlen($username) == 0) return false;
	
	db::init();

    $l_user = strtolower($username);
    $l_pass = strtolower($password);
    
    //09-04-06 Se amplia el criterio de login al uso opcional de cliente_id ó cuil
    $query = "
    	SELECT upper(cliente_id) AS cliente_id, mercado, empresa, e.descripcion as estado_cliente 
    	FROM clientes c
    	INNER JOIN estados e ON c.estado_id = e.estado_id
    	WHERE 
    		(lower(cliente_id) = '$l_user' OR lower(cuit) = '$l_user') 
    		AND lower(password) = '$l_pass'";
    $res = db::get_rows_as_array_of_hashes($query);
    
	if($res[0]) {
		return _loginStep2($res[0]);
		
	} else { // No existe como cliente, me fijo si es una cuenta de usuario
		$query = "
			SELECT upper(u.cliente_id) AS cliente_id, mercado, empresa, e.descripcion as estado_cliente, grupo 
			FROM usuarios_mipanel u
			INNER JOIN clientes c ON u.cliente_id = c.cliente_id 
			INNER JOIN estados e ON c.estado_id = e.estado_id
			WHERE lower(u.usuario) = '$l_user' AND lower(u.password) = '$l_pass'";

		$res = db::get_rows_as_array_of_hashes($query);
		
		if($res[0]) {
			return _loginStep2($res[0]);
		}else{
			// BAD LOGIN!
			return false;
		}	
	}

}


function _loginStep2($arr){
	
	$username = $arr["cliente_id"];
	ca_session::set('mercado', $arr["mercado"]);
	ca_session::set('empresa', $arr["empresa"]);
	ca_session::set('estado_cliente', $arr["estado_cliente"]);
	
	
	$SQLQry = "SELECT carpeta, owner_id FROM owner "
		. " WHERE \"mercado\" = " . $arr['mercado'] 
		. " AND \"empresa\" = " . $arr['empresa'] . ";";
		

	$res2 = db::get_rows_as_array_of_hashes($SQLQry);
	
	
	if (count($res2) > 0) {
		
		//estas var. estan por referencia
		$mercado = $res["carpeta"];
		$idOwner = $res["owner_id"];
		
	} else {
		$SQLQry = "SELECT carpeta, owner_id FROM owner WHERE owner.\"default\" = true;";
		$res2 = db::get_rows_as_array_of_hashes($SQLQry);
		
		//estas var. estan por referencia
		$mercado = $res["carpeta"];
		$idOwner = $res["owner_id"];
		
	}
	
	if (!empty($_SERVER['HTTP_CLIENT_IP'])){
		$ip=$_SERVER['HTTP_CLIENT_IP'];
	}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
		$ip=$_SERVER['REMOTE_ADDR'];
	}
	
	/*require('Browscap.php');
	require('geoip.inc');
	
	$bc = new Browscap(INCLUDE_PATH .'data/browscap_cache');
	$current_browser = $bc->getBrowser();
	
	$gi = geoip_open(INCLUDE_PATH ."data/GeoIP.dat",GEOIP_STANDARD);

	$country_code = geoip_country_code_by_addr($gi, $ip);

	geoip_close($gi);*/
	/*
	db::DoIt("INSERT INTO logaccesos (cliente_id, fecha, ip, browser, pais, accion) VALUES ('". $username ."', current_timestamp, '". $ip ."', '". $current_browser->Browser ." ". $current_browser->Version ."', '". $country_code ."', 'login')");

	return true;

}
*/
function owner_to_ownerid($owner = null, $nosession = false) {
    global $pdf_owner_id;
    if(isset($pdf_owner_id) && $pdf_owner_id != ''){
        return $pdf_owner_id;
    }
    
    if($nosession){
    	switch( strtolower( $owner)) {
		    case "red": 
		    	return 1;
		    case "hola": 
		    	return 3;
		    case "holared":
		    	return 2;
			case "viatel": 
				return 4;
			case "latinatel":
				return 5;
			case "ahorratel":
				return 6;
			case "telephone2":
				return 7;
			case "t2":
				return 8;
		}
    
    }else{
		return ca_session::get("ownerId");
	}
	/*
	switch( strtolower( $owner)) {
        case "red": return 1;
        case "hola": return 2;
		case "viatel": return 4;
    }
    return null;
	*/
	
}



function user_login_no_password(&$username, &$mercado, &$idOwner) {
	
	//añado restricción de seguridad, lo que de paso me permite simplificar la consulta
	if (strlen($username) == 0) return false;
	
	db::init();

    $l_user = strtolower($username);
	
	//09-04-06 Se amplia el criterio de login al uso opcional de cliente_id ó cuil
    $query = "
    	SELECT upper(cliente_id) AS cliente_id, mercado, empresa 
    	FROM clientes 
    	WHERE 
    		(lower(cliente_id) = '$l_user' OR lower(cuit) = '$l_user');";
    $res = db::get_rows_as_array_of_hashes($query);
    
	if($res[0]) {
		//asegura que aqui queda e el cliente_id si el user puso un cuil
		$username = $res[0]["cliente_id"];
		
		//no quiero cambiar la firma de la funcion (ret de empresa)
		//ni tomar el riesgo de que no se asigne a la var de session
		//en el metodo que rigino la llamada asi que lo asigno a la 
		//var de Session
		ca_session::set('mercado', $res[0]["mercado"]);
		ca_session::set('empresa', $res[0]["empresa"]);
		
		/* 
		   (!)
		   originalmente deberia ser algo como:
		   $SQLQry = "SELECT carpeta, owner_id FROM owner WHERE mercado = " . $res[0]['mercado'] . ";";
		   
		   ahora bien van a evolucionarlo de forma que un cliente pueda tener varios mercaodos
		   y varios owners (o una sola combinacion de ellos.
		   Actualmente la consulta puede devolver 2 o mas filas pues no ofrece forma de distinguirlos
		   en consecuencia se aprovecha la coincidencia actual del owner_id con el mercado
		   y se reescribe la consulta (MAL pues depende del hardcode de id) a la foma
		*/
		$SQLQry = "SELECT carpeta, owner_id FROM owner "
			. " WHERE \"mercado\" = " . $res[0]['mercado'] 
			. " AND \"empresa\" = " . $res[0]['empresa'] . ";";
		
		$res2 = db::get_rows_as_array_of_hashes($SQLQry);
		
		if (count($res2) > 0) {
			$mercado = $res2[0]["carpeta"];
			$idOwner = $res2[0]["owner_id"];
		} else {
			$SQLQry = "SELECT carpeta, owner_id FROM owner WHERE owner.\"default\" = true;";
			$res2 = db::get_rows_as_array_of_hashes($SQLQry);
			$mercado = $res2[0]["carpeta"];
			$idOwner = $res2[0]["owner_id"];
		}

		return true;
		
	} else {
		
		return false;
		
	}
	
}

function confirmationLinkChangePassword($codigo, $password){
	db::init();
	$res = db::get_rows_as_array("SELECT * FROM clientes_cambio_password WHERE codigo = '". $codigo ."'");
	$cliente_id = $res[0][0];
	//echo "UPDATE Clientes SET password = '". pg_escape_string($password) ."' WHERE cliente_id = '". $cliente_id ."' LIMIT 1";
	//UPDATE Password
	$con = mssql_connect("SMS", "estadisticas", "estadisticas");
	mssql_select_db("cuentaalternativa", $con);
	$query = "update webuserypass set pass = '".pg_escape_string($password)."' where ca_cnro = '" .$cliente_id . "'";
	 mssql_query($query, $con);
	$res = db::DoIt("UPDATE Clientes SET password = '". pg_escape_string($password) ."' WHERE cliente_id = '". $cliente_id ."' ");
	

	$res2 = db::DoIt("UPDATE clientes_cambio_password SET usado = 1 WHERE codigo = '". $codigo ."' AND cliente_id = '". $cliente_id . "'");

	return true;
}

function confirmationLinkIsValid($codigo){
	db::init();
	$res = db::get_rows_as_array("SELECT * FROM clientes_cambio_password WHERE usado = 0 AND codigo = '". $codigo ."'");
	if(count($res) == 0){
		return false;
	}else{
		if($res[0][3] + 172800 < time()){ // tiene mas de 48 hs
			return false;
		}else{
			return true;
		}
	}
}

function getOwnerIdFromConfirmationLink($codigo){
	db::init();
	$res = db::get_rows_as_array("SELECT o.owner_id
		FROM clientes_cambio_password ccp
		INNER JOIN clientes c ON ccp.cliente_id = c.cliente_id
		INNER JOIN owner o ON c.mercado = o.mercado AND c.empresa = o.empresa
		WHERE codigo = '". $codigo ."'");
	return $res[0][0];
}

// Crea el registro en la db y envia el mail para cambiar la clave.
function sendChangePasswordEmail($cliente_id){
	db::init();
	$codigo = '';
	while(strlen($codigo) < 10){
		if(rand(0, 1) == 1){
			$codigo .= rand(0, 9);
		}else{
			$codigo .= chr(rand(65, 90));
		}
	}
	$codigo = sha1($codigo);
//echo "INSERT INTO clientes_cambio_password (cliente_id, codigo, timestamp_pedido, usado) VALUES ('". strtoupper($cliente_id) ."', '". $codigo ."', ". time() .", 0)";

	$res = db::DoIt("INSERT INTO clientes_cambio_password (cliente_id, codigo, timestamp_pedido, usado) VALUES ('". strtoupper($cliente_id) ."', '". $codigo ."', ". time() .", 0)");

	return $codigo;
/* COMENTADO PORQUE EN EL CAMBIO DE VERSION EL CODIGO DABA ERROR AUNQUE LO CREARA BIEN
	if($res){
		return $codigo;
	}else{
		return false;
	}
*/
	
}

/*
	Esta funcion retorna un array de datos del usuario (incluido el 
	ownerFolder infiriendola a partir de los campos: empresa, mercado)
	Notas:
		1) Admite cliente_id o CUIT como parametro de busqueda
		2) Retorna false si no se encuentra el cliente o si el 
		   idClienteOrCuit es una cadena vacia.
		3) ver user_login para mas detalles
*/
function user_getData($idClienteOrCUIT) {
	
	//añado restricción de seguridad, lo que de paso me permite simplificar la consulta
	if (strlen($idClienteOrCUIT) == 0) return false;
	
	db::init();

    $l_user = strtolower($idClienteOrCUIT);
	
    $query = "
    	SELECT 
    		upper(cliente_id) AS cliente_id, cuit, 
    		mail_admin, rsocial, 
    		mercado, empresa 
    	FROM clientes 
    	WHERE 
    		(lower(cliente_id) = '$l_user' OR lower(cuit) = '$l_user');";
    
    $res = db::get_rows_as_array_of_hashes($query);
    
	if($res[0]) {
		
		$datos = array();
		$datos["cliente_id"] = $res[0]["cliente_id"];
		$datos["cuit"] = $res[0]["cuit"];
		$datos["mail_admin"] = $res[0]["mail_admin"];
		$datos["rsocial"] = $res[0]["rsocial"];
		
		$SQLQry = "SELECT carpeta, owner_id FROM owner "
			. " WHERE \"mercado\" = " . $res[0]['mercado'] 
			. " AND \"empresa\" = " . $res[0]['empresa'] . ";";
		
		$res2 = db::get_rows_as_array_of_hashes($SQLQry);
		
		if (count($res2) > 0) {
			$datos["folderName"] = $res2[0]["carpeta"];
		} else {
			$SQLQry = "SELECT carpeta, owner_id FROM owner WHERE owner.\"default\" = true;";
			$res2 = db::get_rows_as_array_of_hashes($SQLQry);
			$datos["folderName"] = $res2[0]["carpeta"];
		}

		return $datos;
		
	} else {
		
		return false;
		
	}
	
}


class user
{
	var $userid;
	
	function user( $userid)
	{
		$this->userid = $userid;
	}

	function get_currency( $id)
	{
		db::init();
		$query = "select simbolo from monedas where moneda_id = '$id'";
		return db::get_row_as_scalar($query);
	}
    
	function get_currency_desc( $id)
	{
		db::init();
		$query = "select descripcion from monedas where moneda_id = '$id'";
		return db::get_row_as_scalar($query);
	}

	function month_to_string( $n)
	{
		switch( $n)
		{
			case 12: return TPL_DECEMBER;
			case 11: return TPL_NOVEMBER;
			case 10: return TPL_OCTOBER;
			case 9: return TPL_SEPTEMBER;
			case 8: return TPL_AUGOUST;
			case 7: return TPL_JULY;
			case 6: return TPL_JUNE;
			case 5: return TPL_MAY;
			case 4: return TPL_APRIL;
			case 3: return TPL_MARCH;
			case 2: return TPL_FEBRUARY;
			case 1: return TPL_JANUARY;
		}

		return "";
	}
	
	function get_ticket_months( )
	{
		/*
		$months = array( );

		$month = ( int)date( "n");
		if ( $month == 1) $month = 12;
		else $month --;
		
		for( $n = 0; $n < 11; $n ++, $month --)
		{
			$months[ ( string)$month] = $this->month_to_string( $month);
			if ( $month == 1) $month = 13;
		}
		*/
		
		$months = array();
		for($i=1; $i<13; $i++){
			$months[$i] = $this->month_to_string( $i);
		}
		return $months;
	}
	
	function get_ticket_years( )
	{
		$tmp = array();
		for($i=date("Y"); $i > 1999; $i--){
			array_push($tmp, $i);
		}
		return $tmp;
	}
	
	function get_pais( )
    {
		db::init();
        $query = "select pais from clientes where cliente_id = '$this->userid'";
	    return db::get_row_as_scalar($query);
    }
	
    function get_titular( )
    {
		db::init();
        $query = "select rsocial from clientes where cliente_id = '$this->userid'";
	    return db::get_row_as_scalar($query);
    }
    
	function get_email( )
    {
    	//return "sebastian@promaker.com.ar";
		db::init();
        $query = "select email from clientes where cliente_id = '$this->userid'";
	    return db::get_row_as_scalar($query);
    }
	
    function get_cuit()
    {
		db::init();
        $query = "select cuit from clientes where cliente_id = '$this->userid'";
	    return db::get_row_as_scalar($query);
    }

    function get_user_country()
    {
		db::init();
        $query = "select pais from clientes where cliente_id = '$this->userid'";
	    return db::get_row_as_scalar($query);
    }
    
    function get_user_mercado()
    {
		db::init();
        $query = "select mercado from clientes where cliente_id = '$this->userid'";
	    return db::get_row_as_scalar($query);
    }

	function get_receipt($receiptid)
	{
		db::init();
		$r = new receipt();

		$receipt_array = explode('-', $receiptid, 3);

        if($receipt_array[0] == "R")
		  $r->receipt_type = "R ";
        else
		  $r->receipt_type = $receipt_array[0];
		$r->receipt_number = $receipt_array[1] ."-". $receipt_array[2];

        $query = "select moneda_pago_id, to_char(fechemision, 'DD/MM/YYYY') as fechemision, to_char(fecha_pago, 'DD/MM/YYYY') as fecha_pago, importe_pago from recheader where tipodoc = '".$r->receipt_type."' and sucdoc = '".(int) $receipt_array[1]."' and numdoc = '".(int) $receipt_array[2]."' and cliente_id = '$this->userid'";

        $receipt = db::get_rows_as_array_of_hashes($query);
        if(!count($receipt))
            return NULL;
        $myreceipt = $receipt[0];
        
        $r->receiptid = $receiptid;
	$r->receipt_suc=$receipt_array[1];
	$r->date = $myreceipt['fechemision'];
        $r->titular = $this->get_titular();
        $r->cuit = $this->get_cuit();
        $r->userid = $this->userid;
		$r->total = $myreceipt['importe_pago'];
		$r->itotal = $myreceipt['importe_pago'];
		$r->pay_date = $myreceipt['fecha_pago'];
        $money_desc = $this->get_currency_desc($myreceipt['moneda_pago_id']);


        $r->total_string = "$money_desc ".misc::num_to_semantic_str( $r->itotal);

        $query = "select * from reclineas where trim(cliente_id) = '". $this->userid ."' AND tipodoc = '".$r->receipt_type."' and sucdoc = '".(int) $receipt_array[1]."' and numdoc = '".(int) $receipt_array[2]."'";

        $receipt_lines = db::get_rows_as_array_of_hashes($query);
        
        $r->item_list = array();
        foreach ($receipt_lines as $line)
            $r->item_list[] = new receipt_list_item($line['descpago'], $line['banco'], $line['nrocheque'], $line['fechacheque'], $line['importe']);
        
		return $r;	
	}
	
	function get_cc_detail($datefrom, $dateto, $offset, $limit, &$is_last, $get_total, &$total)
	{
		
		$today = date("m/d/Y");
		
		if($datefrom == NULL)
		  $datefrom = "01/01/1990";

		if($dateto == NULL)
		  $dateto = $today;

		$ccd = new ca_cc($this->userid, $datefrom, $dateto);
		$ccd->cc_get_saldo_inicial($datefrom);
		$ccd->cc_get_detail_list($datefrom, $dateto);

		if($get_total)
		{
			$total = count($ccd->cc_detail_list);
			if($total - ($offset + $limit) < 0){
				$is_last = true;
			}
		}

		if($is_last)
		{
			$ccd->cc_get_saldo_final($datefrom, $dateto);
		}

		$cc_get_detail_list_pag = array_slice( $ccd->cc_detail_list, $offset, $limit);
		$ccd->cc_detail_list = $cc_get_detail_list_pag;

		return $ccd;
	}

	function get_ticket_item_traff($ticketid, $itemid, $pinid, $servicetype, $offset, $limit, &$is_last, $get_total, &$total)
	{
		db::init();

		$tit = new ticket_item_traff();
		$tit->itemid = $itemid;

		$ticket_array = explode('-', $ticketid, 3);
		
		$userid = $this->userid;
		$tipodoc = $ticket_array[0];
		$sucdoc = (int) $ticket_array[1];
		$numdoc = (int) $ticket_array[2];

		$tit->total_duration = "0";
		$tit->total_price = "0";

		if($get_total)
		{
			$query = "select count(*) ";
			$query .= "from TraficoHistorico th, FactLineas fl ";
			$query .= "where ";
			$query .= "th.numdoc = '$numdoc' and th.sucdoc=fl.sucdoc and th.tipodoc=fl.tipodoc and th.codlinea=fl.codlinea and ";
			$query .= "fl.tipodoc = '$tipodoc' and fl.sucdoc = '$sucdoc' and fl.numdoc = '$numdoc' and fl.codlinea = '$itemid' and ";
			$query .= "th.tiposervicio = '$servicetype' and th.linea = '$pinid'";
			
			$total = db::get_row_as_scalar($query);

			if($total - ($offset + $limit) < 0)
				$is_last = true;
		}
		
		if($is_last)
		{
		// do some final things
			$query = "select sum(th.duracion), sum(th.importe) ";
			$query .= "from TraficoHistorico th, FactLineas fl ";
			$query .= "where ";
			$query .= "th.numdoc = '$numdoc' and th.sucdoc=fl.sucdoc and th.tipodoc=fl.tipodoc and th.codlinea=fl.codlinea and ";
			$query .= "fl.tipodoc = '$tipodoc' and fl.sucdoc = '$sucdoc' and fl.numdoc = '$numdoc' and fl.codlinea = '$itemid' and ";
			$query .= "th.tiposervicio = '$servicetype' and th.linea = '$pinid'";
			
			$totals = db::get_rows_as_array($query);
			$tit->total_duration = $totals[0][0];
			$tit->total_price = $totals[0][1];
		}
		
		$query = "select contacto, to_char(fechemision, 'DD/MM/YYYY'), moneda_id ";
		$query .= "from factheader ";
		$query .= "where cliente_id = '$userid' and tipodoc = '$tipodoc' and sucdoc = '$sucdoc' and numdoc = '$numdoc'";
		$customer_data = db::get_rows_as_array($query);
		
		$tit->ticketid = $ticketid;
		$tit->titular = $customer_data[0][0];
		$tit->date = $customer_data[0][1];
	
		$query = "select to_char(th.fecha, 'DD/MM/YYYY'), th.hora, th.origen, th.destino, th.destinotxt, th.duracion, ";
		$query .= "th.importe, th.moneda, th.fecha as fecha2 ";
		$query .= "from TraficoHistorico th, FactLineas fl ";
		$query .= "where ";
		$query .= "th.numdoc = '$numdoc' and th.sucdoc=fl.sucdoc and th.tipodoc=fl.tipodoc and th.codlinea=fl.codlinea and ";
		$query .= "fl.tipodoc = '$tipodoc' and fl.sucdoc = '$sucdoc' and fl.numdoc = '$numdoc' and fl.codlinea = '$itemid' and ";
		$query .= "th.tiposervicio = '$servicetype' and th.linea = '$pinid' ";
		$query .= "order by fecha2, th.hora limit $limit offset $offset";
	
		$ticket_item_traff = db::get_rows_as_array($query);
		
		$tit->traff_list = array();

		$money = $this->get_currency($customer_data[0][2]);
		foreach($ticket_item_traff as $item_traff)
		{
			$price = $money ." ". $item_traff[6];
			$tit->traff_list[] = new ticket_item_traff_list($item_traff[0], $item_traff[1], $item_traff[2], $item_traff[3], $item_traff[4], $item_traff[5], $price);
		}
		return $tit;
	}
	
	function get_ticket_item_details($ticketid, $itemid)
	{
		db::init();

		$ti = new ticket_item_detail();
		$ti->itemid = $itemid;

		$ticket_array = explode('-', $ticketid, 3);
		
		$query = "select contacto, to_char(fechemision, 'DD/MM/YYYY'), moneda_id ";
		$query .= "from factheader ";
		$query .= "where cliente_id = '".$this->userid."' and tipodoc = '".$ticket_array[0]."' and sucdoc = '". (int) $ticket_array[1]."' and numdoc = '".(int) $ticket_array[2]."'";
		$customer_data = db::get_rows_as_array($query);
		
		$ti->ticketid = $ticketid;
        $ti->titular = $this->get_titular();
		$ti->date = $customer_data[0][1];

		$query = "select (th.tiposervicio || ' ' || th.linea) as tlinea, ";
		$query .= "th.moneda, count(*) as llamados, sum(duracion) as duracion, sum(importe) as importe ";
		$query .= "from traficohistorico th ";
		$query .= "where tipodoc = '".$ticket_array[0]."' and cliente_id = '". $this->userid ."' and sucdoc = '".(int) $ticket_array[1]."' and numdoc = '".(int) $ticket_array[2]."' and codlinea = '".$itemid."' ";
		$query .= "group by tlinea, th.moneda";


		$ticket_items = db::get_rows_as_array($query);
		
		$ti->items_list = array();

		$ti->total_calls = 0;
		$ti->total_duration = 0;
		$ti->total_price = 0;
		$money = $this->get_currency($customer_data[0][2]);

		foreach($ticket_items as $item)
		{
			$data = explode(' ', $item[0], 2);
			$pinid = $data[1];
			$servicetype = $data[0];
				
			$ti->items_list[] = new ticket_item_detail_list($pinid, $servicetype, $item[0], $item[2], $item[3], $money ." ". $item[4]);
			$ti->total_calls += $item[2];
			$ti->total_duration += $item[3];
			$ti->total_price += $item[4];
		}
		
		$ti->total_price = $money ." ". $ti->total_price;
		
		/*	
			new ticket_item_detail_list("L 3514978344", "207", "900", "$253.96"),
			new ticket_item_detail_list("L 3514978345", "98", "446", "$101.04")

			$ti->total_calls = "365";
			$ti->total_duration = "1651";
			$ti->total_price = "$418.52";
		*/

		return $ti;
	}

	function get_ticket_list( $month, $offset, $limit, &$is_last, $get_total, &$total)
	{
		db::init();

		if($get_total)
		{
			$query = "select count(*) ";
			$query .= "from factheader where ";
			$query .= "cliente_id = '$this->userid'";
			$total = db::get_row_as_scalar($query);

			if($total - ($offset + $limit) < 0)
				$is_last = true;
		}
		
		if($is_last)
		{
			// do some final things
		}
		
		$query = "select tipodoc || '-' || lpad(cast(sucdoc as varchar),4, '0') || '-' || lpad(cast(numdoc as varchar), 8, '0'),";
		$query .= "to_char(fechemision, 'DD/MM/YYYY'), ";
		$query .= "( neto + neto27 + iva + iva27 + ivani + iva27ni), moneda_id ";
		$query .= "from factheader where ";
		$query .= "cliente_id = '". $this->userid ."' ";
		$query .= "order by fechemision DESC limit $limit offset $offset";

		$tickets = db::get_rows_as_array($query);

		$out = array();
		foreach ($tickets as $ticket)
		{
			$money = $this->get_currency($ticket[3]);
			$out[] = new ticket_list_item( $ticket[0], $ticket[1], $money ." ". $ticket[2]);
		}
		return $out;
	}

	function get_ticket( $ticketid, $month = null, $year = null)
	{
		db::init();
		$t = new ticket( );

		if ( $month)
		{
		/*
			$thismonth = date("m");
			if($month > $thismonth)
			{
				$ts = time() - 3600*24*365;
				$year = date("Y", $ts);
			}
			else
			{
				$year = date("Y");
			}
		*/
			if(!$year){
				$year = date("Y");
			}
			$date_from = $year."-".$month."-01";
			$date_to = '';
			if($month == 12)
				$date_to = ($year+1)."-01-01";
			else
				$date_to = $year."-".($month+1)."-01";
			$query = "select tipodoc || '-' || lpad(cast(sucdoc as varchar),4, '0') || '-' || lpad(cast(numdoc as varchar), 8, '0') from factheader where cliente_id = '$this->userid' and fechemision >= '$date_from' and fechemision < '$date_to' order by fechemision";

			$ticketid = db::get_row_as_scalar($query);
		}
        
		$ticket_array = explode('-', $ticketid, 3);

		$t->ticketid = $ticketid;
		//add pablo
		$t->factura_suc= $ticket_array[1];
		//end add pablo
		$t->factura_tipo = $ticket_array[0];
		$t->factura_nro = $ticket_array[1] ."-". $ticket_array[2];

		/* Customer's personal info */
		$query = "select contacto, domicilio, localidad, provincia, cliente_id, condpago, condiva, to_char(fechemision, 'DD/MM/YYYY'), to_char(fechvto, 'DD/MM/YYYY'), perciibb, cae, to_char(fvtocae, 'DD/MM/YYYY') ";
		$query .= "from factheader ";
		$query .= "where cliente_id = '".$this->userid."' and tipodoc = '".$t->factura_tipo."' and sucdoc = '". (int) $ticket_array[1]."' and numdoc = '".(int) $ticket_array[2]."'";

		$customer_data = db::get_rows_as_array($query);
        
        if(!count($customer_data))
            return NULL;
        
        $t->titular = $this->get_titular();
		$t->address = $customer_data[0][1];
		$t->city = $customer_data[0][2];
		$t->state = $customer_data[0][3];
		$t->userid = $customer_data[0][4];
		$t->condpago = $customer_data[0][5];
		$t->condiva = $customer_data[0][6];
		$t->date = $customer_data[0][7];
		$t->date_expire = $customer_data[0][8];
		$t->perc_iibb = $customer_data[0][9];
		$t->cae = $customer_data[0][10];
		$t->fvtocae = $customer_data[0][11];
		
		
		$query = "select cuit, cpebanelco, cpelink from clientes where cliente_id = '".$this->userid."'";
		$customer_pay_data = db::get_rows_as_array($query);
		
		$t->cuit = $customer_pay_data[0][0];
		$t->passwd_banelco = $customer_pay_data[0][1];
		$t->passwd_link = $customer_pay_data[0][2];

        if($t->factura_tipo == "FA")
    		$query = "select desclinea, minutos, importe, contrafico, codlinea from factlineas where tipodoc = '".$t->factura_tipo."' and sucdoc = '".(int) $ticket_array[1]."' and numdoc = '".(int) $ticket_array[2]."' AND trim(cliente_id) = '". $this->userid ."'";
        else
		    $query = "select desclinea, minutos, ( importe + iva) as importe, contrafico, codlinea from factlineas where tipodoc = '".$t->factura_tipo."' and sucdoc = '".(int) $ticket_array[1]."' and numdoc = '".(int) $ticket_array[2]."' AND trim(cliente_id) = '". $this->userid ."'";
		
	
	
		$lines_out = db::get_rows_as_array($query);


		$query_money = "select moneda_id ";
		$query_money .= "from factheader where ";
		$query_money .= "tipodoc = '".$t->factura_tipo."' and sucdoc = '".(int) $ticket_array[1]."' and numdoc = '".(int) $ticket_array[2]."' AND cliente_id = '".  $this->userid ."'";

		$money_out = db::get_row_as_scalar($query_money);
		$money = $this->get_currency($money_out);

		$line_out = array();
		foreach ($lines_out as $line)
		{
			if(ctype_alnum($line[3]))
			  $detail = true;
			else
			  $detail = false;

			$line_out[] = new ticket_consumo_list_item( $line[0], $line[1], $money ." ". $line[2], $detail, $line[4]);
		}

		$t->comsumo_list = $line_out;

		$query = "select moneda_id, ( neto + neto27 + iva + iva27 + ivani + iva27ni + COALESCE(perciibb, 0)), ( neto + neto27), neto, neto27, iva, iva27, ivani, iva27ni, perciibb from factheader where ";
		$query .= "cliente_id = '".$this->userid."' and ";
		$query .= "tipodoc = '".$t->factura_tipo."' and sucdoc = '".(int) $ticket_array[1]."' and numdoc = '".(int) $ticket_array[2]."'";
		$totals = db::get_rows_as_array($query);
		$money = $this->get_currency($totals[0][0]);
		
		$t->monedaid = $totals[0][0];
		$t->itotal = $totals[0][1];
		$t->total = $money ." ". $totals[0][1];
		$t->subtotal = $money ." ". $totals[0][2];
		$t->neto21 = $money ." ". $totals[0][3];
		$t->neto27 = $money ." ". $totals[0][4];
		$t->iva21 = $money ." ". $totals[0][5];
		$t->iva27 = $money ." ". $totals[0][6];
		$t->iva21ni = $money ." ". $totals[0][7];
		$t->iva27ni = $money ." ". $totals[0][8];

        $money_desc = $this->get_currency_desc($totals[0][0]);
        
        $owner = owner_to_ownerid();
	    if($owner == 5){
	        $money_desc = str_replace('Dolares', 'Dollars', $money_desc);
	    }
        
        
        $t->total_string = "$money_desc ".misc::num_to_semantic_str( $t->itotal);

		return $t;
	}

	function get_traff_nf( )
	{
		$traff_nf = new traff_nf(false, date( "Y/m/d"), get_customer_lines_pids($this->userid));
		return $traff_nf;
	}

	function get_traff_p( )
	{
		$traff_p = new traff_p(false, date( "Y/m/d"), get_customer_lines_pids($this->userid));
		return $traff_p;
	}

	function get_traff_f( )
	{
		$traff_f = new traff_f(traff_f_get_ticket_list($this->userid));
		return $traff_f;
	}
}

?>

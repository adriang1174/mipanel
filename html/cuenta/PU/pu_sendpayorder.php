<?
require_once( '../../../cuenta/inc/defines.php');
require_once( '../../../cuenta/inc/clientcontrol.php');

$if=$_REQUEST["if"];
#error_log("ambito: ".$_REQUEST,0);
$trans_id=$_REQUEST["trans_id"];
$total=$_REQUEST["total"];
$ret = include ("pu_payorder_class.php");
$rsocial=$_REQUEST["rsocial"];
$ticketid=$_REQUEST["ticketid"];
$hash = $_REQUEST["h"];

if ( strcmp( $hash, sha1( $total . $trans_id . $if . $ticketid . DEF_CA_SECRET)) != 0)
{
    clientcontrol::forbidden( );
}

$xml = "";
$xml .= "<XPU_ExternalEnvelope>\n";
$xml .= " <Header>\n";
$xml .= "  <TransactionId>XPU_PayOrder</TransactionId>\n";
$xml .= " </Header>\n";
$xml .= " <Body>\n";
$xml .= "  <XPU_PayOrder>\n";
$xml .= "   <Order>\n";
$xml .= "    <Id>$trans_id</Id>\n";
$xml .= "    <CurrencyId>ARS</CurrencyId>\n";
$xml .= "    <SubTotal>$total</SubTotal>\n";
$xml .= "    <Shipping>0</Shipping>\n";
$xml .= "    <Discount>0</Discount>\n";
$xml .= "    <Taxes>0</Taxes>\n";
$xml .= "    <Total>$total</Total>\n";
$xml .= "    <Deliverable>0</Deliverable>\n";
$xml .= "    <OneShipment>0</OneShipment>\n";
$xml .= "    <DeliveryDate/>\n";
$xml .= "    <ShipToMultAddresses>0</ShipToMultAddresses>\n";
$xml .= "    <AddressId>0</AddressId>\n";
$xml .= "    <ReceiverId>0</ReceiverId>\n";
$xml .= "    <AvailableDays/>\n";
$xml .= "    <ExpirationHours>24</ExpirationHours>\n";
$xml .= "    <Items>\n";
$xml .= "      <Item Id=\"0000\" Descrip=\"PAGO A CUENTA\" Units=\"1\" Price=\"$total\" UnitPrice=\"$total\" DeliveryDate=\"2001-09-09\" AddressId=\"0\" ReceiverId=\"0\" AvailableDays=\"4444444\"/>\n";
$xml .= "    </Items>\n";
$xml .= "   </Order>\n";
$xml .= "   <Addresses/>\n";
$xml .= "   <Receivers/>\n";
$xml .= "   <User>\n";
$xml .= "    <FirstName>X</FirstName>\n";
$xml .= "    <LastName>$rsocial</LastName>\n";
$xml .= "    <DocId>DNI</DocId>\n";
$xml .= "    <DocNo></DocNo>\n";
$xml .= "    <Email></Email>\n";
$xml .= "    <CourtTitleId/>\n";
$xml .= "    <OccupationId/>\n";
$xml .= "    <PhoneNo/>\n";
$xml .= "    <MobileNo/>\n";
$xml .= "    <FaxNo/>\n";
$xml .= "    <BirthDay/>\n";
$xml .= "    <CountryId/>\n";
$xml .= "    <AddToEmailList/>\n";
$xml .= "   </User>\n";
$xml .= "  </XPU_PayOrder>\n";
$xml .= " </Body>\n";
$xml .= "</XPU_ExternalEnvelope>\n";

# Busco el Key y el AppId de acuerdo a la interfaz
//error_log($xml,0);
#error_log("ambito: $if",0);

$if = isset($if) ? $if : 'red';
if (($if == 'hola') || ($if == 'red')) {
	$conn = pg_connect("host=localhost dbname=ra_cuenta user=site_cuenta password=cuenta*111");
	$query = "SELECT valor FROM config where clave = ";
	if ($res = pg_query($conn, $query . "'PU_Key_" . $if . "'")) {
		$row = pg_fetch_object($res);
		$key = $row->valor;
		pg_free_result($res);

		if ($res = pg_query($conn, $query . "'PU_AppId_" . $if . "'")) {
			$row = pg_fetch_object($res);
			$appId = $row->valor;
			pg_free_result($res);

			#error_log($key." -|- ".$appId,0);
			#if (stristr($trans_id, "prueba")):
			#	include ("clave.staging.php");
			#	$xx->set_key($Key_staging);
			#	$xx->set_appid($AppId_staging);
			#else:
			#	$xx->set_key($Key);
			#	$xx->set_appid($AppId);
			#endif;
			
			$po = new PayOrder;
			$po->set_username($trans_id);
			$po->set_appid($appId);
			$po->set_key($key);
			$po->set_xml($xml);
            $po->set_ticketid($ticketid);
			# echo "User = $trans_id; Key = $key; AppId = $appId";

#print "Aca estoy: $appId <--> $key<br>";

			echo $po->get_html();

			#$dbconn = mysql_connect("localhost", "web_user", "mondiola");
			#mysql_select_db("pago_universal", $dbconn);
			#$rs = mysql_query("INSERT INTO transaction_log (trans_id, valor, status, xml, remote_addr) VALUES ('$trans_id', $total, 'ENVIADO', '$xml', '$REMOTE_ADDR')");
		} else {
			# TODO: Avisar que no puedo encontrar el AppId
		}
	} else {
		# TODO: Avisar que no pude obtener el Key
	}

	pg_close($conn);
} else {
	# TODO: Avisar que la interfaz no es valida
}
?>

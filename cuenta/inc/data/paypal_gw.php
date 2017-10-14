<?php

class paypal{
	
	// Datawarehouse information
	
        //var $host = "localhost";
        var $host = "db-mipanel.alternativa.com.ar";
        
        var $port = "5432";
        var $db = "ra_cuenta";
        var $user = "site_cuenta";
        var $pass = "cuenta*111";

        var $paymentType = "Sale";
        var $page_style;
        var $paymentAmount;
        var $currencyCodeType = "USD";
        var $returnURL;
        var $cancelURL;

        var $API_USERNAME = "paypal_lat_api1.latinatel.net";
        var $API_PASSWORD = "GJHQT43GGPSG52JF";
        var $API_SIGNATURE = "ARRK8MGi7ZYrp6KaKv-Lt-cOyB.eA3DLV0tDq1NTWSivOVqP3HOc0m6s";
        var $API_ENDPOINT = "https://api-3t.paypal.com/nvp";
        var $PAYPAL_URL = "https://www.paypal.com/webscr&cmd=_express-checkout&token=";
        var $VERSION = "3.0";
	
	var $Idcliente;
	var $Origen;
	var $Data;
	
	var $TransactionResult;
	var $TransactionID;
	
	var $Token;
	var $TransactionDetails; // Array para guardar los resultados de la transaccion
	var $FinalizeResult; // Array que guarda los datos en caso de error

	function paypal($paymentAmount = NULL, $returnURL = NULL, $cancelURL = NULL, $page_style = NULL, $idcliente = NULL, $origen = NULL, $data = NULL){

		$this->paymentAmount = $paymentAmount;
		if ($paymentAmount != NULL){
			$_SESSION["PP_PAYMENTAMOUNT"] = $paymentAmount;
		}
		if ($page_style != NULL){
			$_SESSION["page_style"] = $page_style;
		}
		if ($idcliente != NULL){
			$_SESSION["idcliente"] = $idcliente;
		}
		if ($origen != NULL){
			$_SESSION["origen"] = $origen;
		}
		if ($data != NULL){
			$_SESSION["data"] = $data;
		}
		if ($_SESSION['page_style'] != NULL) $this->page_style = $_SESSION['page_style'];
		if ($_SESSION['paymentType'] != NULL) $this->paymentType = $_SESSION['paymentType'];
		if ($_SESSION['currencyCodeType'] != NULL) $this->currencyCodeType = $_SESSION['currencyCodeType'];
		if ($_SESSION['idcliente'] != NULL) $this->Idcliente = $_SESSION['idcliente'];
		if ($_SESSION['origen'] != NULL) $this->Origen = $_SESSION['origen'];
		if ($_SESSION['data'] != NULL) $this->Data = $_SESSION['data'];	
		$this->TransactionDetails = $_SESSION['TransactionDetails'];
		
		$this->returnURL = $returnURL;
		$this->cancelURL = $cancelURL;
	}
	
	// Devuelve los valores, sirve para saber como estan seteados
	function getValues(){
		return $this;
	}
	
	function finalizeTransaction(){
		$token =urlencode( $this->Token );
		$paymentAmount =urlencode ( $this->TransactionDetails["PP_PAYMENTAMOUNT"] );
		$paymentType = urlencode($this->paymentType);
		$currCodeType = urlencode($this->currencyCodeType);
		$payerID = urlencode($this->TransactionDetails['PAYERID']);
		$serverName = urlencode($_SERVER['SERVER_NAME']);

		$nvpstr='&TOKEN='.$token.'&PAYERID='.$payerID.'&PAYMENTACTION='.$paymentType.'&AMT='.$paymentAmount.'&CURRENCYCODE='.$currCodeType.'&IPADDRESS='.$serverName ;

		$resArray=paypal::hash_call("DoExpressCheckoutPayment",$nvpstr);
		$ack = strtoupper($resArray["ACK"]);
		if($ack=="SUCCESS"){
			$this->TransactionResult = "OK";
			$this->TransactionID = $resArray["TRANSACTIONID"];
			return true;
		}else{
			$this->TransactionResult = "KO";
			$this->FinalizeResult = $resArray;

/* DEBUG
echo "<pre>";
echo "<br><br><hr><h2>ERROR EN LA TRANSACCION</h2><br><br>Resultado:<br>";
print_r($resArray);
echo "</pre>";
*/

			return false;
		}
	}
	
	function getErrorMessage(){
		return $this->FinalizeResult['L_LONGMESSAGE0'];
	}
	
	// Crea el pedido y redirecciona el browser
	function setExpressCheckout(){
		$nvpStr = "";
		$nvpStr .= "&Amt=". $this->paymentAmount;
		$nvpStr .= "&PAYMENTACTION=".$this->paymentType;
		$nvpStr .= "&ReturnUrl=".urlencode($this->returnURL);
		$nvpStr .= "&CANCELURL=".urlencode($this->cancelURL);
		$nvpStr .= "&CURRENCYCODE=".$this->currencyCodeType;
		$nvpStr .= "&PAGESTYLE=".$this->page_style;
		
		$methodName = "SetExpressCheckout";
	
		$result = paypal::hash_call($methodName, $nvpStr);

		$token = urldecode($result["TOKEN"]);
		$payPalURL = $this->PAYPAL_URL.$token;
		
		$_SESSION['paymentType'] = $this->paymentType;
		$_SESSION['currencyCodeType'] = $this->currencyCodeType;
		

		header("Location: ".$payPalURL);
	}
	
	// Devuelve los resultados de la transaccion
	function getCheckoutResult(){
		return $this->TransactionDetails;
	}
	
	// Devuelve un array con las transacciones del usuario
	function getUserTransactions(){
		$query = "SELECT * FROM paypal WHERE \"PAYERID\" = '". $this->TransactionDetails['PAYERID'] ."'";
		$result = pg_query(paypal::dbConn(), $query) or die(pg_last_error());
		$i = 0;
		while($row = pg_fetch_assoc($result)){
			foreach(array_keys($row) as $field ){
				$data[$i][$field] = $row[$field];
			}
			$i++;
		}
		return $data;	
	}
	
	// Devuelve true si el usuario esta verificado
	function userIsVerified(){
		if($this->TransactionDetails['PAYERSTATUS'] == "verified"){
			return true;
		}else{
			return false;
		}
	}
	
	// Devuelve la suma de las transacciones del usuario
	function userTotalAmountTransactions(){
		$query = "SELECT SUM(\"PAYMENTAMOUNT\") as \"total_amount\" FROM paypal WHERE \"PAYERID\" = '". $this->TransactionDetails['PAYERID'] ."'";
		$result = pg_query(paypal::dbConn(), $query) or die(pg_last_error());
		$row = pg_fetch_assoc($result);
		return (float)($row["total_amount"]);
	}
	
	// Loguea la transacciones en el db
	function logTransaction(){
		$query = "INSERT INTO paypal (\"TIMESTAMP\", \"STATUS\", \"DATA\", \"EMAIL\", \"PAYERID\", \"PAYERSTATUS\", \"FIRSTNAME\", \"LASTNAME\", \"TRANSACTIONID\", 
					 \"COUNTRYCODE\", \"SHIPTONAME\", \"SHIPTOSTREET\", \"SHIPTOCITY\", \"SHIPTOSTATE\",
					  \"SHIPTOCOUNTRYCODE\", \"SHIPTOCOUNTRYNAME\",	\"SHIPTOZIP\", \"ADDRESSSTATUS\", \"IDCLIENTE\", \"ORIGEN\", \"PAYMENTAMOUNT\") VALUES 
					  (". time() .", 
					 '".    pg_escape_string($this->TransactionResult) ."',  
					 '".    pg_escape_string($this->Data) ."',  
					 '".    pg_escape_string($this->TransactionDetails['EMAIL']) ."', 
					'". pg_escape_string($this->TransactionDetails['PAYERID']) ."',
					'". pg_escape_string($this->TransactionDetails['PAYERSTATUS']) ."',
					'". pg_escape_string($this->TransactionDetails['FIRSTNAME']) ."',
					'". pg_escape_string($this->TransactionDetails['LASTNAME']) ."',
					'". pg_escape_string($this->TransactionID) ."',
					'". pg_escape_string($this->TransactionDetails['COUNTRYCODE']) ."',
					'". pg_escape_string($this->TransactionDetails['SHIPTONAME']) ."',
					'". pg_escape_string($this->TransactionDetails['SHIPTOSTREET']) ."',
					'". pg_escape_string($this->TransactionDetails['SHIPTOCITY']) ."',
					'". pg_escape_string($this->TransactionDetails['SHIPTOSTATE']) ."',
					'". pg_escape_string($this->TransactionDetails['SHIPTOCOUNTRYCODE']) ."',
					'". pg_escape_string($this->TransactionDetails['SHIPTOCOUNTRYNAME']) ."',
					'". pg_escape_string($this->TransactionDetails['SHIPTOZIP']) ."',
					'". pg_escape_string($this->TransactionDetails['ADDRESSSTATUS']) ."',
					'". pg_escape_string($this->Idcliente) ."',
					'". pg_escape_string($this->Origen) ."',
					". (float)($this->TransactionDetails["PP_PAYMENTAMOUNT"]) .")";
		if(pg_query(paypal::dbConn(), $query)){
			return true;
		}else{
			return false;
		}
	}
	
	function mailPayment($address){
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "From: ". $address ."\r\n";											
		$html = "";
		$html .= "<b>Este mail fue enviado porque se produjo un error al conectarse con la base de datos</b><br><br>";
		$html .= "Fecha: ". date("h:i:s d/m/Y") . " (timestamp: ". time() .")<br><br>";
		$html .= "STATUS: " . $this->TransactionResult ."<br>";
		$html .= "DATA: " . $this->Data ."<br>";
		$html .= "EMAIL: " . $this->TransactionDetails['EMAIL'] ."<br>";
		$html .= "PAYERID: " . $this->TransactionDetails['PAYERID'] ."<br>";
		$html .= "PAYERSTATUS: " . $this->TransactionDetails['PAYERSTATUS'] ."<br>";
		$html .= "FIRSTNAME: " . $this->TransactionDetails['FIRSTNAME'] ."<br>";
		$html .= "LASTNAME: " . $this->TransactionDetails['LASTNAME'] ."<br>";
		$html .= "TRANSACTIONID: " . $this->TransactionID ."<br>";
		$html .= "COUNTRYCODE: " . $this->TransactionDetails['COUNTRYCODE'] ."<br>";
		$html .= "SHIPTONAME: " . $this->TransactionDetails['SHIPTONAME'] ."<br>";
		$html .= "SHIPTOSTREET: " . $this->TransactionDetails['SHIPTOSTREET'] ."<br>";
		$html .= "SHIPTOCITY: " . $this->TransactionDetails['SHIPTOCITY'] ."<br>";
		$html .= "SHIPTOSTATE: " . $this->TransactionDetails['SHIPTOSTATE'] ."<br>";
		$html .= "SHIPTOCOUNTRYCODE: " . $this->TransactionDetails['SHIPTOCOUNTRYCODE'] ."<br>";
		$html .= "SHIPTOCOUNTRYNAME: " . $this->TransactionDetails['SHIPTOCOUNTRYNAME'] ."<br>";
		$html .= "SHIPTOZIP: " . $this->TransactionDetails['SHIPTOZIP'] ."<br>";
		$html .= "ADDRESSSTATUS: " . $this->TransactionDetails['ADDRESSSTATUS'] ."<br>";
		$html .= "IDCLIENTE: " . $this->Idcliente ."<br>";
		$html .= "ORIGEN: " . $this->Origen ."<br>";
		$html .= "PAYMENTAMOUNT: " . $this->TransactionDetails['PP_PAYMENTAMOUNT'] ."<br>";
		return mail($address ,"Paypal - Pago efectuado en MI PANEL",$html,$headers); 
	}
	
	function setToken($token){
		$this->Token = $token;
		$nvpstr="&TOKEN=".$this->Token;
		$this->TransactionDetails = paypal::hash_call("GetExpressCheckoutDetails",$nvpstr);
		$this->TransactionDetails["PP_PAYMENTAMOUNT"] = $_SESSION["PP_PAYMENTAMOUNT"];
		$_SESSION['TransactionDetails'] = $this->TransactionDetails;
		return;
	}
		
	function dbConn(){
		$conn = pg_connect("host=". $this->host ." port=" . $this->port ." dbname=". $this->db ." user=". $this->user ." password=". $this->pass);
		return $conn;
	}	
		
	function hash_call($methodName,$nvpStr){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$this->API_ENDPOINT);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);

		$nvpreq="METHOD=".urlencode($methodName)."&VERSION=".urlencode($this->VERSION)."&PWD=".urlencode($this->API_PASSWORD)."&USER=".urlencode($this->API_USERNAME)."&SIGNATURE=".urlencode($this->API_SIGNATURE).$nvpStr;

		curl_setopt($ch,CURLOPT_POSTFIELDS,$nvpreq);

		$response = curl_exec($ch);

		$nvpResArray=paypal::deformatNVP($response);
		$nvpReqArray=paypal::deformatNVP($nvpreq);
		$_SESSION['nvpReqArray']=$nvpReqArray;

		if (curl_errno($ch)) {
			  $_SESSION['curl_error_no']=curl_errno($ch) ;
			  $_SESSION['curl_error_msg']=curl_error($ch);
			  echo curl_error($ch) ."<br>";
			  exit;
		 } else {
				curl_close($ch);
		 }

		return $nvpResArray;
	}
	

	function deformatNVP($nvpstr){

		$intial=0;
	 	$nvpArray = array();
	

		while(strlen($nvpstr)){
			$keypos= strpos($nvpstr,'=');
			$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);
	
			$keyval=substr($nvpstr,$intial,$keypos);
			$valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
			$nvpArray[urldecode($keyval)] =urldecode( $valval);
			$nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));
	     }
		return $nvpArray;
	}
	
}

?>

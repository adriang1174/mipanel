<?php


define('DEBUG', true);

if(DEBUG){ 
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);	
}else{ 
	ini_set('display_errors', 0);
	ini_set('error_reporting', 0);
}

require('inc/conf.php');


// ADODB
require_once('inc/adodb/adodb-exceptions.inc.php');
require_once('inc/adodb/adodb.inc.php');
$db = ADONewConnection('mssql');
$db->Connect(MSSQL_DB_SERVER, MSSQL_DB_USERNAME, MSSQL_DB_PASSWORD, MSSQL_DB_NAME);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;



// Smarty
require('inc/smarty/Smarty.class.php');
$smarty = new Smarty();
$smarty->error_reporting = E_ALL & ~ E_NOTICE; //Smarty2 lo traia por defecto



if(!empty($_POST)){
    if(isset($_POST['requests']) && count($_POST['requests']) > 0){
        $agregados = 0;
        foreach($_POST['requests'] as $r){
            $res = $db->execute("UPDATE cobranzas_Litle SET estado_presentacion = 1 WHERE id = ?", array($r));
            if(!$res){
                echo "ERROR";
                exit;
            }else{
                $agregados++;
            }
        }
        $smarty->assign('agregados', $agregados);
        /*
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        */
    }
    
}




if(isset($_GET['procesados']) && $_GET['procesados'] == 1){
    $res = $db->getAll("SELECT TOP 1000 *, CONVERT(CHAR(10), fecha_carga, 103) as f_fecha_carga FROM cobranzas_Litle WHERE estado_presentacion = 1  ORDER BY fecha_carga DESC");

    $smarty->assign('res', $res);
    
    $smarty->display('listado_procesados.tpl');
}else{
    $res = $db->getAll("SELECT TOP 1000 *, CONVERT(CHAR(10), fecha_carga, 103) as f_fecha_carga FROM cobranzas_Litle WHERE estado_presentacion = 0 ORDER BY fecha_carga");


    $smarty->assign('res', $res);

    $smarty->display('listado.tpl');
}



/*
echo "<pre>";
print_r($res);
*/

/*
require_once ('inc/litle/LitleOnline.php');  


$token_info = array(
                'orderId'=>'12344',
                'id'=> '456',
                'accountNumber'=>'1233456789103123');

$initilaize = &new LitleOnlineRequest();
$tokenResponse = $initilaize->registerTokenRequest($token_info);

#display results
echo ("Response: " . (XmlParser::getNode($tokenResponse ,'response')) . "<br>");
echo ("Message: " . XmlParser::getNode($tokenResponse ,'message') . "<br>");
echo ("Litle Transaction ID: " . XmlParser::getNode($tokenResponse ,'litleTxnId'). "<br>");
echo ("Litle Token: " . XmlParser::getNode($tokenResponse ,'litleToken'));

*/

/*

$sale_info = array(
         'orderId' => '1',
                      'id'=> '456',
'amount' => '10010',
'orderSource'=>'ecommerce',
'billToAddress'=>array(
'name' => 'John Smith',
'addressLine1' => '1 Main St.',
'city' => 'Burlington',
'state' => 'MA',
'zip' => '01803-3747',
'country' => 'US'),
'card'=>array(
'number' =>'4100280190123000',
'expDate' => '0112',
'cardValidationNum' => '349',
'type' => 'MC')
);

$initilaize = new LitleOnlineRequest();
$saleResponse = $initilaize->saleRequest($sale_info);

var_dump($saleResponse);


#display results
echo ("Response: " . (XmlParser::getNode($saleResponse,'response')) . "<br>");
echo ("Message: " . XmlParser::getNode($saleResponse,'message') . "<br>");
echo ("Litle Transaction ID: " . XmlParser::getNode($saleResponse,'litleTxnId'));
echo ("Litle Token: " . XmlParser::getNode($saleResponse ,'litleToken'));

*/




?>

<?php

date_default_timezone_set('America/Buenos_Aires');
define('INCLUDE_PATH', '/home/httpd/zonasegura.grupoalternativa.com/cuenta/inc/');
require(INCLUDE_PATH.'misc.php');
require(INCLUDE_PATH.'data/payment_gateways.php');
//require('../../inc/data/user.php');

ini_set('display_errors', 0);
	ini_set('error_reporting', E_ALL);

$user_id = $argv[1];
$owner = $argv[2];
$fechemision =  $argv[3];
//Borramos si existe el pdf viejo
//unlink('/home/httpd/zonasegura.grupoalternativa.com/cuenta/scripts/pdf/'.$user_id.'.pdf');

global $pdf_owner_id;

$pdf_owner_id = $owner;

$user = new user( $user_id );
$tickets = $user->get_ticket_list(false, 0, 1, $is_last, true, $total);
$ticketid = $tickets[0]->ticketid;

list($tipodoc, $sucdoc, $numdoc) = explode('-', $ticketid);

$path_efacturas = INCLUDE_PATH . 'efacturas/';

require($path_efacturas.'efactura.class.php');

if($owner == 1 || $owner == 2){
	$nombre_owner = 'red';
}elseif($owner == 3){
	$nombre_owner = 'hola';
}elseif($owner == 4 || $owner == 5 || $owner == 6){
	$nombre_owner = 'latinatel';
}elseif($owner == 7 ){
	$nombre_owner = 'telephone2';
}elseif($owner == 8){
	$nombre_owner = 't2';
	
}


$_global_owner = $nombre_owner;
$year  = substr($fechemision,0,4);
$month = substr($fechemision,5,2);
global $script_owner, $script_owner_id;
$script_owner = true;
$script_owner_id = $owner;
$real_ticket = $month ? $user->get_ticket( null, $month, $year) : $user->get_ticket( $ticketid, null);


$efactura = new Efactura($path_efacturas, $nombre_owner, $real_ticket);

$desde = '01/01/1990';
$hasta_tmp = explode("/", $real_ticket->date); // Tiene que estar en mm/dd/YYYY
$hasta = $hasta_tmp[1] ."/" .$hasta_tmp[0] ."/". $hasta_tmp[2];

$ccd = new ca_cc($user_id, $desde, $hasta);

$saldo = $ccd->cc_get_saldo_final($desde, $hasta);

$saldo = $saldo - $real_ticket->itotal;

$efactura->saldo_a_fecha_emision = number_format(($saldo + $real_ticket->itotal), 2, '.', '');


$myticket = $user->get_ticket( $ticketid);

list($tipodoc, $sucdoc, $numdoc) = explode('-', $ticketid);
$barcode_total = p_gateways_pago_facil::static_get_barcode_number($ticketid, $tipodoc, $sucdoc, $numdoc, $myticket, $real_ticket->itotal, $user_id);


$efactura->barcode_total = $barcode_total;

				
$barcode_saldo = p_gateways_pago_facil::static_get_barcode_number($ticketid, $tipodoc, $sucdoc, $numdoc, $myticket, $efactura->saldo_a_fecha_emision, $user_id);

$efactura->barcode_saldo = $barcode_saldo;



global $dbh;
//$efactura->frase_pie = $dbh->getOne("SELECT frase FROM fact_frases WHERE ownerid = ". $owner ." AND mes = ". date("m") ." AND anio = ". date("Y"));


$efactura->frase_pie = $dbh->getAll("SELECT Leyenda FROM ventascabwebleyendas WHERE va_fcomp = ? AND va_suc = ? AND va_fnro = ? AND va_clnro = ? ORDER BY id",
													array(
													$tipodoc, $sucdoc, $numdoc, $user_id
													));

//var_dump($efactura->frase_pie);

$res = $efactura->output(false, '/home/httpd/zonasegura.grupoalternativa.com/cuenta/scripts/pdf');

echo $res;


?>

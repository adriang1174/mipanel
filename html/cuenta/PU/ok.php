<?php
$ret = include ('./crypt_functions.php3');
$ret = include ('./clave.php');

 $tagActivo = "";
 $trans_id_RA = "";
 $trans_id_PU = "";
 $$paymentMethod = "";

 $xml_parser = xml_parser_create();
 xml_set_element_handler($xml_parser, "startElement", "endElement");
 xml_set_character_data_handler($xml_parser, "dataHandler");
 xml_parse($xml_parser, CRY_Decrypt($XML, $Key), true);
 xml_parser_free($xml_parser);



$xml_pu = CRY_Decrypt($XML, $Key);
$dbconn = mysql_connect("localhost", "root", "rojocapo");
mysql_select_db("pago_universal", $dbconn);
$rs = mysql_query("INSERT INTO transaction_log (trans_id, trans_id_pu, paymentmethod, status, xml) VALUES ('$trans_id_RA', '$trans_id_PU', '$paymentMethod', 'FINALIZADO', '$xml_pu')");


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Respuesta de PU</title>
<style>
TABLE.conBorde
    {
    font-size:10pt;
    font-family:Verdana, Arial;
    BORDER-RIGHT: #003366 2px solid;
    BORDER-TOP: #003366 2px solid;
    BORDER-LEFT: #003366 2px solid;
    BORDER-BOTTOM: #003366 2px solid;
    }
BODY
    {
    background-color=white;
    }
</style>
</head>
<body>
<br><br>
<table class="conBorde" align="center" width=320>
   	<tr><td valign=middle>
                <br>&nbsp;
                <center><img src="../images/logo.gif"></center>
		<br>&nbsp;
		<p>
		  Su pago a Red Alternativa a trav&eacute;s de Pago Universal fue prosesado
		  satisfactoriamente bajo el n&uacute;mero de transacci&oacute;n de Pago Universal <b><?= $trans_id_RA?></b>.
	 	<p>
		  Puede ver este pago en Cuenta Alternativa dentro de la consulta de "Pagos OnLine".<br>
		  A partir de la acreditaci&oacute;n del mismo en las cuentas de Red Alternativa podr&aacute; verlo reflejado en su cuenta corriente.
		<p align=center>
		 <button name="cerrar" language="javascript" onClick="window.close();">Cerrar</button><br>
        </td></tr></table>
</body>
</html>


<?
function startElement($parser, $name, $attrs) {
	global $tagActivo;
	$tagActivo = $name;
//	echo "> $name<br>\n";
}

function endElement($parser, $name) {
//      echo "> $name<br>\n";
}

function dataHandler($parser, $data) {
	global $tagActivo, $trans_id_RA, $trans_id_PU, $paymentMethod;
	switch ($tagActivo) {
		case "ID": 
//			echo "<b>ID: $data</b><br>";
			$trans_id_RA = $data;
			break;
                case "PUID":
//                      echo "<b>PUID: $data</b><br>";
			$trans_id_PU = $data;
			break;
		case "PAYMENTMETHOD":
			$paymentMethod = $data;
			break;
	}
}
?>

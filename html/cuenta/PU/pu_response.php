<?php
$ret = include ('./crypt_functions.php3');


# Busco el Key y el AppId de acuerdo a la interfaz

$Key='';

$if = isset($_REQUEST['if']) ? $_REQUEST['if'] : 'red';
if (($if == 'hola') || ($if == 'red')) {
        $conn = pg_connect("host=localhost dbname=ra_cuenta user=site_cuenta password=cuenta*111");
        $query = "SELECT valor FROM config where clave = ";
        if ($res = pg_query($conn, $query . "'PU_Key_" . $if . "'")) {
                $row = pg_fetch_object($res);
                $Key = $row->valor;
                pg_free_result($res);
	}
}


$tagActivo = "";
$trans_id_RA = "";
$trans_id_PU = "";
$paymentMethod = "";

$xml_parser = xml_parser_create();
xml_set_element_handler($xml_parser, "startElement", "endElement");
xml_set_character_data_handler($xml_parser, "dataHandler");
xml_parse($xml_parser, CRY_Decrypt($XML, $Key), true);
xml_parser_free($xml_parser);

$xml_pu = CRY_Decrypt($XML, $Key);

#echo $xml_pu."<--- xml_pu<br>";

$dbconn = @mysql_connect("localhost", "root", "rojocapo");
@mysql_select_db("pago_universal", $dbconn);
$rs = @mysql_query("INSERT INTO transaction_log (trans_id, trans_id_pu, paymentmethod, status, xml) VALUES ('$trans_id_RA', '$trans_id_PU', '$paymentMethod', 'FINALIZADO', '$xml_pu')");

$if = isset($if) ? $if : 'red';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Respuesta de PU</title>
<style>
	TABLE.conBorde {
		font-size:10pt;
		font-family:Verdana, Arial;
		BORDER-RIGHT: #003366 2px solid;
		BORDER-TOP: #003366 2px solid;
		BORDER-LEFT: #003366 2px solid;
		BORDER-BOTTOM: #003366 2px solid;
	}

	body {
		font-size:10pt;
		font-family:Verdana, Arial;
		background-color=white;
	}
</style>
</head>
<body>
<br><br>
<table class="conBorde" align="center" width=320>
<tr>
	<td valign=middle>
                <br>&nbsp;
                <center><img src="../../img/<?= $if ?>/logo.gif"></center>

<?if ($_GET['acc'] == 'ok'): ?>
		<p> 
Su pago a trav&eacute;s de Pago Universal fue procesado satisfactoriamente.<br /><br />
A partir de las pr&oacute;ximas 48 horas h&aacute;biles, usted podr&aacute; verlo reflejado en su cuenta corriente.<br />
</p>

<?else: ?>
<center><p>Error al realizar el pago.<br><br> Por favor, cierre la ventana e intentelo nuevamente.</p></center>
<?endif;?>
<p align=center>
<button name="cerrar" language="javascript" onClick="window.opener.location.href='../home.ca';window.close();">Cerrar</button> 

</p><br>
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

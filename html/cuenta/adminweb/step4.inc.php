<?php
require_once("cn.inc.php");


$SQLCmd = "UPDATE owner SET \"idTemplate\" = " . $_SESSION["currentIdTemplate"] . " "
	. "WHERE owner.\"owner_id\" = " . $_SESSION["currentIdOwner"] . ";";
$resUpd = pg_query($conn, $SQLCmd);
if (!$resUpd) die("Error al procesar la consulta: " . $SQLCmd);

$listaElemAdministrables = $_SESSION["listaElemAdministrables"];
foreach($listaElemAdministrables as $rcElem) {

	$SQLCmd = "UPDATE admin_valores SET \"valor\" = '" . addslashes($rcElem["valor"]) . "' "
		. "WHERE admin_valores.\"idValor\" = " . $rcElem["idValor"] . ";";
	
	$resUpd = pg_query($conn, $SQLCmd);
	if (!$resUpd) die("Error al procesar la consulta: " . $SQLCmd);
	
}
?>
<form id="formulario" action="index.php" method="post">
<input type="hidden" id="step" name="step" value="5" />
<br /><br />
<div align="center">
<b>Los cambios fueron guardados con exito</b>
</div>
<br /><br /><br />

<input type="submit" value="Volver al primer paso" />

</form>
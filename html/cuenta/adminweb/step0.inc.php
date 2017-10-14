<?php
//configuracion
$defaultIdOwner = -1;

//inclusion de la conexion
require_once("cn.inc.php");

$SQLQry = "SELECT * FROM owner ORDER BY nombre;";
$res = pg_query($conn, $SQLQry);
if (!$res) die("Error al procesar la consulta: " . $SQLQry);
?><form  action="index.php" method="post">
<input type="hidden" name="step" value="1" />
<b>Paso 1: Seleccionar owner:</b><br /><br /><?php
while ($row = pg_fetch_assoc($res)) {
	?><input name="idOwner" type="radio" value="<?php echo $row['owner_id']; ?>" <?php 
	if ($row['owner_id'] == $defaultIdOwner) echo 'checked="checked"'; ?> onClick="setCmdContDisabledStatus(false);" onChange="setCmdContDisabledStatus(false);" />
	<?php echo stripslashes($row['nombre']); ?><br/ ><?php 
}
?><br />
<input type="submit" value="Continuar" id="cmdContinuar">
</form>
<script type="text/javascript">
function setCmdContDisabledStatus(valor) {
	document.getElementById('cmdContinuar').disabled = valor;
}
setCmdContDisabledStatus(true);
</script> 
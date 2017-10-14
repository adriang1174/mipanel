<?php
require_once("cn.inc.php");

//nos aseguramos que las varaibles de session esten limpias;
unset($_SESSION["listaElemAdministrables"]);

//determinamos el idTemplateActual para el idOwner especificado
$SQLQry = "SELECT * FROM owner WHERE \"owner_id\" = " . $_POST["idOwner"] . " LIMIT 1;";
$res = pg_query($conn, $SQLQry);
if (!$res) die("Error al procesar la consulta: " . $SQLQry);
$rcOnwer = pg_fetch_assoc($res);

$_SESSION["currentIdOwner"] = $_POST["idOwner"];
$_SESSION["currentOwnerFolder"] = $rcOnwer["carpeta"];

//obtengo el la lista de templates disponibles
$SQLQry = "SELECT * FROM admin_templates ORDER BY denom;";
$res = pg_query($conn, $SQLQry);
if (!$res) die("Error al procesar la consulta: " . $SQLQry);
?>   
<form id="formulario" method="post" action="index.php">
<input type="hidden" id="step" name="step" value="2" />
<input type="hidden" name="idOwner" value="<?php echo $_POST["idOwner"]; ?>" />
<b>Paso 2: Seleccionar template:</b><br /><br />
<table>
<?php
while ($row = pg_fetch_assoc($res)) {
	?>
    <tr><td>
	<input name="idTemplate" type="radio" value="<?php echo $row["idTemplate"]; ?>" <?php 
	if ($row['idTemplate'] == $rcOnwer["idTemplate"]) echo 'checked="checked"'; ?> />
	<?php echo stripslashes($row['denom']); 
	if ($rcOnwer["idTemplate"] == $row["idTemplate"]) {
		echo " (selección actual)";
	}
	//if (!is_null($row["imagen"])) echo " : img preview = " . $row["imagen"];
	?>
    </td><td>
    <img src="vistasPrevias/thumbnails/<?php echo $row["fileName"]; ?>.gif" alt="preview" width="195" height="156" />
    </td>
    </tr>
    <?php
}
?>
</table>
<br />
<input type="button" value="Cancelar edici&oacute;n actual" onClick="javascript:restart();" />
<input type="button" value="Volver al paso anterior" onClick="javascript:goBack();" />
<input type="submit" value="Continuar" />
</form>
<?php

$listaElemAdministrables = $_SESSION["listaElemAdministrables"];
$listaElemAdministrablesUpd = array();
foreach($listaElemAdministrables as $rcElem) {
	if (get_magic_quotes_gpc()) {
		$rcElem["valor"] = stripslashes($_POST["textarea_" . $rcElem["idValor"]]);
	} else {
		$rcElem["valor"] = $_POST["textarea_" . $rcElem["idValor"]];
	}
	$listaElemAdministrablesUpd[$rcElem["HTMLId"]] = $rcElem;
}
$_SESSION["listaElemAdministrables"] = $listaElemAdministrablesUpd;
?>
<form id="formulario" method="post">
<input type="hidden" id="step" name="step" value="4" />
<input type="hidden" name="idOwner" value="<?php echo $_POST["idOwner"]; ?>" />
<input type="hidden" name="idTemplate" value="<?php echo $_POST["idTemplate"]; ?>" />
<b>Paso 4: Vista previa:</b><br />

<iframe src="vistasPrevias/<?php echo $_SESSION["currentTemplateFileName"]; ?>.php?idOwner=<?php echo $_POST["idOwner"]; ?>&idTemplate=<?php echo $_POST["idTemplate"]; ?>" width="800" height="600" scrolling="auto" frameborder="1" transparency>
<p>Texto alternativo para navegadores que no aceptan iframes.</p>
</iframe>
<input type="button" value="Cancelar edici&oacute;n actual" onClick="javascript:restart();" />
<input type="button" value="Volver al paso anterior" onClick="javascript:goBack();" />
<input type="submit" value="Continuar" />
</form>
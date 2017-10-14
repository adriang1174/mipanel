<?php

require_once("cn.inc.php");

if (isset($_POST["idOwner"])) {
	$idOwner = $_POST["idOwner"];
} else {
	$idOwner = $_GET["idOwner"];
}



//recupero los datos del owner
$SQLQry = "SELECT * FROM owner WHERE \"owner_id\" = " . $idOwner . " LIMIT 1;";
$res = pg_query($conn, $SQLQry);
if (!$res) die("Error al procesar la consulta: " . $SQLQry);
$rcOnwer = pg_fetch_assoc($res);

if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {
	
	$pathDestino = $basePath . $rcOnwer["carpeta"] . $barraSep 
		. "img" . $barraSep . "admin" . $barraSep .$_FILES['archivo']['name'];
	
	//echo "verif. permisos sobre path destino: " . $pathDestino . "<hr />";
	
	$subio = move_uploaded_file($_FILES['archivo']['tmp_name'], $pathDestino);
	if(!$subio) {
		echo "El archivo no cumple con las reglas establecidas<br />";
		echo "path destino: " . $pathDestino . "<br />";
	}
	
} else {

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
<b>Owner: <?php echo $rcOnwer["nombre"]; ?></b><hr />
<form action="popup.admImg.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
  Subir imagen: <input type="file" name="archivo" id="archivo" />
  <input type="submit" name="cmd" id="cmd" value="agregar" />
  <input type="hidden" name="idOwner" id="idOwner" value="<?php echo $idOwner; ?>" />
</form>
<hr />
<div id="capaDesplazable">
<table style="border: 1px solid black" cellpadding="0" cellspacing="0">
<tr>
<th colspan="2">Listado de imagenes disponibles para el owner</th>
</tr>

<tr><td colspan="2">&nbsp;</td></tr>
<?php
$pathToScan = $basePath . $rcOnwer["carpeta"] . $barraSep . "img" . $barraSep . "admin" . $barraSep . "*";
foreach (glob($pathToScan) as $nombre_archivo) {
    ?>
	<tr >
    <td align="center" style="border-bottom: 1px solid black; padding: 15px 12px;">
		<img width="110" src="<?php echo $baseURL . $rcOnwer["carpeta"] . "/img/admin/" . basename($nombre_archivo); ?>" /><br />
		<?php echo basename($nombre_archivo); ?></td>
    <td style="border-bottom: 1px solid black; margin-bottom: 5px;"><?php echo $baseURL . $rcOnwer["carpeta"] . "/img/admin/" . basename($nombre_archivo); ?><br/></td>
    </tr>
<?php
}
?>
</table>
</div>
</body>
</html>

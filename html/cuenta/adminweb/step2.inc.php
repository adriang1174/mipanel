<?php
require_once("cn.inc.php");

if (isset($_SESSION["listaElemAdministrables"])) {

	$listaElemAdministrables = $_SESSION["listaElemAdministrables"];

} else {
	
	$SQLQry = "SELECT * FROM admin_templates WHERE \"idTemplate\" = " . $_POST["idTemplate"] . ";";
	$res = pg_query($conn, $SQLQry);
	if (!$res) die("Error al procesar la consulta: " . $SQLQry);
	$row = pg_fetch_assoc($res);
	
	$_SESSION["currentIdTemplate"] = $_POST["idTemplate"];
	$_SESSION["currentTemplateFileName"] = $row["fileName"];
	
	$SQLQry = "SELECT 
		admin_valores.\"idValor\",
		admin_valores.\"valor\",
		admin_elementos.\"denom\",
		admin_elementos.\"HTMLId\"
	FROM
		public.admin_valores 
		INNER JOIN admin_elementos ON (admin_valores.\"idElemento\" = admin_elementos.\"idElemento\")
	WHERE
		(admin_valores.\"idOwner\" = " . $_POST["idOwner"] . ") AND 
		(admin_elementos.\"idTemplate\" = " . $_POST["idTemplate"] . ") 
	ORDER BY admin_elementos.\"ordenVisualizacion\";";
	
	$res = pg_query($conn, $SQLQry);
	if (!$res) die("Error al procesar la consulta: " . $SQLQry);
	$listaElemAdministrables = array();
	while ($row = pg_fetch_assoc($res)) {
		$rcElem = array();
		$rcElem["idValor"] = $row["idValor"];
		$rcElem["valor"] = stripslashes($row["valor"]);
		$rcElem["denom"] = $row["denom"];
		$rcElem["HTMLId"] = $row["HTMLId"];
		$listaElemAdministrables[$row["HTMLId"]] = $rcElem;
	}
	$_SESSION["listaElemAdministrables"] = $listaElemAdministrables;
	
	$res = pg_query($conn, $SQLQry);
}

?>

<script type="text/javascript">
tinyMCE.init({
	// General options
	mode : "textareas",
	editor_selector : "mceEditor",
	editor_deselector : "mceNoEditor",
	forced_root_block : '',
	convert_urls : false,
	theme : "advanced",
	plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager",

	// Theme options
	theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,

	// Example content CSS (should be your site CSS)
	content_css : "css/example.css",

	// Drop lists for link/image/media/template dialogs
	template_external_list_url : "js/template_list.js",
	external_link_list_url : "js/link_list.js",
	external_image_list_url : "js/image_list.js",
	media_external_list_url : "js/media_list.js",

	// Replace values for the template plugin
	template_replace_values : {
		username : "Some User",
		staffid : "991234"
	}
});
</script>

<script type="text/javascript">
function abrir_ventana(pagina) {
	var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, 		resizable=yes, width=508, height=365, top=85, left=140";
	window.open(pagina,'administrador',opciones);
}
</script>

<form id="formulario" method="post">
<input type="hidden" id="step" name="step" value="3" />
<input type="hidden" name="idOwner" value="<?php echo $_POST["idOwner"]; ?>" />
<input type="hidden" name="idTemplate" value="<?php echo $_POST["idTemplate"]; ?>" />
<b>Paso 3: Editar template:</b> <?php echo $_SESSION["currentTemplateFileName"]; ?><br /><br />

<input type="button" name="openAdmImg" id="cmdOpenAdmImg" value="abrir admin. img." onClick="javascript:abrir_ventana('popup.admImg.php?idOwner=<?php echo $_POST["idOwner"]; ?>');" /><br /><br />

<?php 
foreach($listaElemAdministrables as $rcElem) {
	echo $rcElem["denom"]; ?><br />
    	<textarea name="textarea_<?php echo $rcElem["idValor"]; ?>" class="mceEditor"><?php 
		echo $rcElem["valor"]; ?></textarea><br /><br />
<?php
}
?>
<input type="button" value="Cancelar edici&oacute;n actual" onClick="javascript:restart();" />
<input type="button" value="Volver al paso anterior" onClick="javascript:goBack();" />
<input type="submit" value="Continuar" />
</form>
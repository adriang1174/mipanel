<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Buscar cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body>

<style type="text/css">
	* {margin:0; padding:0; outline:0; background:none; background-repeat:no-repeat; font-size:100%}
	body {font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000000; background:#FFFFFF; margin:0; padding:0;}
	div, h1, h2, h3, h4, h5, h6, form {width:100%}
	.contenedor {width:960px; margin:0 auto;}
	.contenedor div, h1, h2, h3, h4, h5, h6, form, input, select, extarea, ul, ol, li, dl, dt, dd, label, address {float:left; display:inline}

	#frm {width:960px; float:left;}
	#frm input {padding:3px; border:1px solid #CCCCCC; background:#FFFFFF; width:262px; font-family:Verdana; font-size:12px; color:#4F4F4F;}
	#frm select {padding:2px 3px; border:1px solid #CCCCCC; background:#FFFFFF; width:270px; font-family:Verdana; font-size:12px; color:#4F4F4F;}
	#frm .buscar {width:auto; color:#FFFFFF; border:1px solid #7F510F; font-weight:bold; font-size:10px; text-transform:uppercase; cursor:pointer; float:right; background:#DF8300; -moz-border-radius: 6px;
border-radius: 6px; margin:5px 0 0 0;}
	
	h1 {font-size:20px; line-height:28px; color:#FDA000; border-bottom:1px solid #FDA000; width:300px; float:left; margin:20px 0 0 330px;}
	.panel {width:270px; float:left; margin:5px 0 0 330px; background:#FDB800; padding:15px; -moz-border-radius: 0 0 6px 6px; border-radius: 0 0 6px 6px;}
	.panel div {width:270px; float:left; margin:5px 0 0 0;}
	.panel label {color:#7F510F; font-weight:bold; font-family:Verdana; font-size:11px;}
	
	.tabla {float:left; margin:30px 0 0 0;}
	.tabla a {color:#DF8300; text-decoration:underline;}
	.tabla a:hover {color:#FDA000; text-decoration:underline;}
	.tabla th {font-family:Verdana; border:0; margin:0; outline:0; font-size:12px; color:#4F4F4F; padding:4px 3px; background:#DF8300; color:#FFFFFF;}
	.tabla td {font-family:Verdana; border:0; margin:0; outline:0; font-size:11px; padding:4px 3px; color:#4F4F4F;}
	.tabla .cliente, .tabla .estado, .tabla .seleccionar {width:120px; float:left; text-align:center;}
	.tabla .owner {width:140px; float:left; text-align:center;}
	.tabla .razon {width:425px; float:left;}
	
	.blanco td {background:#FFFFFF;}
	.gris td {background:#EFEFEF;}
	
	.sesion {width:auto; float:right !important; margin-top:20px;}
	.sesion a {color:#DF8300; text-decoration:underline;}
	.sesion a:hover {color:#7F510F; text-decoration:underline;}
</style>

<div class="contenedor">
	<div class="sesion"><a href="admin_home.ca?logout=1">Cerrar sesi&oacute;n del administrador</a></div>

	<form id="frm" name="frm" action="" method="post">
	<h1>Buscar cliente:</h1>
	
	<div class="panel">
		<div><label>Palabra clave</label></div>
		<div><input type="text" name="searchbox" value="<!--{$search_text}-->"/></div>	
		<div><label>Raz&oacute;n social</label></div>
		<div><select name="owner_id">
		<option value="0">- todos -</option>
		<!--{foreach from=$owners item=owner}-->
		<option value="<!--{$owner.owner_id}-->" <!--{if $search_owner == $owner.owner_id}--> selected="selected" <!--{/if}-->><!--{$owner.nombre}--></option>
		<!--{/foreach}-->
		</select>
		</div>
		<div>
		<input type="submit" value="Buscar" class="buscar" />
		<input type="hidden" name="cliente_id" id="cliente_id" />
		</div>
	</div>	

	<div class="tabla">
	<table>
		<tr>
			<th class="cliente">Cliente ID</th>
			<th class="razon">Razon social</th>
			<th class="estado">Estado</th>
			<th class="owner">Owner</th>
			<th class="seleccionar">&nbsp;</th>
		</tr>

	<!--{foreach from=$clients item=client}-->
		<tr class="<!--{cycle values="blanco, gris"}-->">
			<td class="cliente"><!--{$client.cliente_id}--></td>
			<td class="razon"><!--{$client.rsocial}--></td>
			<td class="estado"><!--{$client.estado_cliente}--></td>
			<td class="owner"><!--{$client.owner}--></td>
			<td class="seleccionar"><a href="#" onclick="document.getElementById('cliente_id').value = '<!--{$client.cliente_id}-->'; document.getElementById('frm').submit(); ">seleccionar</a></td>
		</tr>
	<!--{/foreach}-->
	</table>
	</div>

	</form>
</div>
</body>
</html>
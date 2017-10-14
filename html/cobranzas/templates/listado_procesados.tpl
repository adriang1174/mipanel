<!doctype html>
<!--[if lt IE 7 ]> <html lang="es-ar" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="es-ar" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="es-ar" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="es-ar" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="es-ar" class="no-js"> <!--<![endif]-->
<head>
	<title>Cobranzas</title>
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="viewport" content="width=device-width,initial-scale=1">
    <script type="text/javascript" src="scripts/jquery-1.7.2.min.js"></script>
	</head>
<body>

<h3>Registros procesados <a href="index.php">(ver registros pendientes)</a></h3>

<form name="frm" action="" method="post">
<table width="100%" cellpadding="2" cellspacing="2" border="1">
    <tr>
        <th>ID</th>
        <th>ID Cliente</th>
        <th>Tipo</th>
        <th>Numero</th>
        <th>Importe</th>
        <th>fecha</th>
        <th>Litle estado</th>
        <th>Litle fecha</th>
        <th>Litle token</th>
        <th>Litle observacion</th>
        <th>Litle id</th>
        <th>Tipo</th>
    </tr>
    
    {foreach from=$res item=r}
        <tr>
            <td>{$r.id}</td>
            <td>{$r.ca_cnro}</td>
            <td>{if $r.tipo|strtoupper == 'TOKEN'} Token {else} Tarjeta de credito {/if}</td>
            <td>{if $r.tipo|strtoupper == 'TOKEN'} {$r.numero} {else}************{$r.numero|substr:12:4} {/if}</td>
            <td>{$r.importe}</td>
            <td>{$r.f_fecha_carga}</td>
            <td>{$r.litle_estado} </td>
            <td>{$r.litle_fecha} </td>
            <td>{$r.litle_token} </td>
            <td>{$r.litle_observacion} </td>
            <td>{$r.litle_id} </td>
            <td>{if $r.tipo_transac == 1}Venta{else if $r.tipo_transac == 2}Devolucion{else}Otro{/if}</td>
        </tr>
    
    {/foreach}
</table>


</form>


</body>
</html>

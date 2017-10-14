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

<h3>Registros pendientes de cobranza <a href="?procesados=1">(ver registros ya procesados)</a></h3>

<form name="frm" action="" method="post">
<table width="100%" cellpadding="2" cellspacing="2" border="1">
    <tr>
        <th>&nbsp;</th>
        <th>ID</th>
        <th>ID Cliente</th>
        <th>Tipo</th>
        <th>Numero</th>
        <th>Importe</th>
        <th>fecha</th>
        <th>Tipo</th>
    </tr>
    
    {foreach from=$res item=r}
        <tr>
            <td><input type="checkbox" name="requests[]" class="req_chk" value="{$r.id}" /></td>
            <td>{$r.id}</td>
            <td>{$r.ca_cnro}</td>
            <td>{if $r.tipo|strtolower == 'token'} Token {else} Tarjeta de credito {/if}</td>
            <td>{if $r.tipo|strtolower == 'token'} {$r.numero} {else}************{$r.numero|substr:12:4} {/if}</td>
            <td>{$r.importe}</td>
            <td>{$r.f_fecha_carga}</td>
            <td>{if $r.tipo_transac == 1}Venta{else if $r.tipo_transac == 2}Devolucion{else}Otro{/if}</td>
        </tr>
    
    {/foreach}
</table>

<a href="#" id="btn_sel">Seleccionar todos</a>


<input type="submit" value="Procesar pagos">

</form>

<script type="text/javascript">
    $(document).ready(function(){
        
        {if $agregados > 0}
            alert("Se agregaron {$agregados} pagos para procesar");
        {/if}
    
        $('#btn_sel').click(function(e){
            e.preventDefault();
            $('.req_chk').attr('checked', true);
        });
    });
</script>

</body>
</html>

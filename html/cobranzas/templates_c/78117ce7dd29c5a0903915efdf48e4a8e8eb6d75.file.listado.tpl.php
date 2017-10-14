<?php /* Smarty version Smarty-3.1.1, created on 2013-03-19 19:07:49
         compiled from "./templates/listado.tpl" */ ?>
<?php /*%%SmartyHeaderCode:102935458450087639d91119-26339408%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '78117ce7dd29c5a0903915efdf48e4a8e8eb6d75' => 
    array (
      0 => './templates/listado.tpl',
      1 => 1363254299,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '102935458450087639d91119-26339408',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_50087639de6b0',
  'variables' => 
  array (
    'res' => 0,
    'r' => 0,
    'agregados' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50087639de6b0')) {function content_50087639de6b0($_smarty_tpl) {?><!doctype html>
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
    
    <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['res']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>
        <tr>
            <td><input type="checkbox" name="requests[]" class="req_chk" value="<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
" /></td>
            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['ca_cnro'];?>
</td>
            <td><?php if (strtolower($_smarty_tpl->tpl_vars['r']->value['tipo'])=='token'){?> Token <?php }else{ ?> Tarjeta de credito <?php }?></td>
            <td><?php if (strtolower($_smarty_tpl->tpl_vars['r']->value['tipo'])=='token'){?> <?php echo $_smarty_tpl->tpl_vars['r']->value['numero'];?>
 <?php }else{ ?>************<?php echo substr($_smarty_tpl->tpl_vars['r']->value['numero'],12,4);?>
 <?php }?></td>
            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['importe'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['f_fecha_carga'];?>
</td>
            <td><?php if ($_smarty_tpl->tpl_vars['r']->value['tipo_transac']==1){?>Venta<?php }elseif($_smarty_tpl->tpl_vars['r']->value['tipo_transac']==2){?>Devolucion<?php }else{ ?>Otro<?php }?></td>
        </tr>
    
    <?php } ?>
</table>

<a href="#" id="btn_sel">Seleccionar todos</a>


<input type="submit" value="Procesar pagos">

</form>

<script type="text/javascript">
    $(document).ready(function(){
        
        <?php if ($_smarty_tpl->tpl_vars['agregados']->value>0){?>
            alert("Se agregaron <?php echo $_smarty_tpl->tpl_vars['agregados']->value;?>
 pagos para procesar");
        <?php }?>
    
        $('#btn_sel').click(function(e){
            e.preventDefault();
            $('.req_chk').attr('checked', true);
        });
    });
</script>

</body>
</html>
<?php }} ?>
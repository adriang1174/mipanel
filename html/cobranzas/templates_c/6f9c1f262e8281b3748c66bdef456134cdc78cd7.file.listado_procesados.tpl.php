<?php /* Smarty version Smarty-3.1.1, created on 2013-03-19 19:36:02
         compiled from "./templates/listado_procesados.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1326192196501c354e82b323-20142351%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6f9c1f262e8281b3748c66bdef456134cdc78cd7' => 
    array (
      0 => './templates/listado_procesados.tpl',
      1 => 1363254299,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1326192196501c354e82b323-20142351',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_501c354e9853b',
  'variables' => 
  array (
    'res' => 0,
    'r' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_501c354e9853b')) {function content_501c354e9853b($_smarty_tpl) {?><!doctype html>
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
    
    <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['res']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>
        <tr>
            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['ca_cnro'];?>
</td>
            <td><?php if (strtoupper($_smarty_tpl->tpl_vars['r']->value['tipo'])=='TOKEN'){?> Token <?php }else{ ?> Tarjeta de credito <?php }?></td>
            <td><?php if (strtoupper($_smarty_tpl->tpl_vars['r']->value['tipo'])=='TOKEN'){?> <?php echo $_smarty_tpl->tpl_vars['r']->value['numero'];?>
 <?php }else{ ?>************<?php echo substr($_smarty_tpl->tpl_vars['r']->value['numero'],12,4);?>
 <?php }?></td>
            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['importe'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['f_fecha_carga'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['litle_estado'];?>
 </td>
            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['litle_fecha'];?>
 </td>
            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['litle_token'];?>
 </td>
            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['litle_observacion'];?>
 </td>
            <td><?php echo $_smarty_tpl->tpl_vars['r']->value['litle_id'];?>
 </td>
            <td><?php if ($_smarty_tpl->tpl_vars['r']->value['tipo_transac']==1){?>Venta<?php }elseif($_smarty_tpl->tpl_vars['r']->value['tipo_transac']==2){?>Devolucion<?php }else{ ?>Otro<?php }?></td>
        </tr>
    
    <?php } ?>
</table>


</form>


</body>
</html>
<?php }} ?>
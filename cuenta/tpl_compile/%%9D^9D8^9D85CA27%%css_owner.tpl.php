<?php /* Smarty version 2.6.11, created on 2017-10-14 14:35:09
         compiled from css_owner.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'ownerurl', 'css_owner.tpl', 3, false),)), $this); ?>
<?php if ($this->_tpl_vars['owner']): ?>
    <?php if ($this->_tpl_vars['print_switch']): ?>
		<link rel="stylesheet" type="text/css" href="<?php if ($this->_tpl_vars['print'] || $this->_tpl_vars['printall']):  echo smarty_function_ownerurl(array(), $this); else: ?>owner/<?php endif;  echo $this->_tpl_vars['owner']; ?>
/stylesheet.v2.css" />
    <?php else: ?>
        <link rel="stylesheet" type="text/css" href="owner/<?php echo $this->_tpl_vars['owner']; ?>
/stylesheet.v2.css" />
    <?php endif;  endif; ?>
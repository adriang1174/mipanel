<?
require_once( 'Smarty/libs/Smarty.class.php');
require_once( 'SmartyPaginate/SmartyPaginate.class.php');
require_once( 'SmartyPaginate/function.paginate_first.php');
require_once( 'SmartyPaginate/function.paginate_last.php');
require_once( 'SmartyPaginate/function.paginate_middle.php');
require_once( 'SmartyPaginate/function.paginate_next.php');
require_once( 'SmartyPaginate/function.paginate_prev.php');
require_once( 'smarty.function.lang.inc.php');
require_once( 'smarty.function.section_title.inc.php');
require_once( 'smarty.function.ca_list_agrupation.php');
require_once( 'smarty.function.uriflags.inc.php');
require_once( 'smarty.function.phpself.inc.php');
require_once( 'smarty.function.varcontents.inc.php');
require_once( 'smarty.modifier.varnotempty.inc.php');
require_once( 'smarty.function.currenturi.inc.php');
require_once( 'smarty.function.ipath.inc.php');
require_once( 'smarty.modifier.allowed.inc.php');
require_once( 'smarty.function.currenthidden.inc.php');
require_once( 'smarty.function.barcode.inc.php');
require_once( 'smarty.function.ownerurl.inc.php');
require_once( 'smarty.function.baseurl.inc.php');

$smarty = new Smarty;
$smarty->compile_dir = TPL_COMPILE_DIR;
$smarty->cache_dir = TPL_COMPILE_DIR;
$smarty->caching = 0;
$smarty->left_delimiter = '<!--{';
$smarty->right_delimiter = '}-->';

$smarty->register_function( "paginate_first", "smarty_function_paginate_first");
$smarty->register_function( "paginate_last", "smarty_function_paginate_last");
$smarty->register_function( "paginate_middle", "smarty_function_paginate_middle");
$smarty->register_function( "paginate_next", "smarty_function_paginate_next");
$smarty->register_function( "paginate_prev", "smarty_function_paginate_prev");
$smarty->register_function( "lang", "smarty_function_lang");
$smarty->register_function( "section_title", "smarty_function_section_title");
$smarty->register_function( "ca_list_agrupation", "smarty_function_ca_list_agrupation");
$smarty->register_function( "ca_list_agrupation_init", "smarty_function_ca_list_agrupation_init");
$smarty->register_function( "uriflags", "smarty_function_uriflags");
$smarty->register_function( "phpself", "smarty_function_phpself");
$smarty->register_function( "varcontents", "smarty_function_varcontents");
$smarty->register_modifier( "varnotempty", "smarty_modifier_varnotempty");
$smarty->register_function( "currenturi", "smarty_function_currenturi");
$smarty->register_function( "ipath", "smarty_function_ipath");
$smarty->register_modifier( "allowed", "smarty_modifier_allowed");
$smarty->register_function( "currenthidden", "smarty_function_currenthidden");
$smarty->register_function( "barcode", "smarty_function_barcode");
$smarty->register_function( "ownerurl", "smarty_function_ownerurl");
$smarty->register_function( "baseurl", "smarty_function_baseurl");


function smarty_setup( $template)
{
	if ( !$template)
		$template = DEF_DEFAULT_TEMPLATE;
		
	// Seteamos el dir de templates de Smarty, en funcion del template
	// que se quiera usar.

	global $smarty;
	$tpldir = TPL_DIR . "/" . $template . "/";
	if ( is_dir( $tpldir))
		$smarty->template_dir = $tpldir;
	else
	{
		$tpldir = TPL_DIR . "/" . DEF_DEFAULT_TEMPLATE . "/";
		if ( is_dir( $tpldir))
			$smarty->template_dir = $tpldir;
		else
			return false;
	}

	return true;
}

?>

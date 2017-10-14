<?
require_once( INCLUDE_PATH . "data/profile.php");
require_once( INCLUDE_PATH . "data/services.php");

class scr
{
	var $allow_popup = true;
    var $allow_print = false;
    var $allow_printall = false;
    var $allow_exportcsv = false;
    var $allow_email = false;
    var $allow_pay = false;
    
	function parameters( $params)
	{
		if ( $params)
		{
			basescr::setvar( "id_accion", varconn::GET( "id_accion"));
			basescr::setvar( "ani", varconn::GET( "ani"));
			basescr::setvar( "followme", varconn::GET( "followme"));
			basescr::setvar( "interno", varconn::GET( "interno"));
			
			basescr::setvar( "mat_horaria", varconn::POST( "mat_horaria"));
			basescr::setvar( "t1", varconn::POST( "t1"));
			basescr::setvar( "t2", varconn::POST( "t2"));
			basescr::setvar( "t3", varconn::POST( "t3"));
			basescr::setvar( "t4", varconn::POST( "t4"));
			basescr::setvar( "t5", varconn::POST( "t5"));
			basescr::setvar( "f_call", varconn::POST( "f_call"));
			basescr::setvar( "process", varconn::POST( "process"));
		}
		return true;
	}
	
	function filter( $params)
	{
		return true;
	}
	
	function process( $params)
	{
		return true;
	}

	function assign( $params)
	{
	
        global $smarty;
		$action = Services::getActionInfo(basescr::getvar( "id_accion"));
		$variables["ani"] =basescr::getvar( "ani");

		if((basescr::getvar( "mat_horaria") != "") && (basescr::getvar( "ani") != "")){
			$variables["t1"] = trim(basescr::getvar( "t1"));
			$variables["t2"] = trim(basescr::getvar( "t2"));
			$variables["t3"] = trim(basescr::getvar( "t3"));
			$variables["t4"] = trim(basescr::getvar( "t4"));
			$variables["t5"] = trim(basescr::getvar( "t5"));
			$variables["mat_horaria"] = trim(basescr::getvar( "mat_horaria"));
			$variables["f_call"] = trim(basescr::getvar( "f_call"));
			$variables["process"] = trim(basescr::getvar( "process"));
			
			$action_sp = Services::getActionSp("M", basescr::getvar( "id_accion"));

			foreach($action_sp as $sp){
				$$sp[1] = Services::execSP($sp[0], $variables, false, true, ca_session::get_userid( ), ca_session::get_customerid( ), $sp[2], $sp[3]);
			}

		}
		
		$action_sp = Services::getActionSp("S", basescr::getvar( "id_accion"));
		foreach($action_sp as $sp){
			$$sp[1] = Services::execSP($sp[0], $variables);
			$smarty->assign($sp[1], $$sp[1]);
		}
		
		if(basescr::getvar( "id_accion") == 1){ // HAFull Follow Me
			//$smarty->assign("show_netfono", true);
			$smarty->assign("HELP_TEXT", lang('DESCRIPCION_GRILLA_HAFULL'));
		}
		
		if(basescr::getvar( "id_accion") == 16){ // HAFull Callback
			$smarty->assign("HELP_TEXT", lang('DESCRIPCION_GRILLA_HAFULL_CALLBACK'));
			
		}
		
		if(basescr::getvar( "id_accion") == 4){ // OFG2 Franjas internos
			$title_extra = " - " . lang('INTERNO') . " " . basescr::getvar( "interno");
			$smarty->assign("HELP_TEXT", lang('FOLLOWME_OFG2_HELP'));
			$smarty->assign("SHOW_HELP_LINK", true);
		}

		
		if(basescr::getvar( "followme") == 1){
			$smarty->assign( "service_name", "followme");
			if(basescr::getvar( "id_accion") == 1){ // HAFull Follow Me
				$smarty->assign( "TITLE", lang('TITLE_FH_FOLLOWME_HAFULL') . $title_extra);
			}else{
				$smarty->assign( "TITLE", lang('TITLE_FH_FOLLOWME') . $title_extra);
			}
			return true;
		}else{
			if(basescr::getvar( "id_accion") == 16){ // HAFull Callback
				$smarty->assign( "service_name", "callback");
				$smarty->assign( "TITLE", lang('TITLE_FH_FOLLOWME_HAFULL_CALLBACK'));
			}else{
				$smarty->assign( "service_name", "callback");
				$smarty->assign( "TITLE", lang('TITLE_FH_CALLBACK'));
			}
			return true;
		}
	}
}

?>

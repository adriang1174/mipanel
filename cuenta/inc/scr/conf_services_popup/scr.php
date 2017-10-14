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
			basescr::setvar( "accion", varconn::GET( "accion"));
			basescr::setvar( "line", varconn::GET( "line"));
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
		
		switch(basescr::getvar("accion")){
			case "ofg2_internos_nuevoint";
				$smarty->assign( "TITLE", lang('INT_MSG_PROMPT_TITLE'));
				$smarty->assign( "MESSAGE", lang('INT_MSG_PROMPT'));
				break;
			case "ofg2_avanzado_nuevoani":
				$smarty->assign( "TITLE", lang('ADD_NEW_ANI_TITLE'));
				$smarty->assign( "MESSAGE", lang('ADD_NEW_ANI'));
				break;
			case "ofg2_grid_help":
				$smarty->assign( "TITLE", lang('TITLE_FH_CALLBACK'));
				break;
			case "hafull_avanzado_nuevoani":
				$smarty->assign( "TITLE", lang('HA_ADD_NEW_ANI_TITLE'));
				$smarty->assign( "MESSAGE", lang('ADD_NEW_ANI'));
				break;
			case "netfono_nuevoint":
				$smarty->assign( "TITLE", lang('NETFONO_ADD_NEW_INT'));
				$smarty->assign( "MESSAGE", lang('NETFONO_ADD_NEW_INT_HELP'));
				$smarty->assign( "line", basescr::getvar( "line"));				
				break;
			case "ofg3_internos_nuevoint";
				$smarty->assign( "TITLE", lang('INT_MSG_PROMPT_TITLE'));
				$smarty->assign( "MESSAGE", lang('INT_MSG_PROMPT'));
				break;
		}

		$smarty->assign( "FUNCTION", basescr::getvar("accion"));		
		return true;
	}
}

?>

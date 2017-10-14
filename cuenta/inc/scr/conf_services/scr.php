<?

require_once( INCLUDE_PATH . "data/profile.php");
require_once( INCLUDE_PATH . "data/services.php");

class scr
{
    var $allow_print = false;
    var $allow_printall = false;
    var $allow_exportcsv = false;
    var $allow_email = false;
    var $allow_pay = false;
    
	function parameters( $params)
	{
		if ( $params)
		{
			basescr::setvar( "line", varconn::POST( "line"));
			basescr::setvar( "process", varconn::POST( "process"));
			basescr::setvar( "actioncode", varconn::POST( "actioncode"));
			basescr::setvar( "actionid", varconn::POST( "actionid"));
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
		
		
		$profile = new profile( ca_session::get_userid( ));
        $email_verif = $profile->is_mail_verif( );
        
		$smarty->assign( "TITLE", lang( 'TITLE_CONF_SERVICES'));
		if ( !$email_verif && (!isset($_SESSION['admin_access']) && $_SESSION['admin_access'] != 1)){
            $smarty->assign( "email_not_verif", true);
        }else{
$smarty->clear_compiled_tpl();

//echo "<pre>";
//print_r($_POST);
//echo "</pre>";
	
		if (basescr::getvar( "line") == NULL){
			$lines = Services::getLinesByUser(ca_session::get_userid( ));
			
			$smarty->assign("lines", $lines);
			$smarty->assign("show", "select");
		}else{
			$smarty->assign("show", "configuration");
			$smarty->assign("line", basescr::getvar( "line"));
			$actions = Services::getActionsByLine(basescr::getvar( "line"));
			$smarty->assign("actions", $actions);
			$service_info = Services::getServiceInfo(basescr::getvar( "line"));
			$smarty->assign("service", $service_info["servicio"]);
			$smarty->assign("show_id", basescr::getvar( "actionid"));
			$smarty->assign("process", basescr::getvar( "process"));
			$smarty->assign("actioncode", basescr::getvar( "actioncode"));
			$variables = $_POST;
			$variables["ani"] = basescr::getvar( "line");

			if(basescr::getvar( "process") == 1){
			
				// PARCHE PARA PODER CORRER MAS DE UNA SP POR VEZ
				if(strpos($_POST['actioncode'], "/") > 0 ){
					$actionCodes = explode("/", $_POST['actioncode']);
				}else{
					$actionCodes = array($_POST['actioncode']);
				}
				
				foreach($actionCodes as $oneCode){
//echo "Ejecuto: ". $oneCode ." ". basescr::getvar( "actionid") ."<br>";
					$sp_m = Services::getActionSp($oneCode, basescr::getvar( "actionid"));
					foreach($sp_m as $sp){
						Services::execSP($sp[0], $variables, false, true, ca_session::get_userid( ), ca_session::get('admin_usuario_id'), $sp[2], $sp[3]);
					}
					
				}
			}
			// Agarro las SP S del servicio
			$service_sp = Services::getServiceSp("S", $service_info["id_servicio"]);
			foreach($service_sp as $sp){
				$$sp[1] = Services::execSP($sp[0], $variables);
/*
echo $sp[1];
echo "<pre>";
print_r($$sp[1]);
echo "</pre>";
*/

				$smarty->assign($sp[1], $$sp[1]);
			}			


			foreach($actions as $action){
				// Agarro las SP S de la accion
				$action_sp = Services::getActionSp("S", $action[3]);
				foreach($action_sp as $sp){
					$$sp[1] = Services::execSP($sp[0], $variables);
/*
echo $sp[1];
echo "<pre>";
print_r($$sp[1]);
echo "</pre>";
*/
					$smarty->assign($sp[1], $$sp[1]);
				}
			}
		}
	}

	return true;
	}
}

?>

<?
require_once( INCLUDE_PATH . "data/profile.php");

class scr
{
    var $allow_print = false;
    var $allow_printall = false;
    var $allow_exportcsv = false;
    var $allow_email = false;
    var $allow_pay = false;
    
	function parameters( $params)
	{
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
 
        // This user is allowed to use this scr?
        $profile = new profile( ca_session::get_userid( ));
        $email_verif = $profile->is_mail_verif( );
        if ( !$email_verif)
        {
            $smarty->assign( "email_not_verif", true);
        }
        else
        {
            // Create the pic object.
            
            //$owner_id = ( int)owner_to_ownerid( ca_session::get( "owner"));
            //$pic = new pic( ca_session::get_userid( ), $owner_id);
            $pic = new pic(ca_session::get_userid(), ca_session::get("mercado"));

            // Get the service parameter.

            $_service = ( int)$_REQUEST[ 'service'];
            $service_name = null;
            $valid_service = false;
            $services = $pic->get_services( );
            foreach( $services as $service)
            {
                if ( ( int)$service[ 'id_servicio'] == ( int)$_service)
                {
                    $service_name = $service[ 'servicio'];
                    $valid_service = true;
                    break;
                }
            }

            if ( !$valid_service)
                $_service = null;

            if ( $_service)
            {
                $smarty->assign( "show_form", true);
                $smarty->assign( "service_name", $service_name);
                ca_session::set( "service", $_service);
                $_params = $pic->get_param_by_service( $_service);
                
                $ca_form_services = new ca_form_services( $_service, $_params);
                $res = $ca_form_services->do_magic( );
                
                
                // ESTO PERMITE AGREGAR TEXTO EXTRA PARA CADA SERVICIO, SI LA CONSTANTE ESTA DEFINIDA SE MUESTRA ARRIBA DEL FORM
                if(defined('TPL_SERV_TEXTO_EXTRA_ALTA_'.$_service)){
                	$smarty->assign('extra_txt', constant('TPL_SERV_TEXTO_EXTRA_ALTA_'.$_service));
                }
                
                switch ( $res)
                {
                    case CA_FORM_RESULT_DISPLAY:
                        // Continue, we should display the form.
                        break;

                    default:
                        // The form has been executed, maybe we redirect
                        // somewhere.
                        clientcontrol::redirect( "services.ca?completed=1");
                }
            }
            else
            {
                $smarty->assign( "services", $services);
                $smarty->assign( "show_form", false);
                $smarty->assign( "completed", ( int)$_GET[ 'completed'] == 1 ? true : false);
                $smarty->assign( "phone_support", owner::phone_support( ));
                $smarty->assign( "addr_support", owner::addr_support( ));
            }
        }
            
		return true;
	}
}

?>

<?
/* (!) comentar esta linea antes de subir */
//$smarty->clear_compiled_tpl();

/* Este bloque de codigo permite obtener la cantidad de
   servicios disponibles para el cliente actualmente logueado */
require_once( INCLUDE_PATH . "data/services.php");
/*  CODIGO VIEJO, NO CONTEMPLA LOS SERVICIOS QUE NO SON CONFIGURABLES 
$lines = Services::getLinesByUser(ca_session::get_userid( ));
$smarty->assign("CountLinesForUserLoginPanel", count($lines));
unset($lines);
*/
$smarty->assign("CountLinesForUserLoginPanel", Services::getTotalServicesForUser(ca_session::get_userid( )) );
$smarty->assign("ClientStatusForUserLoginPanel", ca_session::get("estado_cliente"));



/* Si existe la variable $_GET["fP"] indicara que se esta accediendo por el 
   menu y debera redefinirse el path (almacenarlo en session. este proceso
   se realiza en beta-cuenta/inc/bassescr -> show
*/
if (isset($_GET["fP"])) {
	$_SESSION["redefinePath"] = true;
} else {
	$_SESSION["redefinePath"] = false;
}
			
$scrs = array(

	/* Tienen entradas desde la barra del costado. */
	//array( "id" => "tickets", "name" => lang( 'TICKETS'), "script" => "index.ca", "title" => "TITLE_TICKETS"),
	array( "id" => "logout", "name" => lang( 'LOGOUT'), "script" => "logout.ca"),
	array( "id" => "cc", "name" => lang( 'CHECKING_ACCOUNT'), "script" => "cc.ca", "title" => "TITLE_CHECKING_ACCOUNT"),
	array( "id" => "traff_nf", "name" => lang( 'TRAFF_NF'), "script" => "traff_nf.ca", "title" => "TITLE_TRAFF_NF", "title_href" => "traff_nf.ca"),
	array( "id" => "traff_f", "name" => lang( 'TRAFF_F'), "script" => "traff_f.ca", "title" => "TITLE_TRAFF_F", "title_href" => "traff_f.ca"),
	array( "id" => "traff_p", "name" => lang( 'TRAFF_P'), "script" => "traff_p.ca", "title" => "TITLE_TRAFF_P", "title_href" => "traff_p.ca"),
	array( "id" => "notices", "name" => lang( 'NOTICES'), "script" => "notices.ca", "title" => "TITLE_NOTICES"),
	array( "id" => "email_password", "name" => lang( 'DATMOD'), "script" => "email_password.ca", "title" => "TITLE_DATMOD"),
	array( "id" => "rates", "name" => lang( 'TARIFAS'), "script" => "rates.ca", "title" => "TITLE_RATES"),
	array( "id" => "rcalllist", "name" => lang( 'REFERENCIADELLAMADAS'), "script" => "rcalllist.ca", "title" => "TITLE_RCALL"),
	array( "id" => "cclist", "name" => lang( 'CENTRODECOSTOS'), "script" => "cclist.ca", "title" => "TITLE_CCENTER"),
	array( "id" => "callback", "name" => lang( 'PEDIDODECALLBACK'), "script" => "#", "onclick" => "return false;"),
   	array( "id" => "conf_services", "name" => lang( 'TITLE_CONF_SERVICES'), "script" => "conf_services.ca", "title" => "TITLE_CONF_SERVICES"),
	array( "id" => "ticket", "name" => lang( 'LAST_INVOICE') , "script" => "ticket.ca", "title" => "LAST_INVOICE", "params" => "lastticket=true"),
	array( "id" => "tickets", "name" => lang ('CHOOSE_INVOICE'), "script" => "index.ca", "title" => "CHOOSE_INVOICE"),
	array( "id" => "payment_mode", "name" => lang ('PAYMENT_MODE'), "script" => "payment_mode.ca", "title" => "PAYMENT_MODE"),
	array( "id" => "last_traff", "name" => lang ('LAST_TRAFF'), "script" => "last_traff.ca", "title" => "LAST_TRAFF", "params" => "type=4&datefrom=&dateto=&pinid=&dialednumber="),
	array( "id" => "company_info", "name" => lang ('COMPANY_INFO'), "script" => "company_info.ca", "title" => "COMPANY_INFO"),
	array( "id" => "panel_password", "name" => lang ('PANEL_PASSWORD'), "script" => "panel_password.ca", "title" => "PANEL_PASSWORD"),
    array( "id" => "services", "name" => lang( 'TITLE_SERVICES_ACTIVATION'), "script" => "services.ca", "title" => "TITLE_SERVICES_ACTIVATION"),
	array( "id" => "services_removal", "name" => lang( 'TITLE_SERVICES_REMOVAL'), "script" => "services_removal.ca", "title" => "TITLE_SERVICES_REMOVAL"),
	array( "id" => "newsletter", "name" => lang( 'TITLE_NEWSLETTER'), "script" => "newsletter.ca", "title" => "TITLE_NEWSLETTER"),
	array( "id" => "subscribe_newsletter", "name" => lang( 'TITLE_SUBSCRIBE_NEWSLETTER'), "script" => "subscribe_newsletter.ca", "title" => "TITLE_SUBSCRIBE_NEWSLETTER"),
	array( "id" => "news", "name" => lang( 'TITLE_NEWS'), "script" => "news.ca", "title" => "TITLE_NEWS"),
	array( "id" => "contactus", "name" => lang( 'TITLE_CONTACTUS'), "script" => "contactus.ca", "title" => "TITLE_CONTACTUS"),
	array( "id" => "faq", "name" => lang( 'TITLE_FAQ'), "script" => "faq.ca", "title" => "TITLE_FAQ"),
	array( "id" => "payment_information", "name" => lang( 'TITLE_PAYMENT_INFORMATION'), "script" => "payment_information.ca", "title" => "TITLE_PAYMENT_INFORMATION"),
	array( "id" => "instructions", "name" => lang( 'TITLE_INSTRUCTIONS'), "script" => "instructions.ca", "title" => "TITLE_INSTRUCTIONS"),
	
	/* No tienen entradas, se llega haciendo clicks. */
	//+ home
	array( "id" => "home", "title" => "TITLE_HOME", "title_href" => "home.ca"),
	array( "id" => "contact", "title" => "TITLE_CONTACT", "title_href" => "contact.ca"),
	array( "id" => "dialplan", "title" => "TITLE_DIALPLAN", "title_href" => "dialplan.ca"),
	array( "id" => "ticket", "title" => "TITLE_TICKET", "title_href" => "index.ca"),
	array( "id" => "ticket_item", "title" => "TITLE_TICKET_ITEM", "title_href" => "traff_f.ca"),
	array( "id" => "traff", "name", "title" => "TITLE_TICKET_ITEM_TRAFF", "title_href" => "traff_f.ca"),
	array( "id" => "receipt", "title" => "TITLE_RECEIPT", "title_href" => "cc.ca"),
	array( "id" => "ccadd", "title" => "TITLE_CCADD", "title_href" => "cclist.ca"),
	array( "id" => "ccedit", "title" => "TITLE_CCEDIT", "title_href" => "cclist.ca"),
	array( "id" => "ccdel"),
	array( "id" => "rcalladd", "title" => "TITLE_RCALLADD", "title_href" => "rcalllist.ca"),
	array( "id" => "rcalldel"),
	array( "id" => "rcalledit", "title" => "TITLE_RCALLEDIT", "title_href" => "rcalllist.ca"),
	array( "id" => "rate", "title" => "TITLE_RATE", "title_href" => "rates.ca"),
	array( "id" => "email", "title" => "TITLE_EMAIL", "title_href" => "email.ca"),
	array( "id" => "encuestas", "title" => "TITLE_ENCUESTAS", "title_href" => "encuestas.ca"),
	
	array( "id" => "fh_callback", "name" => lang( 'TITLE_GRID'), "script" => "#", "title" => "TITLE_GRID"),
	array( "id" => "conf_services_popup", "name" => lang( 'TITLE_CONF_SERVICES'), "script" => "#", "title" => "TITLE_CONF_SERVICES")
);

if(!isset($_SESSION['admin_access']) || $_SESSION['admin_access'] != 1){
	if(!isset($_SESSION['email_verificado'])){
		$page_name = substr( $_SERVER['PHP_SELF'],  strrpos($_SERVER['PHP_SELF'], '/')+1 );
		if($page_name != 'email.ca'){
			$profile = new profile( ca_session::get_userid( ));
			$email_verif = $profile->is_mail_verif( );

			if ( !$email_verif ){
				clientcontrol::redirect( "email.ca");
			}else{
				$_SESSION['email_verificado'] = true;
			}
		}
	}
}

?>

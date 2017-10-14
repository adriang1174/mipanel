<?
require_once( INCLUDE_PATH . 'data/rcall.php');

class scr
{
    var $allow_print = true;
    var $allow_printall = false;
    var $allow_exportcsv = true;
    var $allow_email = true;
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

		$rcall = new rcall( ca_session::get_userid( ));
		$rcalls = $rcall->get_all( );
		
		// Converting the list into a generic ca_list.
		$ca_list_body = array( );
		foreach( $rcalls as $key => $value)
		{
			if ( $value->project)
			{
				$ll = urlencode( $value->dest);
				$del = '<a href="rcalldel.ca?dest=' . $ll . '" onclick="return confirm(\'' . lang( "RCALLDEL_CONFIRM") . '\');"><img src="img/icono-goma.gif" border="0" /></a>';
				$edit = '<a href="rcalledit.ca?dest=' . $ll . '"><img src="img/icono-lapiz.gif" border="0" /></a>';
				
				$ca_list_body[ ] = array( $value->dest, $value->project, $value->name, $value->lastname, $value->company, $value->title, $value->email, $edit . "&nbsp;" . $del);
			}
		}
		$ca_list = new ca_list( array( "TARGET", "PROJECT", "FIRST_NAME", "LAST_NAME", "COMPANY", "COMPANY_TITLE", "EMAIL", "ACTIONS"), $ca_list_body);
		$ca_list->show_footer = false;
		$ca_list->paginate = false;
		$smarty->assign( "ca_list", $ca_list);

		return true;
	}
}

?>

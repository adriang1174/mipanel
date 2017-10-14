<?

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

		$ccenter = new ccenter( ca_session::get_userid( ));
		$ccenters = $ccenter->get_all( );
		
		/* Converting the list into a generic ca_list. */
		$ca_list_body = array( );
		foreach( $ccenters as $key => $value)
		{
			if ( $value->name)
			{
				$ll = urlencode( $value->line->type . $value->line->number);
 
				$del = '<a href="ccdel.ca?line=' . $ll . '" onclick="return confirm(\'' . lang( "CCDEL_CONFIRM") . '\');"><img src="img/icono-goma.gif" border="0" /></a>';
				$edit = '<a href="ccedit.ca?line=' . $ll . '"><img src="img/icono-lapiz.gif" border="0" /></a>';
				
				if($_GET['exportcsv'] != "1" && $_GET['email'] != "1"){ // para evitar que se muestren los iconos de editar y eliminar cuando se exporta el listado o se envia por mail
					$ca_list_body[ ] = array( $value->line->type . " " . $value->line->number, $value->name, $edit . "&nbsp;" . $del);
				}else{
					$ca_list_body[ ] = array( $value->line->type . " " . $value->line->number, $value->name);
				}
			}
		}
		if($_GET['exportcsv'] != "1" && $_GET['email'] != "1"){// para evitar que se muestren los iconos de editar y eliminar cuando se exporta el listado o se envia por mail
			$ca_list = new ca_list( array( "ACCOUNT", "CENTRODECOSTOS", "ACTIONS"), $ca_list_body);
		}else{
			$ca_list = new ca_list( array( "ACCOUNT", "CENTRODECOSTOS"), $ca_list_body);
		}
		$ca_list->show_footer = false;
		$ca_list->paginate = false;
		$smarty->assign( "ca_list", $ca_list);

		return true;
	}
}

?>

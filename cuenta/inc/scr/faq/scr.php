<?

class scr
{
    
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
		
		$owner = owner_to_ownerid();

		if($owner == 1 || $owner == 2){ // red
			$smarty->assign("vea_ademas_red", true);
		}else if($owner == 3){ // hota
			$smarty->assign("vea_ademas_hola", true);	
		}else if($owner == 5){ // hotatel
			$smarty->assign("vea_ademas_holatel", true);
		} else if($owner == 7){ // t2
			$smarty->assign("vea_ademas_telephone2", true);
		}
		
	
		
		
		
		return true;
	}
}

?>

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
		
		
		$news[1][0] = TPL_NEWS_1_0;
		$news[2][0] = TPL_NEWS_2_0;
		$news[3][0] = TPL_NEWS_3_0;
		$news[4][0] = TPL_NEWS_4_0;
		$news[5][0] = TPL_NEWS_5_0;
		$news[6][0] = TPL_NEWS_6_1;
		
		$news[1][1] = TPL_NEWS_1_1;
		
		$news[2][1] = TPL_NEWS_2_1;
		
		$news[3][1] = TPL_NEWS_3_1;
		$news[7][0] = OWNER_TPL_NEWS_7_1;
		
		
		$smarty->assign("novedades", $news[owner_to_ownerid()]);
		
		return true;
	}
}

?>

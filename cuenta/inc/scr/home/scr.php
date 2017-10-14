<?
class scr {
    var $allow_print = true;
    var $allow_printall = true;
    var $allow_exportcsv = true;
    var $allow_email = true;
    var $allow_pay = true;
    
	function parameters( $params) {
	
		return true;
		
	}
	
	function filter( $params) {
		
		return true;
		
	}
	
	function process( $params) {

		return true;
		
	}

	function assign( $params) {	
		
		global $smarty;
		
		$SQLQry = "SELECT admin_templates.\"idTemplate\", admin_templates.\"fileName\" FROM owner "
			. "INNER JOIN admin_templates ON owner.\"idTemplate\" = admin_templates.\"idTemplate\" "
			. "WHERE owner_id = " . $_SESSION["ownerId"] . ";";
		
    //echo $SQLQry . "<hr />";
    $res = db::get_rows_as_array_of_hashes($SQLQry);
		
		
		$SQLQry = "SELECT 
			admin_valores.\"idValor\",
			admin_valores.\"valor\",
			admin_elementos.\"denom\",
			admin_elementos.\"HTMLId\"
		FROM
			public.admin_valores 
			INNER JOIN admin_elementos ON (admin_valores.\"idElemento\" = admin_elementos.\"idElemento\")
		WHERE
			(admin_valores.\"idOwner\" = " . $_SESSION["ownerId"] . ") AND 
			(admin_elementos.\"idTemplate\" = " . $res[0]["idTemplate"] . ")";
		
		//echo $SQLQry . "<hr />";
		
		//la siguiente linea permite redefinir el template a utilizar
		basescr::setvar( "_template", "scr_" . $res[0]["fileName"] . ".tpl");
		
		$res = db::get_rows_as_array_of_hashes($SQLQry);
		foreach($res as $row) {
			$smarty->assign($row["HTMLId"], $row["valor"]);
		}

		return true;
	}
}
?>
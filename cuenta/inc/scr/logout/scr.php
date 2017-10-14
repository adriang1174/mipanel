<?

class scr
{
    var $allow_print = false;
    var $allow_printall = false;
    var $allow_exportcsv = false;
    var $allow_email = false;
    var $allow_pay = false;
    
	function parameters( )
	{
		header( "Location: login.php");
		exit;
	}
	
	function filter( )
	{
		return true;
	}
	
	function process( )
	{
		return true;
	}

	function assign( )
	{
		return true;
	}
}

?>

<?

class clientcontrol
{
	function forbidden( )
	{
		session_write_close( );
		header( "HTTP/1.1 403 Forbidden");
		exit;
	}

	function redirect( $url)
	{
		session_write_close( );

		header( "Location: " . $url);
		exit;
	}
}

?>

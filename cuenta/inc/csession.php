<?

class csession
{
	function create( )
	{
		session_start( );
		csession::setvar( "timestamp", mktime( ));
		csession::setvar( "remoteip", varconn::get_remoteip( ));
	}

	function setvar( $key, $value)
	{
		@session_start( );
		csession::destroyvar( $key);
		$_SESSION[ $key] = $value;
	}

	function getvar( $key)
	{
		@session_start( );
		if ( array_key_exists( $key, $_SESSION) && isset( $_SESSION[ $key]))
			return $_SESSION[ $key];

		return null;
	}
	
	function destroyvar( $key)
	{
		@session_start( );
		if ( array_key_exists( $key, $_SESSION) && isset( $_SESSION[ $key]))
			unset( $_SESSION[ $key]);
	}

	function destroyvars( )
	{
		@session_start( );
		if ( @isset( $_SESSION) && @is_array( $_SESSION))
		{
			foreach( $_SESSION as $key => $value)
			{
				unset( $_SESSION[ $key]);
			}

			unset( $_SESSION);
		}
	}

	function destroy( )
	{
		@session_start( );
		csession::destroyvars( );
		unset( $_COOKIE[ session_name( )]);
	}
}

?>

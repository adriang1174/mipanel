<?
require_once( 'uri.php');


class pagination
{
	/* Filtra los parametros "next" y "limit" y destruye
	 * las variables si hay algo raro.
	 */
	
	function filter( )
	{
		if ( array_key_exists( "next", $_GET))
		{
			$_next = filter::next( $_GET[ "next"]);
			if ( !$_next)
				unset( $_GET[ "next"]);
		}

		if ( array_key_exists( "limit", $_GET))
		{
			$_limit = filter::limit( $_GET[ "limit"]);
			if ( !$_limit)
				unset( $_GET[ "limit"]);
		}
	}

	function getNext( )
	{
		if ( array_key_exists( "next", $_GET))
		{
			return $_GET[ "next"];
		}

		return false;
	}

	function getLimit( )
	{
		if ( array_key_exists( "limit", $_GET))
		{
			return $_GET[ "limit"];
		}

		return false;
	}
	
	function getDefaultLimit( )
	{
		global $DEF_PAGINATION_LIMITS;
		foreach( $DEF_PAGINATION_LIMITS as $key => $limit)
		{
			if ( $limit[ "default"])
				return $limit[ "limit"];
		}

		return 0;
	}
	
	function init( )
	{
		$_next = pagination::getNext( );
		$_limit = pagination::getLimit( );

		/* Filtro los params. */
		pagination::filter( );

		/* Inicializo el engine de paginacion. */
		SmartyPaginate::connect( );

		/* Si no viene "next", reseteamos la lista. */
		if ( !$_next)
		{
			SmartyPaginate::reset( );
		}

		/* Si viene limit, reseteamos la lista, y luego
		 * seteamos el limite.
		 */
		if ( $_limit)
		{
			/* Mandamos la paginacion al principio de la lista. */
			SmartyPaginate::reset( );
			
			/* Seteamos el limite de session. */
			ca_session::set( "pagination_limit", $_limit);
		}
		else
		{
			$_limit = ca_session::get( "pagination_limit");
			if ( !$_limit)
				$_limit = pagination::getDefaultLimit( );
		}

		/* Seteamos el limite de paginacion. */
		SmartyPaginate::setLimit( $_limit);


		/* Setting the real URL to use. */
		$uri = new uri( );
		$uri->exclude_params( array( "next", "limit"));
		SmartyPaginate::setURL( $uri->uri);

		/* Setting the limits. */
		global $smarty;
		global $DEF_PAGINATION_LIMITS;
		$smarty->assign( "pagination_limits", $DEF_PAGINATION_LIMITS);
		$smarty->assign( "pagination_limit", $_limit);

		if ( strstr( $uri->uri, "?"))
			$uri->uri .= "&";
		else
			$uri->uri .= "?";
		$uri->uri .= "limit=";
		$smarty->assign( "pagination_limit_uri", $uri->uri);
	}
}

?>

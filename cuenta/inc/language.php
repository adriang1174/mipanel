<?

/**
 * TODO: Comment all the non-commented functions.
 */
class language
{
	/**
	 * load - Recibe un lenguaje e incluye el php que corresponde al mismo para dejar
	 * definidas todas las constantes de lenguaje.
	 *
	 * @param	string	$lang	El languaje (formateado por "ISO 639: 2-letter codes").
	 * @return	bool			true Upon successful completion true is returned. Otherwise, false is returned.
	 */
	function load( $lang)
	{
		if ( !$lang)
			return false;
		
		$lang = language::sanitize_lang( $lang);
		if ( !$lang)
			$lang = DEF_DEFAULT_LANGUAGE;

		if ( !language::is_lang( $lang))
			$lang = DEF_DEFAULT_LANGUAGE;
			
		$path = language::get_path( $lang);

		require_once( $path);

		return true;
	}

	
	function get_path( $lang)
	{
		return ( PATH_LANG . $lang . "." . DEF_INCLUDE_EXTENSION);
	}
	
	
	function is_lang( $lang) {
		
		return is_file( language::get_path( language::sanitize_lang( $lang )));
		
	}

	
	function sanitize_lang( $str)
	{
		$str = trim( $str);
		if ( strlen( $str) > 2 || strlen( $str) <= 0)
			return false;

		if ( !ctype_alpha( $str))
			return false;

		return strtolower( $str);
	}
	
	
	function avail_languages( )
	{
		if ( !is_dir( PATH_LANG))
			return false;

		$dh = opendir( PATH_LANG);
		if ( !$dh)
			return false;

		$langs = array( );
		while( ( $file = readdir( $dh)) !== false)
		{
			$filename = PATH_LANG . $file;
			$matches = array( );
		
			if ( preg_match( "/^([a-z]{2})\\." . DEF_INCLUDE_EXTENSION . "$/i", $file, $matches))
			{
				$langs[ ] = language::sanitize_lang( $matches[ 1]);
			}
		}

		if ( count( $langs) <= 0)
			return false;
		
		return $langs;
	}

	
	/**
	 * translate_lenguage - Convierte el lenguaje que envia el browser a un lenguaje
	 * que este software pueda entender. En teoria parece que esta funcion hace las cosas
	 * demasiado complejas; he visto que en otros lados haciendo un substr( $langstr, 0, 2)
	 * lo solucionan. :S
	 *
	 * @param	string	$bhal		Browser HTTP Accept Language.
	 * @param	bool	$canbenull	Si es true, y nos pasan un lenguaje invalido, podemos devolver
	 *								false. Caso contrario hardcodeamos el return valua a "en".
	 * @return	mixed				En funcion del parametro $canbenull, podemos devolver false
	 *								o un lenguaje (string).
	 */
	function translate_lenguage( $bhal, $canbenull = false)
	{
		$availangs = language::avail_languages( );
		if ( !$availangs)
			return DEF_DEFAULT_LANGUAGE;
		
		$langs = explode( ",", ( string)$bhal);
		foreach( $langs as $key => $lang)
		{
			$real_lang = explode( ";", $lang);
			$real_lang = $real_lang[ 0];

			$matches = array( );
			if ( preg_match( "/^([a-z]{2})$/i", $real_lang, $matches))
			{
				$ll = language::sanitize_lang( $matches[ 1]);
				if ( in_array( $ll, $availangs))
					return $ll;
			}

			$matches = array( );
			if ( preg_match( "/^([a-z]{2})-([a-z]{2})$/i", $real_lang, $matches))
			{
				$ll = language::sanitize_lang( $matches[ 1]);
				if ( in_array( $ll, $availangs))
					return $ll;
			}
		}

		if ( $canbenull)
			return false;
		
		return DEF_DEFAULT_LANGUAGE;
	}
}

?>

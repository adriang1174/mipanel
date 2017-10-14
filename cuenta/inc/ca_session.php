<?
require_once( 'language.php');
require_once( 'data/profile.php');

/* Remember set the folowing php.ini values to:
 * 
 * session.gc_probability = 1
 * session.gc_divisor = 100
 * session.gc_maxlifetime = 7200
 * session.cookie_lifetime = 7200
 *
 * For additional information, see: http://www.php.net/session
 *
 */

function ca_session_NotifyFn( $expireref, $sesskey)
{
	// Nothing to do.
}

$ca_session_initialized = false;
$ca_session_validated = false;
$ca_session_validating = false;
$ca_session_language_initialized = false;

class ca_session
{
	/**
	 * init - Incializa la sesion.
	 *
	 * @param	bool	$sidcheck	If true, we should check for a valid session sid, otherwise, we do not check it.
	 * @return	bool				true Upon successful completion true is returned. Otherwise, false is returned.
	 * @access	public
	 */
	static function init( $sidcheck = false, $forceinit = false)
	{
		global $ca_session_initialized;
		global $ca_session_validated;
		global $ca_session_validating;
		
		if ( $forceinit)
		{
			$ca_session_initialized = false;
			$ca_session_validated = false;
			$ca_session_validating = false;
		}
		
		if ( !$ca_session_initialized)
		{
            /* Setting the expiration time. */
            session_set_cookie_params( time( ) + DEF_SESSION_HARDLIMIT, COOKIE_PATH, "", COOKIE_SECURE);
            
			/* Setting the session name */
			
			// COMENTADO PORQUE DEJO DE FUNCIONAR EN php 5.4
	    	//session_name( "ca_session");
			
			/* Initializing */
			session_start( );


			
			/* Setting up the flag */
			$ca_session_initialized = true;
		}

		if ( !$ca_session_validated && !$ca_session_validating)
		{
			// Validamos la session. En la primer entrada, la inicializa.
			$ca_session_validating = true;
			if ( !ca_session::validate( $sidcheck))
			{
				$ca_session_validating = false;
				return false;
			}
			
			$ca_session_validating = false;
			$ca_session_validated = true;
		}

		return true;
	}


	function language_init( ) {
		
		global $ca_session_language_initialized;

		if ( !$ca_session_language_initialized) {
			
			$languageSelected = "";
			
			/* Stage 1: Language passed by GET. */
			$rlang = filter::language( varconn::GET( "l", 2));
			if ( $rlang ) {
				$languageSelected = $rlang;
			}

			/* Stage 2: Language stored in the language cookie. */
			if ( $languageSelected == "" && isset( $_COOKIE ) && is_array( $_COOKIE ) && 
					array_key_exists( DEF_COOKIE_LANGUAGE_NAME, $_COOKIE ) && 
					$_COOKIE[ DEF_COOKIE_LANGUAGE_NAME ] ) {
				$languageSelected = $_COOKIE[ DEF_COOKIE_LANGUAGE_NAME];
			}

			/* Stage 3: Language stored on the ca_session. */
			if ( $languageSelected == "" ) {
				$slang = ca_session::get( 'LANGUAGE');
				if ( $slang) {
					$languageSelected = $slang;
				}
			}
			
			/* Stage 4: Browser language. */
			if ( $languageSelected == "" ) {
				$lang = language::translate_lenguage( varconn::get_language( ), false);
				if ( $lang ) {
					$languageSelected = $lang;
					//(!)utilizar solo para hardcodear el idioma que informa el navegador
					//$languageSelected = "pt";	//esto le dice al script que el navegador
																			//esta en portugues
				}
			}

			/*
				voy a agregar una ultima stage solo para asegurarme de que jamas saldra 
				de esta funcion	sin tener como minimo el esperanto de facto seleccionado.
			*/
			if (class_exists("owner")) {
				/*
					080811
					(!)remover este comentario y el de inc/base_owner 
					si la solucion resulta valida. ->
					esta solucion se basa en la posibilidad de cargar el owner antes de 
					la inicializacion de la carga del lenguaje (ver advertencia en
					inc/base_owner si hay problemas)
					
				*/
				$lstMetodos = get_class_methods("owner");
				if ( in_array( "idiomavalido",  $lstMetodos ) ) {
					$languageSelected = owner::idiomaValido ( $languageSelected );
				}
			}
			
			//(!)No deberia ser necesario, pero hasta estar seguro...
			if ($languageSelected == "") $languageSelected = DEF_DEFAULT_LANGUAGE;
			
			$ca_session_language_initialized = ca_session::language_set( $languageSelected );
			
		}
		
		return $ca_session_language_initialized;
		
	}

	function language_set( $lang)
	{
		$lang = language::sanitize_lang( $lang);
		if ( !language::is_lang( $lang)) {
			return false;
		}

		/* Storing into the language cookie. */
		setcookie( DEF_COOKIE_LANGUAGE_NAME, false, time( ) + DEF_COOKIE_LANGUAGE_LIFETIME, COOKIE_PATH, "", COOKIE_SECURE);
		setcookie( DEF_COOKIE_LANGUAGE_NAME, $lang, time( ) + DEF_COOKIE_LANGUAGE_LIFETIME, COOKIE_PATH, "", COOKIE_SECURE);
		/* Storing into the ca_session. */

		ca_session::set( 'LANGUAGE', $lang);
		return true;
	}
	
	function language_get( )
	{
		/* Initializing the language. */
		if ( !ca_session::language_init( ) ) return false;

		/* In the initialization we save the language into the session. */
		$slang = ca_session::get( 'LANGUAGE');
		if ( language::is_lang( $slang ) ) {
			$lang = language::sanitize_lang( $slang );
			return $lang;
		}

		ca_session::language_set( DEF_DEFAULT_LANGUAGE);
        return DEF_DEFAULT_LANGUAGE;
	}
	
	/**
	 * validate - Valida la seguridad de la sesion. Principalmente checkea que
	 * la misma no haya espirado por un soft timeout, y que el ip que la registro
	 * no cambie.
	 *
	 * @return	bool	Si valida correctamente devuelve true, caso contrario, devuelve false
	 *					y se destruye la session.
	 * @access	private
	 */
	function validate( $sidcheck = false)
	{
		$initialized = ca_session::get( 'INITIALIZED');

		if ( $initialized === true)
		{
			// Ya inicializamos la session, por lo que checkeamos
			// que todo sea valido.
			
			/**
			 * -------------
			 * - Timestamp -
			 * -------------
			 */
			 
			$tstamp = ca_session::get( 'TIMESTAMP');
			$current = mktime( );

			if ( !$tstamp || !$current)
			{
				// Invalid timestamp.
				ca_session::logout( );
				return false;
			}
			
			if ( ( $current - $tstamp) > DEF_SESSION_SOFTLIMIT)
			{
				// The session has been timed out.
				ca_session::logout( );
				return false;
			}

			// We update the session timestamp.
			ca_session::set( 'TIMESTAMP', $current);

			
			/**
			 * -------------
			 * - Client IP -
			 * -------------
			 */
			$remoteip = varconn::get_remoteip( );
			$currip = varconn::get_remoteip( );

			if ( !$remoteip || !$currip)
			{
				// Invalid IP.
				ca_session::logout( );
				return false;
			}

			if ( strcmp( $remoteip, $currip) != 0)
			{
				// Hi-jacking attemp!.
				ca_session::logout( );
				return false;
			}

			/**
			 * -------
			 * - SID -
			 * -------
			 */

			if ( $sidcheck)
			{
				// Solo checkeamos sid si mandan en true el parametro
				// $sidcheck. Esto sirve para forzar el checkeo en
				// paginas que se auto-submitean o no requieren refresh
				// alguno.
				
				$sid = varconn::REQUEST( DEF_SID_PARAMNAME);
				$csid = ca_session::get( 'SID');

				if ( !$sid || !$csid)
				{
					// Invalid SID.
					ca_session::logout( );
					return false;
				}

				if ( strcmp( $sid, $csid) != 0)
				{
					// Invalid SID.
					ca_session::logout( );
					return false;
				}
			}
		}
		else
		{
			// No habiamos inicializado la session todavia.
			// La inicializo, en las concurrentes entradas a
			// esta funcion, se entrara al "if" en vez de
			// este "else".
			ca_session::set( 'TIMESTAMP', mktime( ));
			ca_session::set( 'IP', varconn::get_remoteip( ));
			ca_session::set( 'INITIALIZED', true);
		}

		// En caso de que halla validado bien el sid, o de que
		// el mismo no exista, igualmente lo regenero.
		ca_session::set( 'SID', ca_session::create_sid( ));

		// Good session.
		return true;
	}


	function rand_character( )
	{
		$c1 = rand( 48, 57);
		$c2 = rand( 65, 90);
		$c3 = rand( 97, 122);

		$c = 0;
		switch( rand( 1, 3))
		{
			case 1: $c = $c1; break;
			case 2: $c = $c2; break;
			default: $c = $c3;
		}

		return chr( $c);
	}
																			
	
	function create_sid( )
	{
		$salt = substr( ereg_replace( "[^a-zA-Z0-9./]", "", crypt( rand( 10000000, 99999999), rand( 10, 99))), 2, 2);
		$crypt1 = crypt( "cuentaalternativa", $salt);
		$crypt2 = crypt( "4l54o3hrehfiuhds8744", $salt);
		return strtoupper( sha1( $crypt1) . sha1( $crypt2));
	}

	static function is_loggedin( )
	{
		if ( ca_session::get( "LOGGEDIN") == true){
			return true;
	    }

		return false;
	}

	static function get_userid( )
	{
		if ( !ca_session::is_loggedin( ))
			return false;

		return ca_session::get( "USERID");
	}
	
	function get_customerid( )
	{
		if ( !ca_session::is_loggedin( ))
			return false;

		return ca_session::get( "customerid");
	}
	
	/**
	 * login - Checkea que un par username/password sea valido, en dicho caso, se encarga de loguear al usuario.
	 *
	 * @param	string	$username	Username.
	 * @param	string	$password	Password.
	 * @return	bool				true Upon successful completion true is returned. Otherwise, false is returned.
	 * @access	public
	 */
	function login( $username, $password)
	{
		
		$owner = "";
		$ownerId = 0;
		
		$res = user_login( $username, $password, $owner, $ownerId);
		if ( $res[0] ){
            
			ca_session::set( 'USERID', strtoupper( $username));
						
			ca_session::set( 'LOGGEDIN', true);
			ca_session::set( 'owner', $owner);
			ca_session::set( 'ownerId', $ownerId);

			return array(true);
		}else{

			return $res;
		}	
			
		
		// Parche login fallido (agregado 27/9/11)
		/*
		$contador_logines = 0;
		
		$owner = "";
		$ownerId = 0;
		
		while($contador_logines < 10){
		
			if ( user_login( $username, $password, $owner, $ownerId))
			{
				ca_session::set( 'USERID', strtoupper( $username));
				ca_session::set( 'LOGGEDIN', true);
				ca_session::set( 'owner', $owner);
				ca_session::set( 'ownerId', $ownerId);
				
				return true;
			}	
			$contador_logines++;
		}

		return false;
		*/
	}

    /**
	 * login_by_activation - If the e-mail of this user is not yet verified, then we loggin the
     * user automatically, (without a passowrd). This is usefull when the user clicks the
     * e-mail confirmation button for the first time only... for the another clicks, the login
     * screen will be showed.
	 *
	 * @param	string	$user_id	The username.
	 * @return	bool				true Upon successful completion true is returned. Otherwise, false is returned.
	 * @access	public
	 */
    function login_by_activation( $user_id) {
    	
        $user_id = strtoupper( trim( $user_id));
        $profile = new profile( $user_id);

        $owner = null;
		$ownerId = 0;
        if ( !user_login_no_password( $user_id, $owner, $ownerId))
            return false;
        
        if ( !$profile->is_mail_verif( ))
        {
			ca_session::set( 'USERID', $user_id);
			ca_session::set( 'LOGGEDIN', true);
			ca_session::set( 'owner', $owner);
			ca_session::set( 'ownerId', $ownerId);
			
            return true;
        }

		ca_session::set( 'owner', $owner);
        return false;
    }

	/**
	 * logout - Desloguea al usuario destruyendo la session.
	 *
	 * @return	bool				true Upon successful completion true is returned. Otherwise, false is returned.
	 * @access	public
	 */
	function logout( )
	{
		if ( !ca_session::init( ))
			return false;

		if( !ca_session::destroy_session( ))
			return false;
		
		return true;
	}


	/**
	 * set - Setea la variable "key" con valor "value" dentro de la sesion.
	 *
	 * @param	string	$key	Key.
	 * @param	string	$value	Value.
	 * @return	bool			true Upon successful completion true is returned. Otherwise, false is returned.
	 * @access	public
	 */
	function set( $key, $value)
	{


		if ( $value === null)
			return false;
			
		if( !ca_session::init( ))
			return false;
		

		$_SESSION[ $key] = $value;

		return true;
	}

	
	/**
	 * get - Devuelve el valor de la variable de sesion "key".
	 *
	 * @param	string	$key	Key.
	 * @return	mixed			EL valor de la variable, o null en caso de error o no existencia.
	 * @access	public
	 */
	static function get( $key)
	{

		if ( !ca_session::init( ))
			return null;

		if ( array_key_exists( $key, $_SESSION) && isset( $_SESSION[ $key]))
			return $_SESSION[ $key];

		return null;
	}

	
	/**
	 * destroy - Elimina una variable identificada por "key" de la sesion.
	 *
	 * @param	string	$key	Key.
	 * @return	bool			true Upon successful completion true is returned. Otherwise, false is returned.
	 * @access	public
	 */
	function destroy( $key)
	{
		if ( !ca_session::init( ))
			return false;

		if ( array_key_exists( $key, $_SESSION) && isset( $_SESSION[ $key]))
			unset( $_SESSION[ $key]);

		return true;
	}

	
	/**
	 * destroy_keys - Elimina todas las variables de sesion.
	 *
	 * @return	bool			true Upon successful completion true is returned. Otherwise, false is returned.
	 * @access	public
	 */
	function destroy_keys( )
	{
		if ( !ca_session::init( ))
			return false;

		if ( @isset( $_SESSION) && @is_array( $_SESSION))
		{
			foreach( $_SESSION as $key => $value)
				unset( $_SESSION[ $key]);

			unset( $_SESSION);
		}

		return true;
	}

	/**
	 * destroy_session - Elimina la sesion en si.
	 *
	 * @return	bool			true Upon successful completion true is returned. Otherwise, false is returned.
	 * @access	public
	 */
	function destroy_session( )
	{
		global $ca_session_initialized;
		global $ca_session_validated;
		global $ca_session_validating;
		
		if ( !ca_session::init( ))
			return false;

		session_destroy( );
		if ( !ca_session::destroy_keys( ))
			return false;
			
		unset( $_COOKIE[ session_name( )]);

		$ca_session_initialized = false;
		$ca_session_validated = false;
		$ca_session_validating = false;
		
		return true;
	}
}

?>

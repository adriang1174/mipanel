<?

define('NOMBRE_DB', 'ra_cuenta');

define( 'DEF_DEFAULT_LANGUAGE', "es");
define( 'DEF_INCLUDE_EXTENSION', "php");
define( 'DEF_LANGUAGE_CONST_PREFIX', "TPL_");
define( 'DEF_LANGUAGE_OWNER_CONST_PREFIX', "OWNER_");
define( 'DEF_COOKIE_LANGUAGE_NAME', "ca_language");
define( 'DEF_COOKIE_LANGUAGE_LIFETIME', 60 * 60 * 24 * 365);
define( 'DEF_SESSION_SOFTLIMIT', 60 * 20);
define( 'DEF_SESSION_HARDLIMIT', 60 * 30);
define( 'DEF_SID_PARAMNAME', "sid");
define( 'DEF_DEFAULT_TEMPLATE', "default");
define( "DEF_CHARSET", "ISO-8859-1");
define( "DEF_BIGLIMIT", 1048576);

define( 'DEF_SMTP_HOST', "localhost");
define( 'DEF_SMTP_PORT', 25);

$DEF_PAGINATION_LIMITS = array(
	array( "limit" => 10, "default" => false),
	array( "limit" => 20, "default" => false),
	array( "limit" => 50, "default" => true),
	array( "limit" => 100, "default" => false),
	array( "limit" => 200, "default" => false),
	array( "limit" => 500, "default" => false),
	array( "limit" => 1000, "default" => false)
);

define( 'DEF_CA_SECRET', "ca*!#123");
define( 'DEF_EML_CONFIRM_SECRET', "pocho*ohcop!128!(");

define( 'DEF_GOLDMINE_EMAIL_PREFIX', '{$GM-WEBIMPORT$}<');
define( 'DEF_GOLDMINE_EMAIL_SUFIX', '>');

define( 'DEF_GOLDMINE_EMAIL', "importaciongm@grupoalternativa.com");
define( 'DEF_SERVICES_EMAIL', "asistencia@grupoalternativa.com");
define( 'DEF_HARDCODED_USER_EMAIL', false);

?>

<?php
$servDesarrollo = false;
if ($servDesarrollo) {

	$barraSep = "\\";
	//path base para la funcion move_uploaded_file
	$basePath = "C:\\Inetpub\\virtuals\\paypal.alternativa.des\\html\\beta-cuenta\\owner\\";	
	//path base para el display final de imagenes (path de copy+paste utilizado en el tiny_mce	
	$baseURL = "http://paypal.alternativa.des:90/html/beta-cuenta/owner/";	
	//cn	
	$conn = pg_connect("host=localhost port=5432 dbname=ra_cuenta user=promaker password=promaker");

} else {
	
	$barraSep = "/";
	$basePath = "/home/httpd/zonasegura.grupoalternativa.com/html/cuenta/owner/";
	$baseURL = "https://webseg.alternativa.com.ar/cuenta/owner/";
	$conn = pg_connect("host=201.216.230.78 port=5432 dbname=ra_cuenta user=site_cuenta  password=cuenta*111");
	
}
if (!$conn) die("imposible establecer conexion con el servidor.");
?>

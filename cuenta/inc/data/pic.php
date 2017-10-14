<?
require_once(INCLUDE_PATH . "db.php");

class pic
{
	var $userid;
	var $mercado;
	
	function pic( $userid, $mercado)
	{
		$this->userid = $userid;
		$this->mercado = $mercado;
	}
	
	/*
	26/03/09: Necesidad de multi-idioma forzó a ingresar constantes en la DB, y el método tuvo que ser adaptado a ésto
	function get_services( )
	{
        db::init();
        $query = "select id_servicio, servicio from servicios where mercado = '$this->mercado' and estado = 1";
        return db::get_rows_as_array_of_hashes($query);
	}*/
	
	function get_services( )
	{
        db::init();
        $query = "select id_servicio, servicio AS servicio_tpl from servicios where mercado = '$this->mercado' and estado = 1";
        $services = db::get_rows_as_array_of_hashes($query);
		for ($i = 0; $i < count($services); $i++) {
			$services[$i]['servicio'] = constant($services[$i]['servicio_tpl']);
		}
		
		return $services;
	}

   /* 
	26/03/09: Necesidad de multi-idioma forzó a ingresar constantes en la DB, y el método tuvo que ser adaptado a ésto
   function get_param_by_service($serviceid)
    {
        db::init();
        $query = "select parametro_titulo, parametro_texto from parametros_servicio where id_servicio = '$serviceid'";
        return db::get_rows_as_array_of_hashes($query);
    }*/
		
	function get_param_by_service($serviceid)
    {
        db::init();
        $query = "select parametro_titulo AS titulo, parametro_texto AS texto from parametros_servicio where id_servicio = '$serviceid'";
        $params = db::get_rows_as_array_of_hashes($query);
		for ($i = 0; $i < count($params); $i++) {
			$params[$i]['parametro_titulo'] = constant($params[$i]['titulo']);
			$params[$i]['parametro_texto'] = constant($params[$i]['texto']);
		}
		
		return $params;
    }
}
?>

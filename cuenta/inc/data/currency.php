<?

require_once( INCLUDE_PATH . "db.php");

class ca_currency
{
	var $id;
	var $description;
	var $symbol;

	function ca_currency()
	{
	}

	static function get_customer_currency($clientid)
	{
		db::init();
		$query = "select moneda_id from clientes c, mercados m where c.mercado = m.mercado and cliente_id = '$clientid'";
		$moneda_id = db::get_row_as_scalar($query);
		$query = "select * from monedas where moneda_id = '$moneda_id'";
		$moneda = db::get_rows_as_hash($query);
		$obj = new ca_currency();
		$obj->id = $moneda['moneda_id'];
		$obj->description = $moneda['descripcion'];
		$obj->symbol = $moneda['simbolo'];
		return $obj;
	}

	static function get_quotation_by_idDate($currencyid, $date)
	{        
		db::init();

        $matches = array( );
        if ( preg_match( "/^([0-9]{2})\\/([0-9]{2})\\/([0-9]{4})$/", $date, $matches))
            $date = $matches[ 3] . "-" . $matches[ 2] . "-" . $matches[ 1];

		$query_before = "select * from cotizaciones where moneda_id = $currencyid and fecha <= '$date' order by fecha desc limit 1";
		$query_after = "select * from cotizaciones where moneda_id = $currencyid and fecha > '$date' order by fecha asc limit 1";
        
		if(($moneda = db::get_rows_as_hash($query_before)) == NULL )
		{
		  if(($moneda = db::get_rows_as_hash($query_after)) == NULL )
		    return NULL;
		}
        
	 	return $moneda;
	}
    
    function get_last_quotation_by_id($currencyid)
    {
		db::init();
        $query = "select * from cotizaciones where moneda_id = $currencyid order by fecha desc limit 1";
        $moneda = db::get_rows_as_hash($query);
	 	return $moneda;
    }
    
	function get_quotation_by_id($currencyid)
	{
		db::init();
		$query = "select * from cotizaciones where moneda_id = ? order by fecha desc limit 1";
		return db::get_rows_as_hash($query_before);
	}
}

?>

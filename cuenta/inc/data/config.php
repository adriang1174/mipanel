<?  
require_once( INCLUDE_PATH . "db.php");
require_once("currency.php");

class ca_config
{
	var $clientid;

	function ca_config($clientid)
	{
		$this->clientid = $clientid;
	}

	function SetValue($key, $value)
	{
		db::init();
		$qsel = "select count(*) from cliente_config where cliente_id = '".$this->clientid."' and clave = '$key'";
		$qins = "insert into cliente_config (cliente_id, clave, valor) values ('".$this->clientid."', '$key', '$value')";
		$qupd = "update cliente_config set valor = '$value' where cliente_id = '".$this->clientid."' and clave = '$key'";

		if(db::get_row_as_scalar($qsel) > 0)
			return db::DoIt($qupd);
		else
			return db::DoIt($qins);
	}
	function GetValue($key)
	{
		db::init();
		$query = "select valor from cliente_config where cliente_id = '".$this->clientid."' and clave = '$key'";
		return db::get_row_as_scalar($query);
	}

	function GetCustomerCurrency( )
	{
		$ca_currency = new ca_currency( );
		$curr = $ca_currency->get_customer_currency( $this->clientid);
		switch( $curr)
		{
			case 1: return "USD";
			case 2: return "ARS";
		}

		return false;
	}
	
	function GetAll( )
	{
		return array(
			"receive_report" => $this->GetValue( "InformeConsumos"),
			"receive_alert" => $this->GetValue( "AlertaConsumos"),
			"limit_minutes" => $this->GetValue( "AlertaConsumos_LimiteMinutos"),
			"limit_price" => $this->GetValue( "AlertaConsumos_LimiteImporte"),
			"receive_detail" => $this->GetValue( "DetalleConsumo"),
			"receive_image" => $this->GetValue( "ImagenFactura")
		);
	}

	function SetAll( $receive_report, $receive_alert, $limit_minutes, $limit_price, $receive_detail, $receive_image)
	{
		$aff_rows = 0;
		$aff_rows += $this->SetValue( "InformeConsumos", $receive_report ? "1" : "0");
		$aff_rows += $this->SetValue( "AlertaConsumos", $receive_alert ? "1" : "0");
		$aff_rows += $this->SetValue( "AlertaConsumos_LimiteMinutos", ( int)$limit_minutes);
		$aff_rows += $this->SetValue( "AlertaConsumos_ImporteMoneda", $this->GetCustomerCurrency( ));
		$aff_rows += $this->SetValue( "AlertaConsumos_LimiteImporte", ( float)$limit_price);
		$aff_rows += $this->SetValue( "DetalleConsumo", $receive_detail ? "1" : "0");
		$aff_rows += $this->SetValue( "ImagenFactura", $receive_image ? "1" : "0");

		return ( $aff_rows ? true : false);
	}
}


?>

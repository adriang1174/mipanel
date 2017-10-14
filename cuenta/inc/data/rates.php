<?
require_once( INCLUDE_PATH . "db.php");

class rates_account_item
{
	var $service;
	var $number;
	var $source;
	var $service_name;

	function rates_account_item( $service, $number, $source, $service_name)
	{
		$this->service = $service;
		$this->number = $number;
		$this->source = $source;
		$this->service_name = $service_name;
	}
}

class rates_item
{
	var $prefix;
	var $target;
	var $rate;
	var $special;
	var $vigency_from;
	var $vigency_to;
    var $recharge;

	function rates_item( $prefix, $target, $rate, $special, $vigency_from, $vigency_to, $recharge)
	{
		$this->prefix = $prefix;
		$this->target = $target;
		$this->rate = $rate;
		$this->special = $special;
		$this->vigency_from = $vigency_from;
		$this->vigency_to = $vigency_to;
        $this->recharge = $recharge;
	}
}

class rates
{
	var $userid;
	
	function rates( $userid)
	{
		$this->userid = $userid;
	}

	function get_accounts( )
	{
	  db::init();
	  //$query = "select servicio, login, origen from cuentas where cliente_id = '".$this->userid."' and codigoplan is not null order by servicio";
	  
	  $query = "SELECT c.servicio, c.login, c.origen, COALESCE(sc.servicio, c.servicio) as nombre_servicio
				FROM cuentas c
				LEFT JOIN servicios_conf sc ON c.id_servicio = sc.id_servicio
				WHERE cliente_id = '".$this->userid."' AND codigoplan is not null 
				ORDER BY nombre_servicio";
	 //echo $query;
	  $accounts = db::get_rows_as_array($query);

	  $out = array();

	  foreach ($accounts as $account)
		  $out[] = new rates_account_item( $account[0], $account[1], $account[2], utf8_decode($account[3]));

	  return $out;
	  
	}
	
	function get_rates( $account_id, $account_service, $filter_by_target, $filter_by_prefix, $offset, $limit, &$is_last, $get_total, &$total)
	{
		db::init();
        
		// Get account attrib
		$query_account = "select * from cuentas where servicio = '$account_service' and login = '$account_id'";
		$accounts = db::get_rows_as_array_of_hashes($query_account);
		$account = $accounts[0];

		// Get common rates
        if($filter_by_prefix)
		    $query = "select *, to_char(fechadesde, 'DD/MM/YYYY') as fechadesde_format from plantarifas where codigoplan = '".$account['codigoplan']."' and banda = '0' and origen = '".$account['origen']."' and destino like '".$filter_by_prefix."%' order by destino";
        else if($filter_by_target)
    		$query = "select *, to_char(fechadesde, 'DD/MM/YYYY') as fechadesde_format from plantarifas where codigoplan = '".$account['codigoplan']."' and banda = '0' and origen = '".$account['origen']."' and '".$filter_by_target."' like destino || '%' order by destino desc limit 1";
        else
	    	$query = "select *, to_char(fechadesde, 'DD/MM/YYYY') as fechadesde_format from plantarifas where codigoplan = '".$account['codigoplan']."' and banda = '0' and origen = '".$account['origen']."' order by destino";
	    	
	    	

	  	$rates_common = db::get_rows_as_array_of_hashes($query);

//echo $query;
		// Get special rates
        if($filter_by_prefix)
		    $query = "select *, to_char(fechadesde, 'DD/MM/YYYY') as fechadesde_format, to_char(fechahasta, 'DD/MM/YYYY') as fechahasta_format from tarifasespeciales where id_cliprod = '".$account['id_cliprod']."' and fechadesde <= now() and fechahasta >= now() and destino like '".$filter_by_prefix."%' order by destino";
        else if($filter_by_target)
    		$query = "select *, to_char(fechadesde, 'DD/MM/YYYY') as fechadesde_format, to_char(fechahasta, 'DD/MM/YYYY') as fechahasta_format from tarifasespeciales where id_cliprod = '".$account['id_cliprod']."' and fechadesde <= now() and fechahasta >= now() and '".$filter_by_target."' like destino || '%' order by destino desc limit 1";
        else
	    	$query = "select *, to_char(fechadesde, 'DD/MM/YYYY') as fechadesde_format, to_char(fechahasta, 'DD/MM/YYYY') as fechahasta_format from tarifasespeciales where id_cliprod = '".$account['id_cliprod']."' and fechadesde <= now() and fechahasta >= now() order by destino";
	  	$rates_special = db::get_rows_as_array_of_hashes($query);

		$rates_merge = array();

        if($rates_common)
    		foreach($rates_common as $rate)
	    	{
			    $dest = $rate['destino'];
		    	$rates_merge[$dest]['destino'] = $rate['destino'];
    			$rates_merge[$dest]['destinotxt'] = $rate['destinotxt'];
	    		$rates_merge[$dest]['moneda'] = $rate['moneda'];
		    	$rates_merge[$dest]['tarifa'] = $rate['tarifa'];
			    $rates_merge[$dest]['especial'] = 0;
    			$rates_merge[$dest]['fechadesde'] = $rate['fechadesde_format'];
	    		$rates_merge[$dest]['fechahasta'] = '';
	    		$rates_merge[$dest]['recargo'] = $rate['recargocelular'];
    		}
		
        if($rates_special)
    		foreach($rates_special as $rate)
	    	{
			    $dest = $rate['destino'];
		    	$rates_merge[$dest]['destino'] = $rate['destino'];
    			$rates_merge[$dest]['destinotxt'] = $rate['destinotxt'];
	    		$rates_merge[$dest]['moneda'] = $rate['moneda'];
		    	$rates_merge[$dest]['tarifa'] = $rate['tarifa'];
			    $rates_merge[$dest]['especial'] = 1;
    			$rates_merge[$dest]['fechadesde'] = $rate['fechadesde_format'];
	    		$rates_merge[$dest]['fechahasta'] = $rate['fechahasta_format'];
	    		$rates_merge[$dest]['recargo'] = '';
    		}
    		
    		
		sort($rates_merge, SORT_NATURAL);
		
		

		if($get_total)
		{
			$total = count($rates_merge);
			if($total - ($offset + $limit) < 0)
				$is_last = true;
		}
		
		if($is_last)
		{
			// no totals
		}
		
		$rates_pag = array_slice( $rates_merge, $offset, $limit);
		$out = array();
		foreach($rates_pag as $rate)
        {
            $recargo = "";
            if($rate['recargo'])
            {
                $recargo = $rate['moneda'] ." ". $rate['recargo'];
            }
			$out[] = new rates_item( $rate['destino'], $rate['destinotxt'], $rate['moneda'] ." ". $rate['tarifa'], $rate['especial'], $rate['fechadesde'], $rate['fechahasta'], $recargo);
        }
		return $out;	
	}
}

?>

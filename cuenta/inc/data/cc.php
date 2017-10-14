<?
require_once( INCLUDE_PATH . "db.php");
require_once("user.php");
require_once("currency.php");

define('IDENTIFIER_RECIBO', 'R');
define('IDENTIFIER_FACTURA', 'F');
define('IDENTIFIER_NDC', 'C');

class cc_detail_item
{
    var $date;
    var $receipt;
    var $expiration;
    var $negative;
    var $positive;
    var $balance;
    var $detail;
    function cc_detail_item($date, $receipt, $expiration, $negative, $positive, $balance, $detail)
    {
        $this->date = $date;
        $this->receipt = $receipt;
        $this->expiration = $expiration;
        $this->negative = $negative;
        $this->positive = $positive;
        $this->balance = $balance;
        $this->detail = $detail;
    }
}

class ca_cc
{
	var $clientid;
	var $moneda;
	var $saldo_inicial = FALSE;
	var $saldo_final = FALSE;
	var $saldo_parcial = FALSE;
	
    var $start_date;
    var $end_date;

	var $saldo_recibos;
	var $saldo_facturas;
	
	var $cc_detail_list;

    var $userdata;
	
	function ca_cc($clientid, $start_date, $end_date)
	{
		$this->clientid = $clientid;
		$this->moneda = ca_currency::get_customer_currency($clientid);

		$this->saldo_recibos = 0.0;
		$this->saldo_facturas = 0.0;

		$this->start_date = $start_date;
		$this->end_date =  $end_date;

        $this->userdata = new user($clientid);
	}
	
	function cc_moves_by_IdDate($date_start, $date_end)
	{
		db::init();
		$query = "select cliente_id, tipodoc, sucdoc, numdoc, to_char(fechemision, 'DD/MM/YYYY') as fechemision, to_char(fechvto, 'DD/MM/YYYY') as fechvto, importe, usuario, last_update, programa, moneda_id, cotizacion, fechemision as fechemision2  from cc where cliente_id = '$this->clientid' and fechemision > '$date_start' and fechemision <= '$date_end' order by fechemision2";
		
		
				
		return db::get_rows_as_array_of_hashes($query);
	}

	function cc_is_factura($move)
	{
		if(substr($move['tipodoc'], 0, 1) == IDENTIFIER_FACTURA || substr($move['tipodoc'], 0, 1) == 'D' )
			return TRUE;
	}
	
	function cc_is_ndc($move)
	{
		if(substr($move['tipodoc'], 0, 1) == IDENTIFIER_NDC)
			return TRUE;
	}

	function cc_is_recibo($move)
	{
		if(substr($move['tipodoc'], 0, 1) == IDENTIFIER_RECIBO || substr($move['tipodoc'], 0, 2) == 'Ri' )
			return TRUE;
	}
	
	function cc_sum_recibos($date)
	{
		db::init();
		$query = "select importe, moneda_id, cotizacion, fechemision from cc where cliente_id = '$this->clientid' and fechemision <= '$date' and (substring(tipodoc from 1 for 1) = '". IDENTIFIER_RECIBO ."' OR substring(tipodoc from 1 for 1) = 'Ri')";


		$recibos = db::get_rows_as_array_of_hashes($query);
		foreach($recibos as $recibo)
		{
			if($this->moneda->id == $recibo['moneda_id'])
			{
			  $this->saldo_recibos += $recibo['importe'];
			}
			else
			{
				$quotation_customer = ca_currency::get_quotation_by_idDate($this->moneda->id, $recibo['fechemision']);
				if($quotation_customer != NULL)
				{
					$quotation = $recibo['cotizacion'] / $quotation_customer['cotizacion'];
					$this->saldo_recibos += ($recibo['importe'] * $quotation);
				}
			}
		}
		//echo $this->saldo_recibos;
		return $this->saldo_recibos;
	}

	function cc_sum_facturas($date)
	{
		db::init();
		$query = "select importe, moneda_id, cotizacion, fechemision from cc where cliente_id = '$this->clientid' and fechemision <= '$date' and (substring(tipodoc from 1 for 1) = '". IDENTIFIER_FACTURA ."' OR substring(tipodoc from 1 for 1) = 'D' OR substring(tipodoc from 1 for 1) = '". IDENTIFIER_NDC ."')";
		//echo $query;
		$facturas = db::get_rows_as_array_of_hashes($query);
		
		foreach($facturas as $factura)
		{
			if($this->moneda->id == $factura['moneda_id'])
			{
			  $this->saldo_facturas += $factura['importe'];
			}
			else
			{
				$quotation_customer = ca_currency::get_quotation_by_idDate($this->moneda->id, $factura['fechemision']);
				if($quotation_customer != NULL)
				{
					$quotation = $factura['cotizacion'] / $quotation_customer['cotizacion'];
					$this->saldo_facturas += ($factura['importe'] * $quotation);
				}
			}
		}
		return $this->saldo_facturas;
	}
	
	function cc_calculate_saldo_inicial($date)
	{
		$this->cc_sum_recibos($date);
		$this->cc_sum_facturas($date);
		
		

		return sprintf("%.2f", $this->saldo_facturas - $this->saldo_recibos, 2);
	}

	function cc_calculate_saldo_final($date, $date_end)
	{
		$moves = $this->cc_moves_by_IdDate($date, $date_end);
		$this->saldo_final = $this->cc_get_saldo_inicial($date);

		foreach($moves as $move)
		{

			if($this->cc_is_recibo($move))
				$this->saldo_final -= $this->cc_move_quotation_adjust($move);
			else if($this->cc_is_factura($move))
				$this->saldo_final += $this->cc_move_quotation_adjust($move);
			else if($this->cc_is_ndc($move))
				$this->saldo_final += $this->cc_move_quotation_adjust($move);
			else
			{
				// Unknow type
			}
		}
		return sprintf("%.2f", $this->saldo_final, 2);
	}
	
	function cc_get_saldo_inicial($date)
	{
		if($this->saldo_inicial === FALSE){
			$this->saldo_inicial =  $this->cc_calculate_saldo_inicial($date);
		}

		return $this->saldo_inicial;
	}

	function cc_get_saldo_final($date, $date_end)
	{
		if($this->saldo_final === FALSE)
			$this->saldo_final = $this->cc_calculate_saldo_final($date, $date_end);

		return $this->saldo_final;
	}
	
	function cc_move_quotation_adjust($move)
	{	
		if($this->moneda->id == $move['moneda_id'])
		{
			return $move['importe'];
		}
		else
		{
			$quotation_bydate = ca_currency::get_quotation_by_idDate($this->moneda->id, $move['fechemision']);
			if($quotation_bydate != NULL)
			{
			
    			if ($quotation_bydate['cotizacion'] == 0){
    			    return 0.00;
    			}
			
				$quotation = $move['cotizacion'] / $quotation_bydate['cotizacion'];
				$mymove = number_format($move['importe'] * $quotation, 2);
                if(abs($mymove) < 0.01)
                  return 0.00;
                else
                  return $mymove;
			}
		}
	}

	function cc_get_detail_list($date_start, $date_end)
	{
		$moves = $this->cc_moves_by_IdDate($date_start, $date_end);

		$this->cc_detail_list = array();

		$this->saldo_parcial = $this->cc_get_saldo_inicial($date_start);

		foreach($moves as $move)
		{   
            $itemid = $this->cc_format_move_id($move['tipodoc'], $move['sucdoc'], $move['numdoc']);
            $detail = FALSE;
			if(($this->cc_is_factura($move) || $this->cc_is_ndc($move)))
			{
			
                if($this->userdata->get_ticket($itemid))
                    $detail = TRUE;
                
                $this->saldo_parcial += $this->cc_move_quotation_adjust($move);
                if(abs($this->saldo_parcial) < 0.01)
                  $this->saldo_parcial = 0;
                  $this->cc_detail_list[] = new cc_detail_item($move['fechemision'], $this->cc_format_move_id($move['tipodoc'], $move['sucdoc'], $move['numdoc']), $move['fechvto'], $this->cc_move_quotation_adjust($move), '', $this->saldo_parcial, $detail);
			}
			else if($this->cc_is_recibo($move))
			{

                if($this->userdata->get_receipt($itemid))
                    $detail = TRUE;
                
                $this->saldo_parcial -= $this->cc_move_quotation_adjust($move);
                if(abs($this->saldo_parcial) < 0.01)
                  $this->saldo_parcial = 0;
                  $this->cc_detail_list[] = new cc_detail_item($move['fechemision'], $this->cc_format_move_id($move['tipodoc'], $move['sucdoc'], $move['numdoc']), $move['fechvto'], '', $this->cc_move_quotation_adjust($move), $this->saldo_parcial, $detail);
			}
		}

		return $this->cc_detail_list;
	}

	function cc_format_move_id($tipodoc, $sucdoc, $numdoc)
	{
		return ($tipodoc."-".str_pad($sucdoc, 4, '0', STR_PAD_LEFT)."-".str_pad($numdoc, 8, '0', STR_PAD_LEFT));
	}
}


?>

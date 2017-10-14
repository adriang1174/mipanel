<?
require_once( INCLUDE_PATH . "db.php");

class traff_agrupation
{
	var $title;			 // El titulo de la agrupacion.
	var $agrupation;	 // Array de "traff_agrupation".
	var $items;			 // Array de "traff_detail_item" o "traff_summary_item" (dependiendo quien use la agrupacion).
	var $count;			 // Por ejemplo, para un detalle, se usa para la duracion total de todas las llamadas del grupo.
	var $subtotal;		 // El subtotal (precio) de la agrupacion.
	var $segment_header; // TRUE cuando contiene el 1er item del segmento (agrupacion).
	var $segment_footer; // TRUE cuando contiene el ultimo item del segmento (agrupacion).
    var $symbol;
}

class traff_detail_item
{
	var $date;
	var $hour;
	var $source;
	var $called;
	var $target;
	var $duration;
    var $symbol;
	var $price;

	function traff_detail_item( $date, $hour, $source, $called, $target, $duration, $price)
	{
		$this->date = $date;
		$this->hour = $hour;
		$this->source = $source;
		$this->called = $called;
		$this->target = $target;
		$this->duration = $duration;
		$this->price = $price;
	}
}

class traff_detail
{
	var $agrupation;	// Array de "traff_agrupation"
	var $items;			// Array de "traff_detail_item" no agrupados (usar este cuando directamente no hay arupacion).
	var $total_duration;
	var $total_price;
}

class traff_summary_item
{
	var $title;
	var $calls;
	var $duration;
    var $symbol;
	var $price;

	function traff_summary_item( $title, $calls, $duration, $price)
	{
		$this->title = $title;
		$this->calls = $calls;
		$this->duration = $duration;
		$this->price = $price;
	}
}

class traff_summary
{
	var $agrupation;	// Array de "traff_agrupation"
	var $items;			// Array de "traff_summary_item" no agrupados (usar este cuando directamente no hay arupacion).
	var $total_calls;
	var $total_duration;
	var $total_price;
}


function get_customer_lines_pids($clientid)
{
	db::init();
	/*
	$query = "select (th.tiposervicio || ' ' || th.linea) as tlinea from trafico th ";
	$query .= "where ";
	$query .= "th.cliente_id = '$clientid' ";
	$query .= "group by tlinea";
	*/ 
	
	// Cambiada el 19/01/10
	$query = "select (th.tiposervicio || ' ' || th.linea) as tlinea 
				from trafico th 
				where th.cliente_id = '". $clientid ."' 
				union
				select (th.tiposervicio || ' ' || th.linea) as tlinea 
				from traficohistorico th 
				where th.cliente_id = '". $clientid ."' group by tlinea;";
	
	return db::get_rows_field_as_array($query);
}

function calculate_offset($offset, $limit)
{
	$q_offset = $offset>0 ? ($offset-1) : 0;
    $q_limit = $offset>0 ? ($limit+2) : ($limit+1);
	return array($q_offset, $q_limit);
}

function calculate_array_slice($traff, $offset, $is_last, &$item_header, &$item_footer)
{
	$c_items = count($traff);
	$myoffset = 0;
	$mylen = $c_items;

	if($offset == 0)
	{
		$item_header = false;
	}
	else
	{
		$myoffset = 1;
		$mylen--;
		$item_header = $traff[0];
	}

	if($is_last)
	{
		$item_footer = false;
	}
	else
	{
		$mylen--;
		$item_footer = $traff[$c_items-1];
	}

	return array_slice($traff, $myoffset, $mylen);
}

function get_where_by_filter($clientid, $pinid, $dialednumber, $datefrom, $dateto)
{
	$wheredata = "th.cliente_id = '$clientid' ";

	if($pinid)
		$wheredata .= "and th.linea = '$pinid' ";
	if($dialednumber)
		$wheredata .= "and th.destino = '$dialednumber' ";
	if($datefrom)
		$wheredata .= "and th.fecha >= '$datefrom' ";
	if($dateto)
		$wheredata .= "and th.fecha <= '$dateto' ";

	return $wheredata;
}

function traff_nf_execute_report($report_type, $fields, $query, $querysum, $querycount, $agrupate, $counters, $offset, $limit, &$is_last, $get_total, &$total)
{
	db::init();
	$item_header = false;
	$item_footer = false;

	//echo "DATA: " . var_export($query, true) . "<hr />";
	//echo $query->render() . "<hr />";
	
	// Recalculo el offset y limit.
	list($q_offset, $q_limit) =  calculate_offset($offset, $limit);

	// Calculando el total de items si es necesesario.
	if($get_total)
	{
		if($querycount->where == false)
			$querycount->where = $wheredata;
	
		if(is_detail_report($report_type))
			$total = db::get_row_as_scalar($querycount->render());
		else if(is_summary_report($report_type))
			$total = count(db::get_rows_as_array($querycount->render()));

		if($total - ($offset + $limit) < 0)
			$is_last = true;
	}

	// Parto todo el resultado.
	// var_dump($query->render());
	// exit();
	
//echo $query->render(); PARA VER LA QUERY !!!!

	$traff_all = db::get_rows_as_array_of_hashes($query->render());
	/*
	echo "<pre>";
	print_r($traff_all);
	echo "</pre>";
	*/
	
	$traff = array_slice( $traff_all, $q_offset, $q_limit);

	// Es un resutlado valido?.
	if(!is_array($traff) || count($traff)<=0)
		return false;

	$traff = calculate_array_slice($traff, $offset, $is_last, $item_header, $item_footer);

	// Si hay agrupacion, pido el objeto de trafico a traff_detail_agrupate, sino se lo
	// pido a traff_detail_nonagrupate. Estas son funciones mellizas, e intercambiables una
	// por otra.
	if ( is_array( $agrupate) && count( $agrupate) > 0 && $agrupate[ 0])
		$traff_detail = traff_detail_agrupate( $report_type, $fields, $traff_all, $traff, $is_last, $item_header, $item_footer, $agrupate, $counters);
	else
		$traff_detail = traff_detail_nonagrupate( $report_type, $fields, $traff);
	
	if($is_last)
	{
		if($querysum->where == false)
			$querysum->where = $wheredata;
	
		$totals = db::get_rows_as_array($querysum->render());
		if(is_detail_report($report_type))
		{
			$traff_detail->total_duration = $totals[0][0];
			$traff_detail->total_price = $traff[0]['moneda']." ".$totals[0][1];
		}
		else if(is_summary_report($report_type))
		{
			$traff_detail->total_calls = $totals[0][0];
			$traff_detail->total_price = $totals[0][1];
			$traff_detail->total_duration = $totals[0][2];
		}
	}

	return $traff_detail;
}

function is_detail_report($report_type)
{
	if($report_type == 0)
		return true;

	return false;
}

function is_summary_report($report_type)
{
	if($report_type == 1)
		return true;

	return false;
}

// $agrupation	Objeto de agrupacion (por referencia), es donde se haran todas las sumas.
// $offset		Ultimo elemento del segmento.
// $groupby		Field unico de agrupacion.
// $countby		Array (con length 1 o 2) de fields a sumar.

function traff_agrupate_subtotals( &$agrupation, $traff_all, $offset, $groupby, $countby)
{
	if( !is_array($countby) ||( count($countby) != 1 && count($countby) != 2))
		return false;

	// Reseteo los contadores de $agrupation.
	$agrupation->count = count($countby)==2 ? array(0, 0) : array(0);
	$agrupation->subtotal = 0;

	$c_groupby = $traff_all[ $offset][ $groupby];
	
	for( $n = $offset; $n >= 0; $n --)
	{
		$item = $traff_all[ $n];
	
		if( $c_groupby != $item[ $groupby])
		{
			// Cambio la agrupacion. Este elemento ya no lo consideramos.
			break;
		}

		// Sumamos los contadores.
		$agrupation->subtotal += ( float)$item['importe'];
		$agrupation->count[0] += ( float)$item[$countby[0]];
		if(count($countby) == 2)
			$agrupation->count[1] += ( float)$item[$countby[1]];
	}

	return true;
}

function traff_detail_agrupate($report_type, $fields, $traff_all, $traff, $is_last, $item_header, $item_footer, $groupby, $countby)
{
	// Checking the integrity of the params.
	$groupby_count = count($groupby);
	if ( $groupby_count != 1 && $groupby_count != 2)
		return false;
	if ($report_type != 0 && $report_type != 1)
		return false;
	if(!is_array($countby) ||( count($countby) != 1 && count($countby) != 2))
		return false;

	// Some initialization stuff.
	if(is_detail_report($report_type))
		$nfcc_traff = new traff_detail();
	else if(is_summary_report($report_type))
		$nfcc_traff = new traff_summary();
	
	$nfcc_traff->agrupation = array();
	
	$traff_items_count = count($traff);
	$nfcc_level_index = 0;
	$nfcc_level_index_2 = 0;

	$c_groupby = $traff[0][$groupby[0]];
	if($groupby_count == 2)
		$c_groupby_2 = $traff[0][$groupby[1]];
	
	$nfcc_traff->agrupation[$nfcc_level_index] = new traff_agrupation();
	$nfcc_traff->agrupation[$nfcc_level_index]->title = $c_groupby;
	$nfcc_traff->agrupation[$nfcc_level_index]->count = count($countby)==2 ? array(0, 0) : array(0);
	$nfcc_traff->agrupation[$nfcc_level_index]->segment_header = true;
	$nfcc_traff->agrupation[$nfcc_level_index]->segment_footer = true;

	if($item_header != false && $c_groupby == $item_header[$groupby[0]])
		$nfcc_traff->agrupation[$nfcc_level_index]->segment_header = false;
		
	if ( $groupby_count == 2)
	{
		$nfcc_traff->agrupation[$nfcc_level_index]->agrupation = array( );
		$nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2] = new traff_agrupation();
		$nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2]->title = $c_groupby_2;
		$nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2]->count = count($countby)==2 ? array(0, 0) : array(0);
		$nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2]->segment_header = true;
		$nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2]->segment_footer = true;
		
		if($item_header != false && $c_groupby == $item_header[$groupby[0]] && $c_groupby_2 == $item_header[$groupby[1]])
			$nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2]->segment_header = false;
	}
	
	$n = 0;
	$rel_offset = count( $traff_all) - count( $traff) + ( $is_last ? -1 : -2);
	foreach($traff as $traff_item)
	{
		if($c_groupby != $traff_item[$groupby[0]])
		{
			// Cambio el nivel 1.

			// Recalculo los subtotales para atras si es necesario.
			if ( $nfcc_traff->agrupation[$nfcc_level_index]->segment_header == false)
			{
				// Si no mostramos el header, entonces recalculamos para atras. :|
				traff_agrupate_subtotals( $nfcc_traff->agrupation[$nfcc_level_index], $traff_all, $rel_offset + $n, $groupby[0], $countby);
			}

			if ( $groupby_count == 2)
			{
				// Recalculo los subtotales para atras si es necesario.
				if ( $nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2]->segment_header == false)
				{
					// Si no mostramos el header, entonces recalculamos para atras. :|
					traff_agrupate_subtotals( $nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2], $traff_all, $rel_offset + $n, $groupby[1], $countby);
				}
			}
			
			// Incrementando el index.
			$nfcc_level_index++;
			$nfcc_traff->agrupation[$nfcc_level_index] = new traff_agrupation();
			$nfcc_traff->agrupation[$nfcc_level_index]->title = $traff_item[$groupby[0]];
			$nfcc_traff->agrupation[$nfcc_level_index]->count = count($countby)==2 ? array(0, 0) : array(0);
			$nfcc_traff->agrupation[$nfcc_level_index]->segment_header = true;
			$nfcc_traff->agrupation[$nfcc_level_index]->segment_footer = true;
			$c_groupby = $traff_item[$groupby[0]];
			
			if ( $groupby_count == 2)
			{
				$nfcc_level_index_2++;
				$nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2] = new traff_agrupation();
				$nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2]->title = $traff_item[$groupby[1]];
				$nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2]->count = count($countby)==2 ? array(0, 0) : array(0);
				$nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2]->segment_header = true;
				$nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2]->segment_footer = true;
				$c_groupby_2 = $traff_item[$groupby[1]];
			}
		
		}
		else if ($groupby_count == 2 && $c_groupby_2 != $traff_item[$groupby[1]])
		{
			// Cambio el nivel 2.

			// Recalculo los subtotales para atras si es necesario.
			if ( $nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2]->segment_header == false)
			{
				// Si no mostramos el header, entonces recalculamos para atras. :|
				traff_agrupate_subtotals( $nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2], $traff_all, $rel_offset + $n, $groupby[1], $countby);
			}

			// Incrementando el index.
			$nfcc_level_index_2++;
			$nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2] = new traff_agrupation();
			$nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2]->title = $traff_item[$groupby[1]];
			$nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2]->count = count($countby)==2 ? array(0, 0) : array(0);
			$nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2]->segment_header = true;
			$nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2]->segment_footer = true;
			$c_groupby_2 = $traff_item[$groupby[1]];
		}

		if(is_detail_report($report_type))
			$newitem = new traff_detail_item($traff_item[$fields[0]], $traff_item[$fields[1]], $traff_item[$fields[2]], $traff_item[$fields[3]], $traff_item[$fields[4]], $traff_item[$fields[5]], $traff_item[$fields[6]]);
		else if(is_summary_report($report_type))
			$newitem = new traff_summary_item($traff_item[$fields[0]], $traff_item[$fields[1]], $traff_item[$fields[2]], $traff_item[$fields[3]]);
			
		$nfcc_traff->agrupation[$nfcc_level_index]->subtotal += ( float)$traff_item['importe'];
		$nfcc_traff->agrupation[$nfcc_level_index]->count[0] += ( float)$traff_item[$countby[0]];

		if(count($countby) == 2)
			$nfcc_traff->agrupation[$nfcc_level_index]->count[1] += ( float)$traff_item[$countby[1]];
		
		if ( $groupby_count == 1)
		{
			$nfcc_traff->agrupation[$nfcc_level_index]->items[] = $newitem;
		}
		else
		{
			// $groupby_count = 2.
			$nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2]->items[] = $newitem;
			$nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2]->subtotal += ( float)$traff_item['importe'];
			$nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2]->count[0] += ( float)$traff_item[$countby[0]];

			if(count($countby) == 2)
				$nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2]->count[1] += ( float)$traff_item[$countby[1]];
		}

		$n ++;
	}

	// Decido si muestro o no el footer.
	if($item_footer != false && $traff[count($traff)-1][$groupby[0]] == $item_footer[$groupby[0]])
		$nfcc_traff->agrupation[$nfcc_level_index]->segment_footer = false;

	// Recalculo los subtotales para atras si es necesario.
	if ( $nfcc_traff->agrupation[$nfcc_level_index]->segment_header == false && $nfcc_traff->agrupation[$nfcc_level_index]->segment_footer == true)
	{
		// Si no mostramos el header, entonces recalculamos para atras. :|
		traff_agrupate_subtotals( $nfcc_traff->agrupation[$nfcc_level_index], $traff_all, count( $traff_all) -1, $groupby[0], $countby);
	}
		
	if ( $groupby_count == 2)
	{
		// Decido si muestro o no el footer.
		if($item_footer != false && $traff[count($traff)-1][$groupby[1]] == $item_footer[$groupby[1]] && $traff[count($traff)-1][$groupby[0]] == $item_footer[$groupby[0]])
			$nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2]->segment_footer = false;

		// Recalculo los subtotales para atras si es necesario.
		if ( $nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2]->segment_header == false && $nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2]->segment_footer == true)
		{
			// Si no mostramos el header, entonces recalculamos para atras. :|
			traff_agrupate_subtotals( $nfcc_traff->agrupation[$nfcc_level_index]->agrupation[$nfcc_level_index_2], $traff_all, count( $traff_all) -1, $groupby[1], $countby);
		}
	}
	
	return $nfcc_traff;
}

function traff_detail_nonagrupate( $report_type, $fields, $traff)
{
	// Some initialization stuff.
	if( is_detail_report( $report_type))
		$nfcc_traff = new traff_detail( );
	else if( is_summary_report( $report_type))
		$nfcc_traff = new traff_summary( );

	$nfcc_traff->items = array( );
		
	// Walking through the list.
	foreach( $traff as $traff_item)
	{
		if( is_detail_report( $report_type))
		{
			$nfcc_traff->items[ ] = new traff_detail_item(
				$traff_item[ $fields[ 0]],
				$traff_item[ $fields[ 1]],
				$traff_item[ $fields[ 2]],
				$traff_item[ $fields[ 3]],
				$traff_item[ $fields[ 4]],
				$traff_item[ $fields[ 5]],
				$traff_item[ $fields[ 6]]
			);
		}
		else if( is_summary_report( $report_type))
		{
			$nfcc_traff->items[ ] = new traff_summary_item(
				$traff_item[ $fields[ 0]],
				$traff_item[ $fields[ 1]],
				$traff_item[ $fields[ 2]],
				$traff_item[ $fields[ 3]]
			);
		}
	}

	return $nfcc_traff;
}

?>

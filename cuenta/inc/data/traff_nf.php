<?
require_once( INCLUDE_PATH . "db.php");
require_once("traff_common.php");

class traff_nf
{
	var $start_date;
	var $end_date;
	var $lines;

	function traff_nf( $start_date, $end_date, $lines)
	{
		$this->start_date = $start_date;
		$this->end_date = $end_date;
		$this->lines = $lines;
	}
}

function get_traff_nf_by_line_pin_summary($clientid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, $offset, $limit, $is_last, $get_total, $total)
{
	$query_main = new sql_query();
	$query_count = new sql_query();
	$query_sum = new sql_query();

	// Armo el WHERE.
	$wheredata = get_where_by_filter($clientid, $pinid, $dialednumber, $datefrom, $dateto);

	// Recalculo el offset y limit.
	list($q_offset, $q_limit) =  calculate_offset($offset, $limit);
	
	// Count query
	$query_count->select = "count(*)";
	$query_count->from = "Trafico th";
	$query_count->where = $wheredata;
	$query_count->groupby = "(th.tiposervicio || ' ' || th.linea), th.moneda";
	
	// Main query ( con limites )
	$query_main->select = "(th.tiposervicio || ' ' || th.linea) as tlinea, th.moneda, count(*) as llamados, sum(duracion) as duracion, sum(importe) as importe";
	$query_main->from = "Trafico th";
	$query_main->where = $wheredata;
	$query_main->groupby = "tlinea, th.moneda";
	$query_main->limit = ( $q_limit + $q_offset);
	
	// Sums para los totales
	$query_sum->select = "count(*), sum(th.importe), sum(th.duracion)";
	$query_sum->from = "Trafico th";
	$query_sum->where = $wheredata;
	
	// Agrupacion por columna
	$agrupate = array("");
	
	// Columnas con subtotales
	$counters = array("llamados", "duracion");

	// Field list
	$fields = array("tlinea", "llamados", "duracion", "importe");
	
	return traff_nf_execute_report(1, $fields, $query_main, $query_sum, $query_count, $agrupate, $counters, $offset, $limit, $is_last, $get_total, $total);
}

function get_traff_nf_by_call_reference_summary($clientid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, $offset, $limit, $is_last, $get_total, $total)
{
	$query_main = new sql_query();
	$query_count = new sql_query();
	$query_sum = new sql_query();

	// Armo el WHERE.
	$wheredata = get_where_by_filter($clientid, $pinid, $dialednumber, $datefrom, $dateto);

	// Recalculo el offset y limit.
	list($q_offset, $q_limit) =  calculate_offset($offset, $limit);
	
	// Count query
	$query_count->select = "count(*)";
	$query_count->from = "Trafico th left join Proyectos p on p.destino=th.destino";
	$query_count->where = $wheredata;
	$query_count->groupby = "p.proyecto, th.clasificador, th.moneda";
	
	// Main query ( con limites )
	$query_main->select = "coalesce(p.proyecto, 'No Asignado') as proyecto, th.clasificador as clasificador, th.moneda, count(*) as llamados, sum(duracion) as duracion, sum(th.importe) as importe";
	$query_main->from = "Trafico th left join Proyectos p on p.destino=th.destino";
	$query_main->where = $wheredata;
	$query_main->groupby = "p.proyecto, th.clasificador, th.moneda";
	$query_main->orderby = "p.proyecto, clasificador, th.moneda, duracion";
	$query_main->limit = ( $q_limit + $q_offset);
	
	// Sums para los totales
	$query_sum->select = "count(*), sum(th.importe), sum(th.duracion)";
	$query_sum->from = "Trafico th";
	$query_sum->where = $wheredata;
	
	// Agrupacion por columna
	$agrupate = array("proyecto");
	
	// Columnas con subtotales
	$counters = array("llamados", "duracion");

	// Field list
	$fields = array("proyecto", "clasificador", "llamados", "duracion", "importe");
	
	return traff_nf_execute_report(1, $fields, $query_main, $query_sum, $query_count, $agrupate, $counters, $offset, $limit, $is_last, $get_total, $total);
}

function get_traff_nf_by_location_summary($clientid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, $offset, $limit, $is_last, $get_total, $total)
{
	$query_main = new sql_query();
	$query_count = new sql_query();
	$query_sum = new sql_query();

	// Armo el WHERE.
	$wheredata = get_where_by_filter($clientid, $pinid, $dialednumber, $datefrom, $dateto);

	// Recalculo el offset y limit.
	list($q_offset, $q_limit) =  calculate_offset($offset, $limit);
	
	// Count query
	$query_count->select = "count(*)";
	$query_count->from = "Trafico th";
	$query_count->where = $wheredata;
	$query_count->groupby = "th.destinotxt, th.moneda";
	
	// Main query ( con limites )
	$query_main->select = "th.destinotxt as destinotxt, th.moneda, count(*) as llamados, sum(th.duracion) as duracion, sum(th.importe) as importe";
	$query_main->from = "Trafico th";
	$query_main->where = $wheredata;
	$query_main->groupby = "th.destinotxt, th.moneda";
	$query_main->orderby = "llamados desc, duracion";
	$query_main->limit = ( $q_limit + $q_offset);
	
	// Sums para los totales
	$query_sum->select = "count(*), sum(th.importe), sum(th.duracion)";
	$query_sum->from = "Trafico th";
	$query_sum->where = $wheredata;
	
	// Agrupacion por columna
	$agrupate = array("");
	
	// Columnas con subtotales
	$counters = array("llamados", "duracion");

	// Field list
	$fields = array("destinotxt", "llamados", "duracion", "importe");
	
	return traff_nf_execute_report(1, $fields, $query_main, $query_sum, $query_count, $agrupate, $counters, $offset, $limit, $is_last, $get_total, $total);
}

function get_traff_nf_by_target_summary($clientid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, $offset, $limit, $is_last, $get_total, $total)
{
	$query_main = new sql_query();
	$query_count = new sql_query();
	$query_sum = new sql_query();

	// Armo el WHERE.
	$wheredata = get_where_by_filter($clientid, $pinid, $dialednumber, $datefrom, $dateto);

	// Recalculo el offset y limit.
	list($q_offset, $q_limit) =  calculate_offset($offset, $limit);
	
	// Count query
	$query_count->select = "count(*)";
	$query_count->from = "Trafico th";
	$query_count->where = $wheredata;
	$query_count->groupby = "destino, moneda";
	
	// Main query ( con limites )
	$query_main->select = "th.destino as destino, th.moneda, count(*) as llamados, sum(th.duracion) as duracion, sum(th.importe) as importe";
	$query_main->from = "Trafico th";
	$query_main->where = $wheredata;
	$query_main->groupby = "th.destino, th.moneda";
	$query_main->orderby = "llamados desc, duracion";
	$query_main->limit = ( $q_limit + $q_offset);
	
	// Sums para los totales
	$query_sum->select = "count(*), sum(th.importe), sum(th.duracion)";
	$query_sum->from = "Trafico th";
	$query_sum->where = $wheredata;
	
	// Agrupacion por columna
	$agrupate = array("");
	
	// Columnas con subtotales
	$counters = array("llamados", "duracion");

	// Field list
	$fields = array("destino", "llamados", "duracion", "importe");
	
	return traff_nf_execute_report(1, $fields, $query_main, $query_sum, $query_count, $agrupate, $counters, $offset, $limit, $is_last, $get_total, $total);
}

function get_traff_nf_by_source_summary($clientid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, $offset, $limit, $is_last, $get_total, $total)
{
	$query_main = new sql_query();
	$query_count = new sql_query();
	$query_sum = new sql_query();

	// Armo el WHERE.
	$wheredata = get_where_by_filter($clientid, $pinid, $dialednumber, $datefrom, $dateto);

	// Recalculo el offset y limit.
	list($q_offset, $q_limit) =  calculate_offset($offset, $limit);
	
	// Count query
	$query_count->select = "count(*)";
	$query_count->from = "Trafico th";
	$query_count->where = $wheredata;
	$query_count->groupby = "th.origen, th.moneda";
	
	// Main query ( con limites )
	$query_main->select = "th.origen as origen, th.moneda, count(*) as llamados, sum(th.duracion) as duracion, sum(th.importe) as importe";
	$query_main->from = "Trafico th";
	$query_main->where = $wheredata;
	$query_main->groupby = "th.origen, th.moneda";
	$query_main->orderby = "llamados desc, duracion";
	$query_main->limit = ( $q_limit + $q_offset);
	
	// Sums para los totales
	$query_sum->select = "count(*), sum(th.importe), sum(th.duracion)";
	$query_sum->from = "Trafico th";
	$query_sum->where = $wheredata;
	
	// Agrupacion por columna
	$agrupate = array("");
	
	// Columnas con subtotales
	$counters = array("llamados", "duracion");

	// Field list
	$fields = array("origen", "llamados", "duracion", "importe");
	
	return traff_nf_execute_report(1, $fields, $query_main, $query_sum, $query_count, $agrupate, $counters, $offset, $limit, $is_last, $get_total, $total);
}



function get_traff_nf_by_centro_costos_summary($clientid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, $offset, $limit, $is_last, $get_total, $total)
{
	db::init();
	$item_header = false;
	$item_footer = false;

	// Recalculo el offset y limit.
	list($q_offset, $q_limit) =  calculate_offset($offset, $limit);

	// Armo el WHERE.
	$wheredata = get_where_by_filter($clientid, $pinid, $dialednumber, $datefrom, $dateto);

	// Calculando el total de items si es necesesario.
	if($get_total)
	{
		$query = "select ";
			$query .= "count(*) ";
		$query .= "from ";
			$query .= "Trafico th left join Centrocostos cc on cc.linea=th.linea ";
		$query .= "where ";
		$query .= $wheredata . " ";
		$query .= "group by cc.centrocostos, th.clasificador, th.moneda ";
	
		
		$total = count(db::get_rows_as_array($query));
		if($total - ($offset + $limit) < 0)
			$is_last = true;
	}

	// Armo el query.
	$query = "select ";
		$query .= "coalesce(cc.centrocostos, 'No Asignado') as centrocostos, th.clasificador as clasificador, ";
		$query .= "th.moneda, count(*) as llamados, sum(duracion) as duracion, sum(th.importe) as importe ";
	$query .= "from ";
		$query .= "Trafico th left join Centrocostos cc on cc.linea=th.linea ";
	$query .= "where  ";
	$query .= $wheredata . " ";
	$query .= "group by cc.centrocostos, th.clasificador, th.moneda ";
	$query .= "order by cc.centrocostos, clasificador, th.moneda, duracion limit ";
	$query .= ( $q_limit + $q_offset);

	// Parto todo el resultado.
	$traff_all = db::get_rows_as_array_of_hashes($query);
	$traff = array_slice( $traff_all, $q_offset, $q_limit);

	// Es un resutlado valido?.
	if(!is_array($traff) || count($traff)<=0)
		return false;
	
	// Field list
	$fields = array("clasificador", "llamados", "duracion", "importe");
	
	$traff = calculate_array_slice($traff, $offset, $is_last, $item_header, $item_footer);
	$traff_summary = traff_detail_agrupate(1, $fields, $traff_all, $traff, $is_last, $item_header, $item_footer, array("centrocostos"), array("llamados", "duracion"));
	
	if($is_last)
	{
		$query = "select ";
			$query .= "count(*), sum(th.importe), sum(th.duracion) ";
		$query .= "from ";
			$query .= "Trafico th left join Centrocostos cc on cc.linea=th.linea ";
		$query .= "where ";
		$query .= $wheredata;

		$totals = db::get_rows_as_array($query);
		$traff_summary->total_calls = $totals[0][0];
		$traff_summary->total_price = $traff[0]['moneda']." ".$totals[0][1];
		$traff_summary->total_duration = $totals[0][2];
	}

	return $traff_summary;
}

function get_traff_nf_by_line_pin_detail($clientid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, $offset, $limit, $is_last, $get_total, $total)
{
	db::init();
	$item_header = false;
	$item_footer = false;

	// Recalculo el offset y limit.
	list($q_offset, $q_limit) =  calculate_offset($offset, $limit);

	// Armo el WHERE.
	$wheredata = get_where_by_filter($clientid, $pinid, $dialednumber, $datefrom, $dateto);
	
	// Calculando el total de items si es necesesario.
	if($get_total)
	{
		$query = "select ";
			$query .= "count(*) ";
		$query .= "from ";
			$query .= "Trafico th ";
		$query .= "where ";
		$query .= $wheredata;
	
		$total = db::get_row_as_scalar($query);
		if($total - ($offset + $limit) < 0)
			$is_last = true;
	}
	
	// Armo el query.
	$query = "select ";
	$query .= "  th.fecha, th.hora, th.origen, th.destino, th.destinotxt, th.duracion, ";
	$query .= "   th.importe, th.moneda, th.linea, th.clasificador ";
	$query .= "	from Trafico th ";
	$query .= "	where ";
	$query .= $wheredata . " ";
	$query .= "	order by th.linea, th.clasificador, th.fecha, th.hora, th.duracion limit ";
	$query .= ( $q_limit + $q_offset);
		
	// Parto todo el resultado.
	$traff_all = db::get_rows_as_array_of_hashes($query);
	$traff = array_slice( $traff_all, $q_offset, $q_limit);

	// Es un resutlado valido?.
	if(!is_array($traff) || count($traff)<=0)
		return false;

	// Fields
	$fields = array("fecha", "hora", "origen", "destino", "destinotxt", "duracion", "importe");
	
	$traff = calculate_array_slice($traff, $offset, $is_last, $item_header, $item_footer);
	$traff_detail = traff_detail_agrupate(0, $fields, $traff_all, $traff, $is_last, $item_header, $item_footer, array("linea", "clasificador"), array("duracion"));
	
	if($is_last)
	{
		$query = "select ";
			$query .= "sum(th.duracion), sum(th.importe) ";
		$query .= "from ";
			$query .= "Trafico th ";
		$query .= "where ";
		$query .= $wheredata;
	
		$totals = db::get_rows_as_array($query);
		$traff_detail->total_duration = $totals[0][0];
		$traff_detail->total_price = $traff[0]['moneda']." ".$totals[0][1];
	}

	return $traff_detail;
}

/* Reports detail  */

function get_traff_nf_by_centro_costos_detail($clientid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, $offset, $limit, $is_last, $get_total, $total)
{
	$query_main = new sql_query();
	$query_count = new sql_query();
	$query_sum = new sql_query();

	// Armo el WHERE.
	$wheredata = get_where_by_filter($clientid, $pinid, $dialednumber, $datefrom, $dateto);

	// Recalculo el offset y limit.
	list($q_offset, $q_limit) =  calculate_offset($offset, $limit);
	
	// Count query
	$query_count->select = "count(*)";
	$query_count->from = "Trafico th left join CentroCostos cc on cc.linea=th.linea";
	$query_count->where = $wheredata;
	
	// Main query ( con limites )
	$query_main->select = "coalesce(cc.centrocostos, 'No Asignado') as centrocostos, th.clasificador as clasificador, th.fecha, th.hora, th.origen, th.destino, th.destinotxt, th.duracion, th.moneda, th.importe";
	$query_main->from = "Trafico th left join CentroCostos cc on cc.linea=th.linea";
	$query_main->where = $wheredata;
	$query_main->orderby = "centrocostos, th.fecha, th.hora, th.duracion, clasificador";
	$query_main->limit = ( $q_limit + $q_offset);
	
	// Sums para los totales
	$query_sum->select = "sum(th.duracion), sum(th.importe)";
	$query_sum->from = "Trafico th left join CentroCostos cc on cc.linea=th.linea";
	$query_sum->where = $wheredata;
	
	// Agrupacion por columna
	$agrupate = array("centrocostos", "clasificador");
	
	// Columnas con subtotales
	$counters = array("duracion");
	
	// Fields
	$fields = array("fecha", "hora", "origen", "destino", "destinotxt", "duracion", "importe");
	
	return traff_nf_execute_report(0, $fields, $query_main, $query_sum, $query_count, $agrupate, $counters, $offset, $limit, $is_last, $get_total, $total);
}

function get_traff_nf_last_calls_detail($clientid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, $offset, $limit, $is_last, $get_total, $total)
{
	$query_main = new sql_query();
	$query_count = new sql_query();
	$query_sum = new sql_query();

	// Armo el WHERE.
	$wheredata = get_where_by_filter($clientid, $pinid, $dialednumber, $datefrom, $dateto);

	// Recalculo el offset y limit.
	list($q_offset, $q_limit) =  calculate_offset($offset, $limit);
	
	// Count query
	$query_count->select = "count(*)";
	$query_count->from = "Trafico th";
	$query_count->where = $wheredata;
	
	// Main query ( con limites )
	$query_main->select = "th.fecha, th.hora, th.origen, th.destino, th.destinotxt, th.duracion, th.importe, th.moneda, th.linea, th.clasificador";
	$query_main->from = "Trafico th";
	$query_main->where = $wheredata;
	$query_main->orderby = "th.fecha desc, th.hora desc, th.duracion";
	$query_main->limit = ( $q_limit + $q_offset);
	
	// Sums para los totales
	$query_sum->select = "sum(th.duracion), sum(th.importe)";
	$query_sum->from = "Trafico th";
	$query_sum->where = $wheredata;
	
	// Agrupacion por columna
	$agrupate = array("");
	
	// Columnas con subtotales
	$counters = array("duracion");
	
	// Fields
	$fields = array("fecha", "hora", "origen", "destino", "destinotxt", "duracion", "importe");
	
	return traff_nf_execute_report(0, $fields, $query_main, $query_sum, $query_count, $agrupate, $counters, $offset, $limit, $is_last, $get_total, $total);
}




function get_traff_nf_by_call_reference_detail($clientid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, $offset, $limit, $is_last, $get_total, $total)
{
	$query_main = new sql_query();
	$query_count = new sql_query();
	$query_sum = new sql_query();

	// Armo el WHERE.
	$wheredata = get_where_by_filter($clientid, $pinid, $dialednumber, $datefrom, $dateto);

	// Recalculo el offset y limit.
	list($q_offset, $q_limit) =  calculate_offset($offset, $limit);
	
	// Count query
	$query_count->select = "count(*)";
	$query_count->from = "Trafico th left join Proyectos p on p.destino=th.destino";
	$query_count->where = $wheredata;
	
	// Main query ( con limites )
	$query_main->select = "coalesce(p.proyecto, 'No Asignado') as proyecto, th.fecha, th.hora, th.origen, th.destino, th.destinotxt, th.duracion, th.moneda, th.importe";
	$query_main->from = "Trafico th left join Proyectos p on p.destino=th.destino";
	$query_main->where = $wheredata;
	$query_main->orderby = "proyecto, th.fecha, th.hora, th.duracion";
	$query_main->limit = ( $q_limit + $q_offset);
	
	// Sums para los totales
	$query_sum->select = "sum(th.duracion), sum(th.importe)";
	$query_sum->from = "Trafico th left join Proyectos p on p.destino=th.destino";
	$query_sum->where = $wheredata;
	
	// Agrupacion por columna
	$agrupate = array("proyecto");
	
	// Columnas con subtotales
	$counters = array("duracion");
	
	// Fields
	$fields = array("fecha", "hora", "origen", "destino", "destinotxt", "duracion", "importe");

	return traff_nf_execute_report(0, $fields, $query_main, $query_sum, $query_count, $agrupate, $counters, $offset, $limit, $is_last, $get_total, $total);
}

?>

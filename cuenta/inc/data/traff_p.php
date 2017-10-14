<?

class traff_p
{
	var $start_date;
	var $end_date;
	var $lines;

	function traff_p( $start_date, $end_date, $lines)
	{
		$this->start_date = $start_date;
		$this->end_date = $end_date;
		$this->lines = $lines;
	}
}

function get_traff_p_by_centro_costos_detail($clientid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, $offset, $limit, &
$is_last, $get_total, $total)
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
    $query_count->from = "FactLineas fl, TraficoHistorico th left join CentroCostos cc on cc.linea=th.linea";
    $query_count->where = "th.numdoc=fl.numdoc and th.tipodoc=fl.tipodoc and th.sucdoc=fl.sucdoc and th.codlinea = fl.codlinea and trim(fl.cliente_id) = '$clientid' and ".$wheredata;

    // Main query ( con limites )
    $query_main->select = "coalesce(cc.centrocostos, 'No Asignado') as centrocostos, fl.desclinea as desclinea, th.fecha, th.hora, th.origen, th.destino, th.destinotxt, th.duracion, th.moneda, th.importe";
    $query_main->from = "FactLineas fl, TraficoHistorico th left join CentroCostos cc on cc.linea=th.linea";
    $query_main->where = "th.numdoc=fl.numdoc and th.tipodoc=fl.tipodoc and th.sucdoc=fl.sucdoc and th.codlinea = fl.codlinea and trim(fl.cliente_id) = '$clientid' and ".$wheredata;
    $query_main->orderby = "centrocostos, desclinea, th.duracion";
    $query_main->limit = ( $q_limit + $q_offset);

    // Sums para los totales
    $query_sum->select = "sum(th.duracion), sum(th.importe)";
    $query_sum->from = "FactLineas fl, TraficoHistorico th left join CentroCostos cc on cc.linea=th.linea";
    $query_sum->where = "th.numdoc=fl.numdoc and th.tipodoc=fl.tipodoc and th.sucdoc=fl.sucdoc and th.codlinea = fl.codlinea and trim(fl.cliente_id) = '$clientid' and ".$wheredata;

    // Agrupacion por columna
    $agrupate = array("centrocostos", "desclinea");

    // Columnas con subtotales
    $counters = array("duracion");

    // Fields
    $fields = array("fecha", "hora", "origen", "destino", "destinotxt", "duracion", "importe");

    return traff_nf_execute_report(0, $fields, $query_main, $query_sum, $query_count, $agrupate, $counters, $offset, $limit, $is_last, $get_total, $total);
}

function get_traff_p_by_line_pin_detail($clientid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, $offset, $limit, $is_last, $get_total, $total)
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
    $query_count->from = "TraficoHistorico th, FactLineas fl";
    $query_count->where = "th.numdoc=fl.numdoc and th.sucdoc=fl.sucdoc and th.tipodoc=fl.tipodoc and th.codlinea=fl.codlinea and trim(fl.cliente_id) = '$clientid' and  ".$wheredata;

    // Main query ( con limites )
    $query_main->select = "th.fecha, th.hora, th.origen, th.destino, th.destinotxt, th.duracion, th.importe, th.moneda, th.linea, fl.desclinea";
    $query_main->from = "TraficoHistorico th, FactLineas fl";
    $query_main->where = "th.numdoc=fl.numdoc and th.sucdoc=fl.sucdoc and th.tipodoc=fl.tipodoc and th.codlinea=fl.codlinea and trim(fl.cliente_id) = '$clientid' and  ".$wheredata;
    $query_main->orderby = "th.linea, fl.desclinea, th.fecha, th.hora, th.duracion";
    $query_main->limit = ( $q_limit + $q_offset);

    // Sums para los totales
    $query_sum->select = "sum(th.duracion), sum(th.importe)";
    $query_sum->from = "TraficoHistorico th, FactLineas fl";
    $query_sum->where = "th.numdoc=fl.numdoc and th.sucdoc=fl.sucdoc and th.tipodoc=fl.tipodoc and th.codlinea=fl.codlinea and trim(fl.cliente_id) = '$clientid' and ".$wheredata;

    // Agrupacion por columna
    $agrupate = array("linea", "desclinea");

    // Columnas con subtotales
    $counters = array("duracion");

    // Fields
    $fields = array("fecha", "hora", "origen", "destino", "destinotxt", "duracion", "importe");

    return traff_nf_execute_report(0, $fields, $query_main, $query_sum, $query_count, $agrupate, $counters, $offset, $limit, $is_last, $get_total, $total);
}

function get_traff_p_by_project_detail($clientid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, $offset, $limit, &
$is_last, $get_total, $total)
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
    $query_count->from = "TraficoHistorico th left join Proyectos p on p.destino=th.destino";
    $query_count->where = $wheredata;

    // Main query ( con limites )
    $query_main->select = "coalesce(p.proyecto, 'No Asignado') as proyecto, th.fecha, th.hora, th.origen, th.destino, th.destinotxt, th.duracion, th.moneda, th.importe";
    $query_main->from = "TraficoHistorico th left join Proyectos p on p.destino=th.destino";
    $query_main->where = $wheredata;
    $query_main->orderby = "proyecto, th.fecha, th.hora, th.duracion";
    $query_main->limit = ( $q_limit + $q_offset);

    // Sums para los totales
    $query_sum->select = "sum(th.duracion), sum(th.importe)";
    $query_sum->from = "TraficoHistorico th left join Proyectos p on p.destino=th.destino";
    $query_sum->where = $wheredata;

    // Agrupacion por columna
    $agrupate = array("proyecto");

    // Columnas con subtotales
    $counters = array("duracion");

    // Fields
    $fields = array("fecha", "hora", "origen", "destino", "destinotxt", "duracion", "importe");

    return traff_nf_execute_report(0, $fields, $query_main, $query_sum, $query_count, $agrupate, $counters, $offset, $limit, $is_last, $get_total, $total);
}

function get_traff_p_by_centro_costos_summary($clientid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, $offset, $limit, $is_last, $get_total, $total)
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
    $query_count->from = "FactLineas fl, TraficoHistorico th left join Centrocostos cc on cc.linea=th.linea";
    $query_count->where = "fl.numdoc=th.numdoc and fl.sucdoc = th.sucdoc and fl.tipodoc = th.tipodoc and fl.codlinea=th.codlinea and trim(fl.cliente_id) = '$clientid' and ".$wheredata;
    $query_count->groupby = "cc.centrocostos, desclinea, th.moneda";

    // Main query ( con limites )
    $query_main->select = "coalesce(cc.centrocostos, 'No Asignado') as centrocostos, fl.desclinea as desclinea, th.moneda, count(*) as llamados, sum(duracion) as duracion, sum(th.importe) as importe";
    $query_main->from = "FactLineas fl, TraficoHistorico th left join Centrocostos cc on cc.linea=th.linea";
    $query_main->where = "fl.numdoc=th.numdoc and fl.sucdoc = th.sucdoc and fl.tipodoc = th.tipodoc and fl.codlinea=th.codlinea and trim(fl.cliente_id) = '$clientid' and ".$wheredata;
    $query_main->groupby = "cc.centrocostos, desclinea, th.moneda";
    $query_main->limit = ( $q_limit + $q_offset);

    // Sums para los totales
    $query_sum->select = "count(*), sum(th.importe), sum(th.duracion)";
    $query_sum->from = "FactLineas fl, TraficoHistorico th left join Centrocostos cc on cc.linea=th.linea";
    $query_sum->where = "fl.numdoc=th.numdoc and fl.sucdoc = th.sucdoc and fl.tipodoc = th.tipodoc and fl.codlinea=th.codlinea and trim(fl.cliente_id) = '$clientid' and ".$wheredata;

    // Agrupacion por columna
    $agrupate = array("centrocostos");

    // Columnas con subtotales
    $counters = array("llamados", "duracion");

    // Field list
    $fields = array("desclinea", "llamados", "duracion", "importe");

    return traff_nf_execute_report(1, $fields, $query_main, $query_sum, $query_count, $agrupate, $counters, $offset, $limit, $is_last, $get_total, $total);
}

function get_traff_p_by_call_reference_summary($clientid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, $offset, $limit, $is_last, $get_total, $total)
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
    $query_count->from = "FactLineas fl, TraficoHistorico th left join Proyectos p on p.destino=th.destino";
    $query_count->where = "fl.numdoc=th.numdoc and fl.sucdoc = th.sucdoc and fl.tipodoc = th.tipodoc and fl.codlinea=th.codlinea and trim(fl.cliente_id) = '$clientid' and ".$wheredata;
    $query_count->groupby = "p.proyecto, desclinea, th.moneda";

    // Main query ( con limites )
    $query_main->select = "coalesce(p.proyecto, 'No asignado') as proyecto, fl.desclinea as desclinea, th.moneda, count(*) as llamados, sum(duracion) as duracion, sum(th.importe) as importe";
    $query_main->from = "FactLineas fl, TraficoHistorico th left join Proyectos p on p.destino=th.destino";
    $query_main->where = "fl.numdoc=th.numdoc and fl.sucdoc = th.sucdoc and fl.tipodoc = th.tipodoc and fl.codlinea=th.codlinea and trim(fl.cliente_id) = '$clientid' and ".$wheredata;
    $query_main->groupby = "p.proyecto, desclinea, th.moneda";
    $query_main->limit = ( $q_limit + $q_offset);

    // Sums para los totales
    $query_sum->select = "count(*), sum(th.importe), sum(th.duracion)";
    $query_sum->from = "FactLineas fl, TraficoHistorico th left join Proyectos p on p.destino=th.destino";
    $query_sum->where = "fl.numdoc=th.numdoc and fl.sucdoc = th.sucdoc and fl.tipodoc = th.tipodoc and fl.codlinea=th.codlinea and trim(fl.cliente_id) = '$clientid' and ".$wheredata;

    // Agrupacion por columna
    $agrupate = array("proyecto");

    // Columnas con subtotales
    $counters = array("llamados", "duracion");

    // Field list
    $fields = array("desclinea", "llamados", "duracion", "importe");

    return traff_nf_execute_report(1, $fields, $query_main, $query_sum, $query_count, $agrupate, $counters, $offset, $limit, $is_last, $get_total, $total);
}

function get_traff_p_by_abc_target_summary($clientid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, $offset, $limit, $is_last, $get_total, $total)
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
    $query_count->from = "TraficoHistorico th";
    $query_count->where = $wheredata;
    $query_count->groupby = "th.destinotxt, th.moneda";

    // Main query ( con limites )
    $query_main->select = "th.destinotxt as destinotxt, th.moneda, count(*) as llamados, sum(th.duracion) as duracion, sum(th.importe) as importe";
    $query_main->from = "TraficoHistorico th";
    $query_main->where = $wheredata;
    $query_main->groupby = "th.destinotxt, th.moneda, duracion";
    $query_main->orderby = "llamados desc";
    $query_main->limit = ( $q_limit + $q_offset);

    // Sums para los totales
    $query_sum->select = "count(*), sum(th.importe), sum(th.duracion)";
    $query_sum->from = "TraficoHistorico th";
    $query_sum->where = $wheredata;

    // Agrupacion por columna
    $agrupate = array("");

    // Columnas con subtotales
    $counters = array("llamados", "duracion");

    // Field list
    $fields = array("destinotxt", "llamados", "duracion", "importe");

    return traff_nf_execute_report(1, $fields, $query_main, $query_sum, $query_count, $agrupate, $counters, $offset, $limit, $is_last, $get_total, $total);
}

function get_traff_p_by_abc_target_dialed_summary($clientid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, $offset, $limit, $is_last, $get_total, $total)
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
    $query_count->from = "TraficoHistorico th";
    $query_count->where = $wheredata;
    $query_count->groupby = "th.destino, th.moneda";

    // Main query ( con limites )
    $query_main->select = "th.destino as destino, th.moneda, count(*) as llamados, sum(th.duracion) as duracion, sum(th.importe) as importe";
    $query_main->from = "TraficoHistorico th";
    $query_main->where = $wheredata;
    $query_main->groupby = "th.destino, th.moneda, duracion";
    $query_main->orderby = "llamados desc";
    $query_main->limit = ( $q_limit + $q_offset);

    // Sums para los totales
    $query_sum->select = "count(*), sum(th.importe), sum(th.duracion)";
    $query_sum->from = "TraficoHistorico th";
    $query_sum->where = $wheredata;

    // Agrupacion por columna
    $agrupate = array("");

    // Columnas con subtotales
    $counters = array("llamados", "duracion");

    // Field list
    $fields = array("destino", "llamados", "duracion", "importe");

    return traff_nf_execute_report(1, $fields, $query_main, $query_sum, $query_count, $agrupate, $counters, $offset, $limit, $is_last, $get_total, $total);
}

function get_traff_p_by_abc_source_summary($clientid, $datefrom, $dateto, $servicetype, $pinid, $dialednumber, $offset, $limit, $is_last, $get_total, $total)
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
    $query_count->from = "TraficoHistorico th";
    $query_count->where = $wheredata;
    $query_count->groupby = "th.origen, th.moneda";

    // Main query ( con limites )
    $query_main->select = "th.origen as origen, th.moneda, count(*) as llamados, sum(th.duracion) as duracion, sum(th.importe) as importe";
    $query_main->from = "TraficoHistorico th";
    $query_main->where = $wheredata;
    $query_main->groupby = "th.origen, th.moneda, duracion";
    $query_main->orderby = "llamados desc";
    $query_main->limit = ( $q_limit + $q_offset);

    // Sums para los totales
    $query_sum->select = "count(*), sum(th.importe), sum(th.duracion)";
    $query_sum->from = "TraficoHistorico th";
    $query_sum->where = $wheredata;

    // Agrupacion por columna
    $agrupate = array("");

    // Columnas con subtotales
    $counters = array("llamados", "duracion");

    // Field list
    $fields = array("origen", "llamados", "duracion", "importe");

    return traff_nf_execute_report(1, $fields, $query_main, $query_sum, $query_count, $agrupate, $counters, $offset, $limit, $is_last, $get_total, $total);
}




?>

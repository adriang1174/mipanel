<?
require_once( INCLUDE_PATH . "db.php");
require_once("traff_common.php");

class traff_f_ticket
{
	var $date;
	var $docnum;
	var $ticketid;

	function traff_f_ticket( $date, $docnum, $ticketid)
	{
		$this->date = $date;
		$this->docnum = $docnum;
		$this->ticketid = $ticketid;
	}
}

class traff_f
{
	var $tickets;

	function traff_f( $tickets)
	{
		$this->tickets = $tickets;
	}
}

function traff_f_get_ticket_list($clientid)
{
	db::init();

	$query = new sql_query();

	$query->select = "to_char(fechemision, 'DD/MM/YYYY'), numdoc, tipodoc || '-' || lpad(cast(sucdoc as varchar),4, '0') || '-' || lpad(cast(numdoc as varchar), 8, '0')";
	$query->from = "factheader";
	$query->where = "cliente_id = '".$clientid."'";
	$query->orderby = "fechemision DESC";
	
	$tickets = db::get_rows_as_array($query->render());

	$ticket_list = array();
	foreach($tickets as $ticket)
		$ticket_list[] = new traff_f_ticket( $ticket[0], $ticket[1], $ticket[2]);
	
	return $ticket_list;
}

function get_traff_f_by_centro_costos_detail($clientid, $ticketid, $offset, $limit, $is_last, $get_total, $total)
{
    $query_main = new sql_query();
    $query_count = new sql_query();
    $query_sum = new sql_query();

	list($tipodoc, $sucdoc, $numdoc) = explode('-', $ticketid, 3);
	$sucdoc = (int) $sucdoc;
	$numdoc = (int) $numdoc;

    // Armo el WHERE.
    $wheredata = "fl.tipodoc = '$tipodoc' and fl.sucdoc = '$sucdoc' and fl.numdoc = '$numdoc' and fl.numdoc = th.numdoc and th.tipodoc=fl.tipodoc and th.sucdoc=fl.sucdoc and th.codlinea = fl.codlinea and th.cliente_id = '$clientid' and trim(fl.cliente_id) = '$clientid'";

    // Recalculo el offset y limit.
    list($q_offset, $q_limit) =  calculate_offset($offset, $limit);

    // Count query
    $query_count->select = "count(*)";
    $query_count->from = "FactLineas fl, TraficoHistorico th left join CentroCostos cc on (cc.linea=th.linea and cc.cliente_id=th.cliente_id)";
    $query_count->where = $wheredata;

    // Main query ( con limites )
    $query_main->select = "coalesce(cc.centrocostos, 'No Asignado') as centrocostos, fl.desclinea as desclinea, th.fecha, th.hora, th.origen, th.destino, th.destinotxt, th.duracion, th.moneda, th.importe";
    $query_main->from = "FactLineas fl, TraficoHistorico th left join CentroCostos cc on (cc.linea=th.linea and cc.cliente_id=th.cliente_id)";
    $query_main->where = $wheredata;
    $query_main->orderby = "centrocostos, th.fecha, th.hora, th.duracion, desclinea";
    $query_main->limit = ( $q_limit + $q_offset);

    // Sums para los totales
    $query_sum->select = "sum(th.duracion), sum(th.importe)";
    $query_sum->from = "FactLineas fl, TraficoHistorico th left join CentroCostos cc on (cc.linea=th.linea and cc.cliente_id=th.cliente_id)";
    $query_sum->where = $wheredata;

    // Agrupacion por columna
    $agrupate = array("centrocostos", "desclinea");

    // Columnas con subtotales
    $counters = array("duracion");

    // Fields
    $fields = array("fecha", "hora", "origen", "destino", "destinotxt", "duracion", "importe");
  
	return traff_nf_execute_report(0, $fields, $query_main, $query_sum, $query_count, $agrupate, $counters, $offset, $limit, $is_last, $get_total, $total);
	
}

function get_traff_f_by_account_detail($clientid, $ticketid, $offset, $limit, $is_last, $get_total, $total)
{
    $query_main = new sql_query();
    $query_count = new sql_query();
    $query_sum = new sql_query();

	list($tipodoc, $sucdoc, $numdoc) = explode('-', $ticketid, 3);
	$sucdoc = (int) $sucdoc;
	$numdoc = (int) $numdoc;
	
    // Armo el WHERE.
    $wheredata = "th.numdoc = '$numdoc' and th.sucdoc=fl.sucdoc and th.tipodoc=fl.tipodoc and th.codlinea=fl.codlinea and fl.tipodoc = '$tipodoc' and fl.sucdoc = '$sucdoc' and fl.numdoc = '$numdoc' and th.cliente_id = '$clientid' and trim(fl.cliente_id) = '$clientid' ";

    // Recalculo el offset y limit.
    list($q_offset, $q_limit) =  calculate_offset($offset, $limit);

    // Count query
    $query_count->select = "count(*)";
    $query_count->from = "TraficoHistorico th, FactLineas fl";
    $query_count->where = $wheredata;

    // Main query ( con limites )
    $query_main->select = "th.fecha, th.hora, th.origen, th.destino, th.destinotxt, th.duracion, th.importe, th.moneda, th.linea, fl.desclinea";
    $query_main->from = "TraficoHistorico th, FactLineas fl";
    $query_main->where = $wheredata;
    $query_main->orderby = "th.linea, fl.desclinea, th.fecha, th.hora, th.duracion";
    $query_main->limit = ( $q_limit + $q_offset);

    // Sums para los totales
    $query_sum->select = "sum(th.duracion), sum(th.importe)";
    $query_sum->from = "TraficoHistorico th, FactLineas fl";
    $query_sum->where = $wheredata;

    // Agrupacion por columna
    $agrupate = array("linea", "desclinea");

    // Columnas con subtotales
    $counters = array("duracion");

    // Fields
    $fields = array("fecha", "hora", "origen", "destino", "destinotxt", "duracion", "importe");

    return traff_nf_execute_report(0, $fields, $query_main, $query_sum, $query_count, $agrupate, $counters, $offset, $limit, $is_last, $get_total, $total);
}

function get_traff_f_by_reference_call_detail($clientid, $ticketid, $offset, $limit, $is_last, $get_total, $total)
{
    $query_main = new sql_query();
    $query_count = new sql_query();
    $query_sum = new sql_query();

	list($tipodoc, $sucdoc, $numdoc) = explode('-', $ticketid, 3);
	$sucdoc = (int) $sucdoc;
	$numdoc = (int) $numdoc;
	
    // Armo el WHERE.
    $wheredata = "th.tipodoc = '$tipodoc' and th.sucdoc = '$sucdoc' and th.numdoc = '$numdoc' and th.cliente_id = '$clientid'";

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

function get_traff_f_by_centro_costos_summary($clientid, $ticketid, $offset, $limit, $is_last, $get_total, $total)
{
    $query_main = new sql_query();
    $query_count = new sql_query();
    $query_sum = new sql_query();

	list($tipodoc, $sucdoc, $numdoc) = explode('-', $ticketid, 3);
	$sucdoc = (int) $sucdoc;
	$numdoc = (int) $numdoc;

    // Armo el WHERE.
    $wheredata = "th.tipodoc = '$tipodoc' and th.sucdoc = '$sucdoc' and th.numdoc = '$numdoc' and fl.tipodoc=th.tipodoc and fl.sucdoc = th.sucdoc and fl.numdoc = '$numdoc' and fl.codlinea=th.codlinea and th.cliente_id = '$clientid' and trim(fl.cliente_id) = '$clientid' ";

    // Recalculo el offset y limit.
    list($q_offset, $q_limit) =  calculate_offset($offset, $limit);

    // Count query
    $query_count->select = "count(*)";
    $query_count->from = "FactLineas fl, TraficoHistorico th left join Centrocostos cc on cc.linea=th.linea";
    $query_count->where = $wheredata;
    $query_count->groupby = "cc.centrocostos, desclinea, th.moneda";

    // Main query ( con limites )
    $query_main->select = "coalesce(cc.centrocostos, 'No Asignado') as centrocostos, fl.desclinea as desclinea, th.moneda, count(*) as llamados, sum(duracion) as duracion, sum(th.importe) as importe";
    $query_main->from = "FactLineas fl, TraficoHistorico th left join Centrocostos cc on cc.linea=th.linea";
    $query_main->where = $wheredata;
    $query_main->groupby = "cc.centrocostos, desclinea, th.moneda, duracion";
    $query_main->limit = ( $q_limit + $q_offset);

    // Sums para los totales
    $query_sum->select = "count(*), sum(th.importe), sum(th.duracion)";
    $query_sum->from = "FactLineas fl, TraficoHistorico th left join Centrocostos cc on cc.linea=th.linea";
    $query_sum->where = $wheredata;

    // Agrupacion por columna
    $agrupate = array("centrocostos");

    // Columnas con subtotales
    $counters = array("llamados", "duracion");

    // Field list
    $fields = array("desclinea", "llamados", "duracion", "importe");

    return traff_nf_execute_report(1, $fields, $query_main, $query_sum, $query_count, $agrupate, $counters, $offset, $limit, $is_last, $get_total, $total);
}

function get_traff_f_by_call_reference_summary($clientid, $ticketid, $offset, $limit, $is_last, $get_total, $total)
{
    $query_main = new sql_query();
    $query_count = new sql_query();
    $query_sum = new sql_query();

	list($tipodoc, $sucdoc, $numdoc) = explode('-', $ticketid, 3);
	$sucdoc = (int) $sucdoc;
	$numdoc = (int) $numdoc;

    // Armo el WHERE.
    $wheredata = "th.tipodoc = '$tipodoc' and th.sucdoc = '$sucdoc' and th.numdoc = '$numdoc' and fl.numdoc = '$numdoc' and fl.tipodoc=th.tipodoc and fl.sucdoc = th.sucdoc and fl.tipodoc = th.tipodoc and fl.codlinea=th.codlinea and th.cliente_id = '$clientid' and trim(fl.cliente_id) = '$clientid' ";

    // Recalculo el offset y limit.
    list($q_offset, $q_limit) =  calculate_offset($offset, $limit);

    // Count query
    $query_count->select = "count(*)";
    $query_count->from = "FactLineas fl, TraficoHistorico th left join Proyectos p on p.destino=th.destino";
    $query_count->where = $wheredata;
    $query_count->groupby = "p.proyecto, desclinea, th.moneda";

    // Main query ( con limites )
    $query_main->select = "coalesce(p.proyecto, 'No Asignado') as proyecto, fl.desclinea as desclinea, th.moneda, count(*) as llamados, sum(duracion) as duracion, sum(th.importe) as importe";
    $query_main->from = "FactLineas fl, TraficoHistorico th left join Proyectos p on p.destino=th.destino";
    $query_main->where = $wheredata;
    $query_main->groupby = "p.proyecto, desclinea, th.moneda, duracion";
    $query_main->limit = ( $q_limit + $q_offset);

    // Sums para los totales
    $query_sum->select = "count(*), sum(th.importe), sum(th.duracion)";
    $query_sum->from = "FactLineas fl, TraficoHistorico th left join Proyectos p on p.destino=th.destino";
    $query_sum->where = $wheredata;

    // Agrupacion por columna
    $agrupate = array("proyecto");

    // Columnas con subtotales
    $counters = array("llamados", "duracion");

    // Field list
    $fields = array("desclinea", "llamados", "duracion", "importe");

    return traff_nf_execute_report(1, $fields, $query_main, $query_sum, $query_count, $agrupate, $counters, $offset, $limit, $is_last, $get_total, $total);
}

function get_traff_f_by_source_summary($clientid, $ticketid, $offset, $limit, $is_last, $get_total, $total)
{
    $query_main = new sql_query();
    $query_count = new sql_query();
    $query_sum = new sql_query();

	list($tipodoc, $sucdoc, $numdoc) = explode('-', $ticketid, 3);
	$sucdoc = (int) $sucdoc;
	$numdoc = (int) $numdoc;

    // Armo el WHERE.
    $wheredata = "th.tipodoc = '$tipodoc' and th.sucdoc = '$sucdoc' and th.numdoc = '$numdoc' and th.cliente_id = '$clientid'";

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

function get_traff_f_by_target_summary($clientid, $ticketid, $offset, $limit, $is_last, $get_total, $total)
{
    $query_main = new sql_query();
    $query_count = new sql_query();
    $query_sum = new sql_query();

	list($tipodoc, $sucdoc, $numdoc) = explode('-', $ticketid, 3);
	$sucdoc = (int) $sucdoc;
	$numdoc = (int) $numdoc;

    // Armo el WHERE.
    $wheredata = "th.tipodoc = '$tipodoc' and th.sucdoc = '$sucdoc' and th.numdoc = '$numdoc' and th.cliente_id = '$clientid'";

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
    $query_main->groupby = "th.destino, th.moneda";
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

function get_traff_f_by_country_summary($clientid, $ticketid, $offset, $limit, $is_last, $get_total, $total)
{
    $query_main = new sql_query();
    $query_count = new sql_query();
    $query_sum = new sql_query();

	list($tipodoc, $sucdoc, $numdoc) = explode('-', $ticketid, 3);
	$sucdoc = (int) $sucdoc;
	$numdoc = (int) $numdoc;

    // Armo el WHERE.
    $wheredata = "th.tipodoc = '$tipodoc' and th.sucdoc = '$sucdoc' and th.numdoc = '$numdoc' and th.cliente_id = '$clientid'";

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
    $query_main->groupby = "th.destinotxt, th.moneda";
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






?>

<?
class Fecha
{

	function ahora($sql=0,$format='')
	{
		if($sql==1)
		{
			return date("Y-m-d H:i:s");
		}
		else if($format)
		{                                                                                                                   
			return date($format);
		}
		else
		{
			return date("d/m/Y H:i:s");
		}      
	}
	
	function hoy($sql=0,$format='')
	{
		if($sql==1)
		{
			return date("Y-m-d");
		}
		else if($format)
		{
			return date($format);
		}
		else
		{
			return date("d/m/Y");
		}
	}

	function ayer($sql=0,$format='')
	{
		$ayer_ts  = mktime(0,0,0,date("m"),date("d")-1,date("Y"));
		if($sql==1)
		{
			return date("Y-m-d",$ayer_ts);
		}
		else if($format)
		{
			return date($format,$ayer_ts);
		}
		else
		{
			return date("d/m/Y",$ayer_ts);
		}
	}

	function primeroMes($sql=0,$format='')
	{
		$primer_mes_ts  = mktime(0,0,0,date("m")-1,1,date("Y"));
		if($sql==1)
		{
			return date("Y-m-d",$primero_mes_ts);
		}
		else if($format)
		{
			return date($format,$primero_mes_ts);
		}
		else
		{
			return date("d/m/Y",$primero_mes_ts);
		}
	}
}

?>

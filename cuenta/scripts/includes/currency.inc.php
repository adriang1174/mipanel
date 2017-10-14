<?
Class Currency{
	var $UNIDADES = array(	'cero','un','dos','tres','cuatro','cinco','seis','siete','ocho','nueve','diez',
				  	'once','doce','trece','catroce','quince','dieciséis','diecisiete','dieciocho',
				  	'diecinueve','veinte','veintiuno','veintidós','veintitrés','veinticuatro',
				  	'veinticinco','veintiséis','veintisiete','veintiocho','veintinueve'
				  );
	var $DECENAS = array('diez','veinte','treinta','cuarenta','cincuenta','sesenta','setenta','ochenta','noventa','cien');
	var $CENTENAS = array('ciento','doscientos','trescientos','cuatrocientos','quinientos','seiscientos','setecientos','ochocientos','novecientos');

	function currency2Txt($valor) 
	{

        	$entero = 0;
        	$decimal = 0;
        	$negativo = $valor < 0;				//me fijo si el valor es negativo o positivo
	        $indexPunto = strpos($valor, '.');	//encuentro la posición del punto decimal
	
	        if ($indexPunto != -1)
	        {			//si tiene parte decimal las divido
	                $entero = substr($valor, 0, $indexPunto);
	                $decimal = substr($valor, $indexPunto+1);
	        }
	        else
	        {
	                $entero = $valor;
	        }
	
	        $str='';
	        if ($negativo)		// si el numero es negativo
        	{
	                 $str = ' menos ' . $this->_traducirNumero(substr($entero, 1));	//traduzco la parte entera menos el signo
        	}
	        else
	        {
	                 $str = ' ' . $this->_traducirNumero($entero);	//traduzco la parte entera
	        }
	        if ($decimal > 0)
	        {
	                $str .= (' con ' . $this->_traducirNumero($decimal) . ' centavos');  //traduzco la parte decimal
	        }

        	return $str;
	}

	 function _traducirNumero($numero,$str='')
	{
	
	        if (strlen($numero) == 1)
	        {
	                $str .= ' ' . $this->UNIDADES[$numero];
	        }
	        else if (strlen($numero) == 2)
	        {
		        	if ($numero < 30)
	        	{
	        		$str .= ' ' . $this->UNIDADES[$numero];
	        	}
	        	else
		        {
	        		$decena = substr($numero, 0, 1);
	        		if (($numero % 10) == 0)
	        		{
	        			$str .= ' ' . $this->DECENAS[$decena-1];
		        	}
	        		else
	        		{
		        			$str .= ' ' . $this->DECENAS[$decena-1] . ' y ' . $this->_traducirNumero(substr($numero, 1), $str);
	        		}
	        	}
	       	}
	        else if (strlen($numero) == 3)
        	{
        		if ($numero == 100)
        		{
        			$str .= ' cien';
        		}
        		else
        		{
                        	$centena = substr($numero, 0, 1);
                        	if (($numero % 100) == 0)
                        	{
                                	$str .= ' ' . $this->CENTENAS[$centena-1];
                        	}
                        	else
                        	{
                                	$str .= ' ' . $this->CENTENAS[$centena-1] . ' ' . $this->_traducirNumero(substr($numero, 1), $str);
                        	}
                	}
            	}
	        else
		{
			# Miles
			$leading = substr($numero, 0, strlen($numero)-3);
			$trailing = substr($numero, strlen($numero)-3);
			return $this->_traducirNumero($leading) . ' mil ' . $this->_traducirNumero($trailing);
		}
	       	return $str;
	}
}
?>


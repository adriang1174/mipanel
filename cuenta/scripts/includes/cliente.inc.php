<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

class Cliente {

    var $debug;	//flag, determina si esta en modo de debug
    
    function Cliente($debug = false) {
    	
    	$this->debug = $debug;

    }
    
    function getConfigEnvioFacturas($cliente_id, $default_envio = 1, $default_detalle = 0) {
        
        if ($this->debug) {
        	//echo "Cliente->getConfigEnvioFacturas() modo DEBUG<br />\n";
        }
        
        $query="
        	SELECT * FROM cliente_config 
        	WHERE cliente_id = ? AND clave IN ('ImagenFactura', 'DetalleConsumo');";
        $params=array($cliente_id);
        $db_obj= new Db;
        $result=$db_obj->getMultiTuplasObject($query,$params);
        $img_factura=$default_envio;
        $detalle_consumo=$default_detalle;
        foreach($result as $fila) {
            if($fila->clave=='ImagenFactura') {
                $img_factura=$fila->valor;
            } else if($fila->clave=='DetalleConsumo') {
                $detalle_consumo=$fila->valor;
            }
        }
        
        return array($img_factura, $detalle_consumo);
        
    }

    #######################################################################################################################

    # Devuelve un ARRAY de clientes de ese mercado para la fecha de facturacion especificada
    
    function buscarParaEnvioFacturas($mercado, $empresa, $fecha_emision, $default_envio=1, $default_detalle=0) {
        if ($this->debug) {
        	//echo "Cliente->buscarParaEnvioFacturas() modo DEBUG<br />\n";
        }
        
        // defino la consulta y defino los parámetros
        $query = "
        	SELECT 
        		c.mercado, c.empresa, sucdoc, numdoc, tipodoc, cpebanelco, 
        		cpelink, rsocial, cuit, f.domicilio, f.localidad, f.provincia, condpago, 
        		c.cliente_id as cliente_id, c.rsocial as rsocial, 
        		case when c.mail_admin_verif = 1 then c.mail_admin else c.email end AS email, 
        		condiva, neto, neto27, iva, iva27, ivani, iva27ni, 
        		(neto+neto27+iva+iva27+ivani+iva27ni+COALESCE(perciibb, 0)) AS total, 
        		moneda_id as moneda, fechemision, o.carpeta, o.owner_id,
        		fechvto,(0) as detalle_consumo, f.cae, to_char(f.fvtocae, 'DD/MM/YYYY') as fvtocae 
        	FROM 
        		factheader f, clientes c, owner o
        	WHERE 
        		fechemision = ? 
        		AND f.cliente_id = c.cliente_id 
			AND c.mercado = o.mercado AND c.empresa = o.empresa
        		AND estado_id=1 
        		AND c.mercado = ? AND c.empresa = ?  ";

        //if ($this->debug) $query .= " AND c.cliente_id = 'C100624' LIMIT 1";	//acotamos el nro. de resultados
        
//        if ($this->debug) $query .= " LIMIT 1";
        
       if ($this->debug) $query .= " AND c.cliente_id in('C100624','2099954','C110369') LIMIT 10";
        

		//CLIENTE T2
		//if ($this->debug) $query .= " AND c.cliente_id IN ('2192933') LIMIT 1";	//acotamos el nro. de resultados
		
		//CLIENTE HOLA
		//if ($this->debug) $query .= " AND c.cliente_id IN ('C507330') LIMIT 1";	//acotamos el nro. de resultados
		
		
		//if ($this->debug) $query .= " AND c.cliente_id IN ('C100624', '2099954', 'C502887') LIMIT 1";	//acotamos el nro. de resultados

        echo "QUERY ENVIO: ". $query;
        $params = array($fecha_emision,$mercado, $empresa);
        $db_obj = new Db;
        

		$parcial = $db_obj->getMultiTuplasObject($query, $params);
	
        $final = array();
        foreach($parcial as $cliente)   //por cada uno buscaré
        {
            $marcadores=$this->getConfigEnvioFacturas($cliente->cliente_id, $default_envio, $default_detalle);
            if($marcadores[0]) {
                if($marcadores[1]) {
                    $cliente->detalle_consumo = 1;
                }
                array_push($final, $cliente);
            }
        }

        return $final;
        
    }
    
    ##############################################################################################################################
                                                            
    
    # Devuelve un ARRAY de clientes que solicitaron el envio de alertas de trafico por e-mail

    function buscarConEnvioAlertas() {
        
        if ($this->debug) {
        	echo "Cliente->buscarConEnvioAlertas() modo DEBUG<br />\n";
        }
        
        // defino la consulta y defino los parámetros
	    $query = "
	    	SELECT 
	    		c.cliente_id, c.password, c.rsocial, c.cuit, c.cpebanelco, c.cpelink, case 
	    	WHEN 
	    		c.mail_admin_verif = 1 then c.mail_admin else c.email end as email, 
	    		c.agente, c.tipo, c.usuario, c.last_update, c.programa, c.pais, c.mercado, 
	    		c.empresa, c.estado_id, c.fecha_alta, c.mail_admin, c.mail_admin_verif 
	    	FROM 
	    		clientes c, cliente_config cc, owner o
	    	WHERE 
	    		c.cliente_id = cc.cliente_id 
				AND c.mercado = o.mercado
				AND c.empresa = o.empresa
				AND o.envia_ale = true
	    		AND cc.clave = ? 
	    		AND cc.valor = ? 
	    		AND c.email IS NOT NULL AND c.estado_id=1  
	    		";
	    		
	    if ($this->debug) $query .= " AND c.cliente_id = 'C100624' ";	//acotamos el nro. de resultados
	    
        $params=array('AlertaConsumos', '1');
        $db_obj= new Db;

        return $db_obj->getMultiTuplasObject($query,$params);
        
	}

                                                         
    
    ##############################################################################################################################
    
    # Devuelve un ARRAY de clientes que solicitaron el envio de informes de trafico por e-mail

    function buscarConEnvioInformes() {
        
        if ($this->debug) {
        	echo "Cliente->buscarConEnvioInformes() modo DEBUG<br />\n";
        }
        
        // defino la consulta y defino los parámetros
        $query = "
        	SELECT 
        		c.cliente_id, c.password, c.rsocial, c.cuit, c.cpebanelco, 
        		c.cpelink, case when c.mail_admin_verif=1 THEN c.mail_admin ELSE c.email end AS email, 
        		c.agente, c.tipo, c.usuario, c.last_update, c.programa, c.pais, c.mercado, c.empresa, 
        		c.estado_id, c.fecha_alta, c.mail_admin, c.mail_admin_verif, o.owner_id
        	FROM 
        		clientes c, cliente_config  cc , owner o
        	WHERE 
        		c.cliente_id = cc.cliente_id and cc.clave = ? 
        		and cc.valor = ? and c.email is not null and c.estado_id=1 
				AND c.mercado = o.mercado
				AND c.empresa = o.empresa
				AND o.envia_inf = true
        		";
        
	if ($this->debug) $query .= " AND c.cliente_id = 'C100624' LIMIT 1";    //acotamos el nro. de resultados

        $params=array('InformeConsumos', '1' );
        $db_obj= new Db;
        
        return $db_obj->getMultiTuplasObject($query,$params);
        
    }

 }

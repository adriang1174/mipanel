<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Factura</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<base href="https://webseg.alternativa.com.ar/" />
<link rel="stylesheet" type="text/css" href="css/<%mercado_desc%>/estilo.css" />
</head>
<body>

<div class="contenedor">
    <div class="bg-amarillo">
    	<div id="top">
            <div id="tipo-factura">
                <ul>
                    <li class="tipo"><span><%tipo_factura%></span></li>
                    <li>C&oacute;digo N&ordm; 06</li>
                </ul>
            </div>
            <div id="address-alternativa">
                <ul class="negrita">
                    <li>Humboldt 1917</li>
                    <li>C1414CTU</li>
                    <li>Ciudad Aut&oacute;noma</li>
                    <li>de Buenos Aires</li>
                </ul>
                
                <ul class="uppercase">
                    <li>Red Alternativa S.A.</li>
                    <li>IVA Responsable Inscripto</li>
                    <li>CUIT 30-69898565-4</li>
                    <li>Ingresos Brutos 901-029230-6</li>
                    <li>Inicio de Actividades Dic. 1998</li>
                </ul>
            </div>
        </div>
        
        <div id="info-cliente">
        	<div id="cliente">
            	<strong>SE&Ntilde;OR/ES:</strong><span><%rsocial%></span>
                <strong>DOMICILIO:</strong>
                <span><%domicilio%><br/>
                <%localidad%><br/>
                <%provincia%>
                </span>
            </div>
            
            <div id="nro-cliente">
				<strong>CUIT:</strong><span><%cuit%></span>
                <strong>Cond. Pago:</strong><span><%condpago%></span>
                <strong>Cond. IVA:</strong><span><%condiva%></span>
                <p>Claves de pago electr&oacute;nico:</p>
                <ul>
                	<li><strong>Banelco</strong><span><%cpebanelco%></span></li>
                    <li><strong>Link</strong><span><%cpelink%></span></li>
                </ul>
            </div>
            
            <div id="cod-cliente">
				<h2>F<%tipo_factura%>-<nobr><%nfactura%></nobr></h2>
                <ul>
                	<li><strong class="left">Fecha de Emisi&oacute;n:</strong><span class="right"><%fechaemision%></span></li>
                    <li><strong class="left">Fecha de Vencimiento:</strong><span class="right"><%fechvto%></span></li>
                    <li><strong class="left">C&oacute;digo de Cliente:</strong><span class="right"><%cliente_id%></span></li>
                </ul>
            </div>
        </div>
    </div>
    
    <div id="monto">
        <table>
            <tr>
                <th align="left" width="622">Conceptos</th>
                <th align="center" width="140">Unidades</th>
                <th>&nbsp;</th>
                <th align="center" width="100">Importes</th>
            </tr>
            <%lineas%>
        </table>
    </div>
    
    <%discrimina%>
    
    <div id="total">
    	<table>
        	<tr>
            	<td align="left"><%valor_letras%></td>
                <td align="right" class="border-right"><strong>Total</strong></td>
                <td align="center" width="145"><%total%></td>
            </tr>
        </table>
    </div>
    <div id="entidades">
    	<p>Entidades habilitadas para el cobro: Galicia / Pago F&aacute;cil / Pagomiscuentas<br />
        La falta de Pago en Fecha Prevista generar&aacute; un inter&eacute;s punitorio<br />
        de acuerdo al art. 16 del RGCSBT</p>
    </div>
    
    
    <div id="codigo">
    	<ul>	
        	<li>Total factura <%total%></li>
            <li><img src="<%urlbarcode%>" width="301" height="50" alt="" /></li>
        </ul>
     
    </div>
   
   
   <div id="cae">
    	<p>C.A.E.: <%cae%></p>
    	<p>Fecha de vencimiento: <%fvtocae%></p>
    </div>
   
    <div class="bg-gris">
    	<div class="bg-amarillo" id="footer">
        	<ul>
            	<li><img src="img/<%mercado_desc%>/alternativa.gif" alt="" /></li>
                <li class="margin"><a href="mailto:asisentencia@alternativa.com.ar"><img src="img/<%mercado_desc%>/asistencia_alternativa.gif" alt="" /></a></li>
                <li><a href="http://www.alternativa.com.ar/"><img src="img/<%mercado_desc%>/alternativa_com.gif" alt="" /></a></li>
            </ul>
        </div>
    </div>
</div>

</body>
</html>

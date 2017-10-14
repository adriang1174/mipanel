<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Factura</title>
<base href="https://webseg.alternativa.com.ar">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="css/<%mercado_desc%>/estilo.css">
</head>
<body>

<div class="contenedor">
    <div class="bg-azul">
    	<div id="top">
            <div id="tipo-factura">
                <ul>
                    <li class="tipo">&nbsp;</li>
                </ul>
            </div>
            <div id="address-alternativa">
            	<!--
                <ul class="negrita">
                    <li>Humboldt 1917</li>
                    <li>C1414CTU</li>
                    <li>Ciudad Aut&oacute;noma</li>
                    <li>de Buenos Aires</li>
                </ul>
                -->
                <ul class="uppercase">
                    <li>Latinatel  S.A.</li>
                    <li>Av. Ponce 1302 Piso 11</li>
                    <li>11300 Montevideo, Uruguay</li>
                    <li><a href="mailto:asistencia@holatel.com">asistencia@holatel.com</a></li>
                    <li><a href="http://www.holatel.com/">www.holatel.com</a></li>
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
               
            </div>
            
            <div id="cod-cliente">
				<h2>F-<%nfactura%></h2>
                <ul>
                	<li><strong class="left">Fecha de Emisión:</strong><span class="right"><%fechaemision%></span></li>
                    <li><strong class="left">Fecha de Vencimiento:</strong><span class="right"><%fechvto%></span></li>
                    <li><strong class="left">Código de Cliente:</strong><span class="right"><%cliente_id%></span></li>
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
    
   
    <div class="bg-gris">
    	<div class="bg-azul" id="footer">
        	<ul>
            	<li><img src="https://webseg.alternativa.com.ar/img/hola/hola_com.gif" width="130" height="30" alt="" /></li>
                <li class="margin"><a href="mailto:asisentencia@holatel.com"><img src="https://webseg.alternativa.com.ar/img/hola/asistencia_holatel.gif" width="184" height="30" alt="" /></a></li>
                <li><a href="http://www.holatel.com/"><img src="https://webseg.alternativa.com.ar/img/hola/holatel_com.gif" width="147" height="30" alt="" /></a></li>
            </ul>
        </div>
    </div>
</div>

</body>
</html>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Factura</title>
<base href="https://zonasegura.grupoalternativa.com/">
<link rel="stylesheet" type="text/css" href="css/<%mercado_desc%>/ca.css">
</head>
<body>
<table border="0" cellpadding="3" cellspacing="1" width="100%">	
	<tr>
		<td>
			<img src="img/<%mercado_desc%>/logos.gif" border="0" />
		</td>
		<td>&nbsp;
			
				
		</td>
		<td align="right" width="100%">
			<table border="0" cellpadding="3" cellspacing="1" width="100%">	
			<tr>
				<td align="right" class="comprobante-title">Factura N</td>
				<td align="right" style="font-size: 80%; color: black; font-weight: bold;"><%nfactura%></td>
			</tr>	
			<tr>
				<td align="right" class="comprobante-title">Fecha</td>
				<td align="right" style="font-size: 70%; color: black;"><%fechaemision%></td>
			</tr>	
			<tr>
				<td align="right" class="comprobante-title">Vencimiento</td>
				<td align="right" style="font-size: 70%; color: black;">
					<%fechvto%>
				</td>
			</tr>	
			</table>	
		</td>
	</tr>
</table>
	<table border="0" cellpadding="3" cellspacing="1" width="100%">	
	<tr>
		<td style="font-size: 55%; font-family: Arial;" valign="top" align="left"><strong>Latinatel S.A.</strong><br/>Av. Ponce 1302 Piso 11<br/>
		11300 Montevideo, Uruguay<br/>
		asistencia@ahorratel.com<br/>
		www.ahorratel.com</td>
		<td style="font-size: 55%; font-family: Arial;" valign="top"><!--IVA Responsable Inscripto<br/><strong>CUIT</strong> 30-69898565-4<br/><strong>Ingresos Brutos</strong> 901-029230-6<br/><strong>Inicio de Actividades</strong> Diciembre 1998--></td>
		<td align="right" style="font-size: 55%;" valign="middle"><!--Clave de Pago Electrónico <strong>Banelco</strong>: <%cpebanelco%><br/><br/>Clave de Pago Electrónico <strong>Link</strong>: <%cpelink%>--></td>
	</tr>
	</table>
	<br/><br/>
	<table border="0" cellpadding="3" cellspacing="1" style="font-size: 70%;" width="100%">	
	<tr>
		<td align="left"><strong>Señor/es:</strong></td>
		<td align="left"><%rsocial%></td>
		<td align="left"><strong>CUIT:</strong> </td>
		<td align="left"><%cuit%></td>
	</tr>
	<tr>
		<td align="left"><strong>Domicilio: </strong></td>
		<td align="left"><%domicilio%><br/><%localidad%><br/><%provincia%></td>
		<td align="left"><strong>Cond. de pago: </strong></td>
		<td align="left"><%condpago%></td>
	</tr>
	<tr>
		<td align="left"><strong>Código de cliente: </strong></td>
		<td align="left"><%cliente_id%></td>
		<td align="left"><strong>Cond. frente al IVA: </strong></td>
		<td align="left"><%condiva%></td>
	</tr>
	</table>
	<br/>
	<table border="0" cellpadding="4" cellspacing="0" style="font-size: 70%;" width="100%">	
	<tr>
		<td class="comprobante-header" align="left"><strong>Descripción</strong></td>
		<td class="comprobante-header" align="left"><strong>Unidades</strong></td>
		<td class="comprobante-header" align="right"><strong>Importe</strong></td>
	</tr>
	<%lineas%>
	<tr>
		<td colspan="3" width="95%" class="comprobante-desc" style="padding-top: 30px;">
			<table border="0" cellpadding="3" cellspacing="1" style="font-size: 100%; background-color: black;" width="100%">	
			<%discrimina%>
			<tr>
				<td class="comprobante-desc" colspan="5" align="left">Son <%valor_letras%></td>
				<td class="comprobante-desc" align="right" width="90"><strong>Total: </strong></td>
				<td class="comprobante-desc" align="right" width="90"><strong><%total%></strong></td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
	<p class="informe-footer">La información es presentada al sólo efecto informativo. Los datos surgen de los registros en Ahorratel, salvo error u omisión involuntaria. Ante cualquier duda o discrepancia, por favor comuníquese a <a href="mailto:asistencia@ahorratel.com" title="Por consultas, escríbanos a nuestro e-mail de Asistencia">asistencia@ahorratel.com</a>.</p>
</body>
</html>
	

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Facturas</title>
<base href="https://zonasegura.grupoalternativa.com/">
<link rel="stylesheet" type="text/css" href="css/<%mercado_desc%>/ca.css">
</head>
<body>
<table border="0" cellpadding="3" cellspacing="1" width="100%">	
	<tr>
		<td>
			<img src="img/<%mercado_desc%>/logos.gif" border="0" />
		</td>
		<td>
			<img src="img/<%mercado_desc%>/<%tipo_factura%>.gif" border="0" width="35" height="49" />
				
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
		<td style="font-size: 55%; font-family: Arial;" valign="top"><strong>Red Alternativa S.A.</strong><br/>Humboldt 2495 3p<br/>C1107BVA Buenos Aires Argentina<br/>Tel 0-810-3210-733<br/>www.alternativa.com</td>
		<td style="font-size: 55%; font-family: Arial;" valign="top">IVA Responsable Inscripto<br/><strong>CUIT</strong> 30-69898565-4<br/><strong>Ingresos Brutos</strong> 901-029230-6<br/><strong>Inicio de Actividades</strong> Diciembre 1998</td>
		<td align="right" style="font-size: 55%;" valign="middle">Clave de Pago Electrónico <strong>Banelco</strong>: <%cpebanelco%><br/><br/>Clave de Pago Electrónico <strong>Link</strong>: <%cpelink%></td>
	</tr>
	</table>
	<br/><br/>
	<table border="0" cellpadding="3" cellspacing="1" style="font-size: 70%;" width="100%">	
	<tr>
		<td><strong>Señor/es:</strong></td>
		<td><%rsocial%></td>
		<td><strong>CUIT:</strong> </td>
		<td><%cuit%></td>
	</tr>
	<tr>
		<td><strong>Domicilio: </strong></td>
		<td><%domicilio%><br/><%localidad%><br/><%provincia%></td>
		<td><strong>Cond. de pago: </strong></td>
		<td><%condpago%></td>
	</tr>
	<tr>
		<td><strong>Código de cliente: </strong></td>
		<td><%cliente_id%></td>
		<td><strong>Cond. frente al IVA: </strong></td>
		<td><%condiva%></td>
	</tr>
	</table>
	<br/>
	<table border="0" cellpadding="4" cellspacing="0" style="font-size: 70%;" width="100%">	
	<tr>
		<td class="comprobante-header"><strong>Descripción</strong></td>
		<td class="comprobante-header"><strong>Unidades</strong></td>
		<td class="comprobante-header" align="right"><strong>Importe</strong></td>
	</tr>
	<%lineas%>
	<tr>
		<td colspan="3" width="95%" class="comprobante-desc" style="padding-top: 30px;">
			<table border="0" cellpadding="3" cellspacing="1" style="font-size: 100%; background-color: black;" width="100%">	
			<%discrimina%>
			<tr>
				<td class="comprobante-desc" colspan="5">Son <%valor_letras%></td>
				<td class="comprobante-desc" align="right" width="90"><strong>Total: </strong></td>
				<td class="comprobante-desc" align="right" width="90"><strong><%total%></strong></td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
	<p class="informe-footer">La información es presentada al sólo efecto informativo. Los datos surgen de los registros en Alternativa, salvo error u omisión involuntaria. Ante cualquier duda o discrepancia, por favor comuníquese a <a href="mailto:asistencia@alternativa.com.ar">asistencia@alternativa.com.ar</a> o telefónicamente, con nuestro Centro de Atención al Cliente, a través del 0-810-3210-733.</p>
</body>
</html>
	

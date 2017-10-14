<style type="text/css">
* {margin:0; padding:0; outline:0; border:0;}
#ConfiguracionDeDiscado {width:495px; margin:0 auto;}
#ConfiguracionDeDiscado div {float:left; display:inline;}
#ConfiguracionDeDiscado .Configuracion {width:471px; margin:12px;}
/* TOP */
#ConfiguracionDeDiscado .Top {background:url(<!--{ipath name="dialplan-pasos.jpg" lang="1" owner="1"}-->); width:471px; height:29px;}
#ConfiguracionDeDiscado #Cero .Top {background-position:left top;}
#ConfiguracionDeDiscado #Uno .Top {background-position:left -29px;}
#ConfiguracionDeDiscado #Dos .Top {background-position:left -58px;}
#ConfiguracionDeDiscado #Tres .Top {background-position:left -87px;}
#ConfiguracionDeDiscado #Cuatro .Top {background-position:left -116px;}
#ConfiguracionDeDiscado #Cinco .Top {background-position:left -145px;}
#ConfiguracionDeDiscado a {float:left; display:inline; width:94px; height:29px;
background-image:url(<!--{ipath name="dialplan-pasos.jpg" lang="1" owner="1"}-->); background-repeat:no-repeat; background-position:-9999px;}
#ConfiguracionDeDiscado .Uno:hover {background-position:left -29px;}
#ConfiguracionDeDiscado .Dos:hover {background-position:-94px -58px;}
#ConfiguracionDeDiscado .Tres:hover {background-position:-188px -87px;}
#ConfiguracionDeDiscado .Cuatro:hover {background-position:-282px -116px;}
#ConfiguracionDeDiscado .Cinco:hover {background-position:-376px -145px;}
/* Instrucciones */
#ConfiguracionDeDiscado .Instrucciones {width:445px; height:275px; overflow:hidden; border:#E7E7E8 1px solid; font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#808285; position:relative; padding:12px;}
#ConfiguracionDeDiscado .Instrucciones p {margin-bottom:12px;}
#ConfiguracionDeDiscado .Volver {position:absolute; right:20px; bottom:20px;}
#ConfiguracionDeDiscado .Avanzar {color:#f7911e; text-decoration:none;}
#ConfiguracionDeDiscado .Avanzar:hover {text-decoration:underline;}
#ConfiguracionDeDiscado select, #ConfiguracionDeDiscado input {padding:1px 3px; border:#E7E7E8 1px solid;
font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#808285; width:180px;}
#ConfiguracionDeDiscado ul {color:#f7911e; line-height:20px;}
#ConfiguracionDeDiscado li {list-style:none;}
/* Paso */
#ConfiguracionDeDiscado #Cero .Paso {background:url(<!--{ipath name="X-Lite.jpg" lang="0" owner="0"}-->) right 40px no-repeat;
padding:50px 250px 0 0; width:195px; height:237px;}
#ConfiguracionDeDiscado #Uno .Paso {margin:75px 0 0 130px; width:315px;}
#ConfiguracionDeDiscado #Dos .Paso {margin:75px 0 0 100px; width:345px;}
#ConfiguracionDeDiscado #Tres .Paso, #ConfiguracionDeDiscado #Cuatro .Paso, #ConfiguracionDeDiscado #Cinco .Paso
{margin:50px 40px 0; width:365px;}
.tabcentro tr td {padding:0 8px;text-align:left;}
</style>
<script type="text/javascript">
	function validarInt(valor){
		if(valor == ""){
			return true;
		}
		var reg=/^[+]?\d+$/;
		return reg.test(valor);
	}
	
	function mostrarPaso(paso, print){
		switch(paso){
			case "0": 
				hide_all();
				document.getElementById('Cero').style.display = 'block';				
			break;
			case "1":
				hide_all();
				document.getElementById('Uno').style.display = 'block';				
			break;
			case "2":
				hide_all();
				document.getElementById('Dos').style.display = 'block';				
			break;
			case "3":
				if(!validarInt(document.getElementById('Codigo_Area').value)){
					alert("El codigo de area debe ser un valor numerico");
					return false;
				}
				hide_all();
				document.getElementById('Tres').style.display = 'block';				
			break;
			case "4":
				if(!validarInt(document.getElementById('Codigo_PSTN').value)){
					alert("El codigo para llamar a numeros de linea debe ser un valor numerico");
					return false;
				}
				if(document.getElementById('Codigo_PSTN').value > 9){
					alert("El codigo debe ser un valor numerico del 0 al 9");
					return false;
				}
				hide_all();
				document.getElementById('Cuatro').style.display = 'block';			
			break;
			case "5":
				if(!validarInt(document.getElementById('Codigo_SIP').value)){
					alert("El codigo para llamar a numeros sip debe ser un valor numerico");
					return false;
				}
				if(document.getElementById('Codigo_SIP').value > 9){
					alert("El codigo debe ser un valor numerico del 0 al 9");
					return false;
				}
				if(document.getElementById('Codigo_SIP').value == document.getElementById('Codigo_PSTN').value){
					alert("El codigo deber ser diferente al codigo para llamar a numeros de linea");
					return false;
				}
				hide_all();
				document.getElementById('Cinco').style.display = 'block';
			break;
			case "confirmar":
				if (print) document.getElementById('print').value = 1;
				if(!validarInt(document.getElementById('Codigo_Escape_Int').value)){
					alert("El codigo de salida internacional debe ser un valor numerico");
					return false;
				}
				if(!validarInt(document.getElementById('Codigo_Escape_Nac').value)){
					alert("El codigo de salida nacional debe ser un valor numerico");
					return false;
				}
				if(!validarInt(document.getElementById('Codigo_Escape_Loc').value)){
					alert("El codigo de salida local debe ser un valor numerico");
					return false;
				}
				document.getElementById('form_discado').submit();
			break;
			case "email":
				document.getElementById('send_email').value = 1;
				document.getElementById('form_discado').submit();
			break;
		}
	}
	
	function hide_all() {
		document.getElementById('Start').style.display = 'none';
		document.getElementById('Cero').style.display = 'none';
		document.getElementById('Uno').style.display = 'none';
		document.getElementById('Dos').style.display = 'none';
		document.getElementById('Tres').style.display = 'none';
		document.getElementById('Cuatro').style.display = 'none';
		document.getElementById('Cinco').style.display = 'none';
	}
	

	function imprSelec(nombre){
		
		var ficha = document.getElementById(nombre);
		var tituloFicha = document.getElementById('titulo_' + nombre);
		
		var ventimp = window.open('', 'popimpr', 'width=600,height=300');
		ventimp.document.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"');
		ventimp.document.write('"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">');
		ventimp.document.write('<html xmlns="http://www.w3.org/1999/xhtml">');
		ventimp.document.write('<head>');
		ventimp.document.write('<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />');
		ventimp.document.write('<title>Configuraci&oacute;n de marcado</title>');
		ventimp.document.write('<link href="css/dialplan_print.css" rel="stylesheet" type="text/css" />');
		ventimp.document.write('</head><body>');
		 
		ventimp.document.write('<div id="imgFondo"></div>');
		
		ventimp.document.write('<div id="resumen">');
		
		ventimp.document.write(tituloFicha.innerHTML);
		ventimp.document.write(ficha.innerHTML);
		
		
		ventimp.document.write('</div>');
		ventimp.document.write('</body></html>');
		ventimp.document.close();
		
		ventimp.print();
		ventimp.close();
		
	}

	function change_country(value) {
		document.getElementById('Pais_SELECT').innerHTML = value;
		document.getElementById('Pais_DENOM').innerHTML = value;
	}	
	
	function print() {
		document.getElementById('print').value = 1;
	}
	
</script>

<table border="0" cellspacing="0" cellpadding="0" width="100%">
                
        <!--{if $show_select}-->
		<tr><td>
			<form name="frmLine" id="frmLine" method="post" action="">
			<table>
			<tr>
				<td>Selecciona una l&iacute;nea &nbsp;&nbsp;</td>
				<td>
				<select name="line">
					<!--{foreach name="lines" from=$lines item="line"}-->
					<option value="<!--{$line[0]}-->"><!--{$line[0]}--></option>
					<!--{/foreach}-->
				</select>
				</td>
				<td>
				<input type="image" src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->" />
				</td>
			</tr>
			</table>
			</form>
		</td></tr>
		<!--{/if}-->
		
		<!--{if $show_form}-->
		<tr><td style="padding-left: 13px;">
	
		
			<div id="titulo_resumen" style="display:none"><span class="subtitulo">Configuraci&oacute;n de discado nro. <!--{$selected_line}--></span><br /></div>
			<div id="resumen" style="display:none;">
			<p style="height:40px;">Para llamar a un tel&eacute;fono IP, deb&eacute;s marcar <b><!--{$REGLA_DISCADO_SIP}-->[n&uacute;mero].</b></p>

			<p style="height:26px;">Para llamar a un tel&eacute;fono de l&iacute;nea:</p>
			<p style="height:20px;">&nbsp;&nbsp;&nbsp;Si es llamada local, deb&eacute;s marcar <b><!--{$REGLA_DISCADO_LOCAL}-->[n&uacute;mero].</b></p>
			<p style="height:20px;">&nbsp;&nbsp;&nbsp;Si es llamada de larga distancia nacional, deb&eacute;s marcar <b><!--{$REGLA_DISCADO_LARGA_DISTANCIA_NACIONAL}-->[n&uacute;mero].</b></p>
			<p style="height:20px;">&nbsp;&nbsp;&nbsp;Si es llamada de larga distancia internacional, deb&eacute;s marcar <b><!--{$REGLA_DISCADO_LARGA_DISTANCIA_INTERNACIONAL}-->[n&uacute;mero].</b></p>		
			</div>
			<form action="" method="post" id="form_discado">
			<input type="hidden" id="send_email" name="send_email" value="0" />
			<input type="hidden" id="save_dialplan" name="save_dialplan" value="1" />
			<input type="hidden" id="line" name="line" value="<!--{$selected_line}-->" />
			<table class="tabcentro" style="width: 730px;">
				<!--{if ($msg_guardar_ok)}-->
				<tr><td style="text-align: center"><b>El discado ha sido guardado. </b></td></tr>
				<tr><td style="text-align: center">&nbsp;</td></tr>            
				<!--{/if}-->
				<!--{if ($msg_guardar_ko)}-->
				<tr><td style="text-align: center"><span class="errMsg"><b>La opci&oacute;n de marcado no pudo ser guardada.</b></span> </td></tr>
				<tr><td style="text-align: center">&nbsp;</td></tr>
				<!--{/if}-->
				<!--{if ($msg_mail)}-->
				<tr><td style="text-align: center"><b>Se ha enviado un e-mail con tu opci&oacute;n de marcado a tu casilla de correo. </b></td></tr>
				<tr><td style="text-align: center">&nbsp;</td></tr>            
				<!--{/if}-->
			   <tr>
					<td>
						<div id="ConfiguracionDeDiscado">
						<div class="Configuracion" id="Start" style="width: 500px">
			<p style="height:40px;">Para llamar a un tel&eacute;fono IP, deb&eacute;s marcar <b><!--{$REGLA_DISCADO_SIP}-->[n&uacute;mero].</b></p>

			<p style="height:26px;">Para llamar a un tel&eacute;fono de l&iacute;nea:</p>
			<p style="height:20px;">&nbsp;&nbsp;&nbsp;Si es llamada local, deb&eacute;s marcar <b><!--{$REGLA_DISCADO_LOCAL}-->[n&uacute;mero].</b></p>
			<p style="height:20px;">&nbsp;&nbsp;&nbsp;Si es llamada de larga distancia nacional, deb&eacute;s marcar <b><!--{$REGLA_DISCADO_LARGA_DISTANCIA_NACIONAL}-->[n&uacute;mero].</b></p>
			<p style="height:20px;">&nbsp;&nbsp;&nbsp;Si es llamada de larga distancia internacional, deb&eacute;s marcar <b><!--{$REGLA_DISCADO_LARGA_DISTANCIA_INTERNACIONAL}-->[n&uacute;mero].</b></p>
			<p>&nbsp;</p>
			<table><tr>
			
			<td><a href="#" title="Enviar por email" onclick="mostrarPaso('email'); return false;"><img src="<!--{ipath name="btn-enviarEmail.gif" lang="1" owner="1"}-->" alt="Enviar" /></a></td>
			<td>&nbsp;</td>
			<td><a href="#" title="Imprimir" onclick="imprSelec('resumen'); return false;"><img src="<!--{ipath name="btn-imprimir.gif" lang="1" owner="1"}-->" alt="Imprimir" /></a></td>
			<tr>
			</table>
	


			<a href="#" onclick="mostrarPaso('1'); return false;" style="color: #FF9900; width: 400px;">Ingres&aacute; aqu&iacute; para modificar uno o varios de estos &iacute;tems</a>		
			</div>			
						<div class="Configuracion" id="Cero" style="display: none;">
						<div class="Top">
							<a href="#" onclick="mostrarPaso('1'); return false;" class="Uno"></a>
							<a href="#" onclick="mostrarPaso('2'); return false;" class="Dos"></a>
							<a href="#" onclick="mostrarPaso('3'); return false;" class="Tres"></a>
							<a href="#" onclick="mostrarPaso('4'); return false;" class="Cuatro"></a>
							<a href="#" onclick="mostrarPaso('5'); return false;" class="Cinco"></a>
						</div>
						<div class="Instrucciones">
							<div class="Paso">
								<p>A continuaci&oacute;n podr&aacute;s configurar el softphone para llamar a quien quieras desde tu PC con las mejores tarifas y recibir llamadas est&eacute;s donde est&eacute;s.</p>
								<p style="text-align:right;"><a href="#" onclick="mostrarPaso('1'); return false;" class="Avanzar">empezar &gt;&gt;</a></p>
							</div>
						</div>
						</div>				
						<div class="Configuracion" id="Uno" style="display: none">
						<div class="Top">
							<a href="#" onclick="mostrarPaso('1'); return false;" class="Uno"></a>
							<a href="#" onclick="mostrarPaso('2'); return false;" class="Dos"></a>
							<a href="#" onclick="mostrarPaso('3'); return false;" class="Tres"></a>
							<a href="#" onclick="mostrarPaso('4'); return false;" class="Cuatro"></a>
							<a href="#" onclick="mostrarPaso('5'); return false;" class="Cinco"></a>
						</div>
					<div class="Instrucciones">
						<div class="Paso">
						    <p>Seleccion&aacute; tu pa&iacute;s de residencia.</p>
						    <p><select name="Codigo_Pais" id="Codigo_Pais" class="validate-integer textbox" onchange="change_country(this.options[this.selectedIndex].text)">
							<!--{foreach name="arr_paises" from=$arr_paises item="pais"}-->
							<option value="<!--{$pais.CODIGO}-->" <!--{$pais.SELECTED}-->><!--{$pais.NOMBRE}--></option>
							<!--{/foreach}-->
							</select></p>
						    <p><a href="#" onclick="mostrarPaso('2'); return false;" class="Avanzar" style="width:300px">ir al paso siguiente &gt;&gt;</a></p>
						</div>
						<a href="#" onclick="mostrarPaso('0'); return false;" class="Volver" title="Volver"><img src="<!--{ipath name="Volver" lang="1" owner="1"}-->" alt="Volver" /></a>
					</div>
					</div>
					 <div class="Configuracion" id="Dos" style="display: none">
						<div class="Top">
							<a href="#" onclick="mostrarPaso('1'); return false;" class="Uno"></a>
							<a href="#" onclick="mostrarPaso('2'); return false;" class="Dos"></a>
							<a href="#" onclick="mostrarPaso('3'); return false;" class="Tres"></a>
							<a href="#" onclick="mostrarPaso('4'); return false;" class="Cuatro"></a>
							<a href="#" onclick="mostrarPaso('5'); return false;" class="Cinco"></a>
						</div>
					<div class="Instrucciones">
						<div class="Paso">
						    <p>Ingres&aacute; el c&oacute;digo de &aacute;rea de tu ciudad de residencia.</p>
						    <p><input name="Codigo_Area" id="Codigo_Area" type="text" value="<!--{$dialplan.Codigo_Area}-->" /></p>
						    <p><a href="#" onclick="mostrarPaso('3'); return false;" class="Avanzar">aceptar &gt;&gt;</a></p>
						</div>
						<a href="#" onclick="mostrarPaso('1'); return false;" class="Volver" title="Volver"><img src="<!--{ipath name="Volver" lang="1" owner="1"}-->" alt="Volver" /></a>
					</div>
				</div>
		
					 <div class="Configuracion" id="Tres" style="display: none">
						<div class="Top">
							<a href="#" onclick="mostrarPaso('1'); return false;" class="Uno"></a>
							<a href="#" onclick="mostrarPaso('2'); return false;" class="Dos"></a>
							<a href="#" onclick="mostrarPaso('3'); return false;" class="Tres"></a>
							<a href="#" onclick="mostrarPaso('4'); return false;" class="Cuatro"></a>
							<a href="#" onclick="mostrarPaso('5'); return false;" class="Cinco"></a>
						</div>
					<div class="Instrucciones">
						<div class="Paso">
						    <p>Ingres&aacute; un n&uacute;mero del 0 al 9, que es el que deber&aacute;s marcar en adelante para realizar comunicaciones a tel&eacute;fonos de l&iacute;nea.</p>
						    <p>Pod&eacute;s optar por no ingresar un c&oacute;digo para llamar a tel&eacute;fonos de l&iacute;nea; de ser as&iacute;, en el siguiente paso deber&aacute;s seleccionar un c&oacute;digo para llamar a tel&eacute;fonos IP.</p>
						    <p><input name="Codigo_PSTN" id="Codigo_PSTN" type="text" value="<!--{$dialplan.Codigo_PSTN}-->" /></p>
						    <p><a href="#" onclick="mostrarPaso('4'); return false;" class="Avanzar">&iexcl;ya falta poco! &gt;&gt;</a></p>
						</div>
						<a href="#" onclick="mostrarPaso('2'); return false;" class="Volver" title="Volver"><img src="<!--{ipath name="Volver" lang="1" owner="1"}-->" alt="Volver" /></a>
					</div>
				</div>
			
						<div class="Configuracion" id="Cuatro" style="display: none">
						<div class="Top">
							<a href="#" onclick="mostrarPaso('1'); return false;" class="Uno"></a>
							<a href="#" onclick="mostrarPaso('2'); return false;" class="Dos"></a>
							<a href="#" onclick="mostrarPaso('3'); return false;" class="Tres"></a>
							<a href="#" onclick="mostrarPaso('4'); return false;" class="Cuatro"></a>
							<a href="#" onclick="mostrarPaso('5'); return false;" class="Cinco"></a>
						</div>
					<div class="Instrucciones">
						<div class="Paso">
						    <p>Ingres&aacute; un n&uacute;mero del 0 al 9, que es el que deber&aacute;s marcar en adelante para realizar comunicaciones a tel&eacute;fonos IP. Debe ser distinto al que seleccionaste en el paso anterior.</p>
						    <p>Si ingresaste un n&uacute;mero para realizar llamadas a tel&eacute;fonos de l&iacute;nea, pod&eacute;s optar por no ingresar un c&oacute;digo para comunicarte a tel&eacute;fonos IP.</p>
						    <p><input name="Codigo_SIP" id="Codigo_SIP" type="text" value="<!--{$dialplan.Codigo_SIP}-->" /></p>
						    <p><a href="#" onclick="mostrarPaso('5'); return false;" class="Avanzar">ir al &uacute;ltimo paso &gt;&gt;</a></p>
						</div>
						<a href="#" onclick="mostrarPaso('3'); return false;" class="Volver" title="Volver"><img src="<!--{ipath name="Volver" lang="1" owner="1"}-->" alt="Volver" /></a>
					</div>
				</div>			
						<div class="Configuracion" id="Cinco" style="display: none">
						<div class="Top">
							<a href="#" onclick="mostrarPaso('1'); return false;" class="Uno"></a>
							<a href="#" onclick="mostrarPaso('2'); return false;" class="Dos"></a>
							<a href="#" onclick="mostrarPaso('3'); return false;" class="Tres"></a>
							<a href="#" onclick="mostrarPaso('4'); return false;" class="Cuatro"></a>
							<a href="#" onclick="mostrarPaso('5'); return false;" class="Cinco"></a>
						</div>
					<div class="Instrucciones">
						<div class="Paso">
						    <p>Verific&aacute; que los c&oacute;digos de salida para llamadas internacionales, nacionales y locales que se muestran a continuaci&oacute;n, son los que corresponden a tu pa&iacute;s de residencia. De ser incorrectos, ingresalos en el casillero de al lado.</p>
						    <p>
							<span id="Pais_SELECT"><!--{$dialplan.Denom_Pais}--></span>
							</p>
						    <div style="width:170px;">
						        <ul>
						            <li>&bull; C&oacute;digo de salida internacional:</li>
						            <li>&bull; C&oacute;digo de salida nacional:</li>
						            <li>&bull; C&oacute;digo de salida local: </li>
						        </ul>
						    </div>
						    <div style="width:190px;">
						        <ul>
						            <li><input name="Codigo_Escape_Int" id="Codigo_Escape_Int" type="text" value="<!--{$dialplan.Codigo_Escape_Int}-->" /></li>
						            <li><input name="Codigo_Escape_Nac" id="Codigo_Escape_Nac" type="text" value="<!--{$dialplan.Codigo_Escape_Nac}-->" /></li>
						            <li><input name="Codigo_Escape_Loc" id="Codigo_Escape_Loc" type="text" value="<!--{$dialplan.Codigo_Escape_Loc}-->" /></li>
						        </ul>
						    </div>
						    <div style="text-align:center; width:100%; margin-top:35px;">
						        <a href="#" title="Enviar" onclick="mostrarPaso('confirmar'); return false;"><img src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="Enviar" /></a>
						        
								<input type="hidden" name="print" id="print" value="0" />
						    </div>
						</div>
					</div>
				</div>		
			
	
						</div>
					</td>
			   </tr>
			</table>
			</form>
		
		
		
		
			
			
			
			
		</td></tr>
		<!--{/if}-->
		
</table>

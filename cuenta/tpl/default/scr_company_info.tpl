<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr style="height: 25px;">
        <td class="scr_header">
        <font class="scr_header"><!--{$strPath}--></font>
        </td>
    </tr>
	
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr>
            <td style="padding-top: 10px;">
			
			<!--{if !$restrict_owner_hola}-->
            <b><!--{lang k=MD_MODIFICAR_DATOS}--></b><br /><br />
        
            <p><!--{lang k=MD_HAGA_CLIC}--></p>
			<!--{/if}-->
			
			<!--{if $msg}-->
				<p class="form_ok"><!--{lang k=MD_FORMULARIO_EXITO}--></p>
			<!--{/if}-->
				
			<!--{if !$restrict_owner_hola}-->	
            <div id="acordion">
					<div style="display:inline;">
						<h3><a href="#" onclick="return false"><!--{lang k=MD_CAMBIO_RS}--></a></h3>
						<div class="bloque-acordion">
							<!--{if true}-->
							<p><!--{lang k=MD_RS_COMPLETE}--></p>
							<form action="" id="razonsocial_form" method="post">
								<div class="margin-top"><label><!--{lang k=MD_RAZON_SOCIAL}-->:</label>
								<input type="text" class="txt required" name="rs_rs" id="rs_razonsocial" /></div> 
								<div class="margin-top"><label><!--{lang k=MD_DOMICILIO}-->:</label>
								<input type="text" class="txt required" name="rs_domicilio" id="rs_domicilio" /></div>
								<div class="margin-top"><label><!--{lang k=MD_COD_POSTAL}-->:</label>
								<input type="text" class="txt required" name="rs_postal" id="rs_codigopostal" /></div>
								<div class="margin-top"><label><!--{lang k=MD_TITULAR}-->:</label>
								<input type="text" class="txt required" name="rs_titular" id="rs_titular" /></div>
								<div class="margin-top"><label><!--{lang k=MD_TELEFONO}-->:</label>
								<input type="text" class="txt required" name="rs_telefono" id="rs_telefono" /></div>
								<div class="margin-top"><label><!--{lang k=MD_EMAIL}-->:</label>
								<input type="text" class="txt required email" name="rs_email" id="rs_email" /></div>
								<div class="margin-top"><label><!--{lang k=MD_CUITLDNI}-->:</label>
								<input type="text" class="txt required" name="rs_cuit" id="rs_cuit" /></div>
								<div class="margin-top"><label><!--{lang k=MD_IVA}-->:</label>
								<input type="text" class="txt required" name="rs_iva" id="rs_iva" /></div>
								<div class="margin-top"><span class="label"><!--{lang k=MD_CONSERVA_MP}--></span>
								<span><!--{lang k=MD_SI}--></span><input type="radio" class="check" name="rs_mediopago" checked="checked" value="si" />
								<span><!--{lang k=MD_NO}--></span><input type="radio" class="check" name="rs_mediopago" value="no" /></div>
								<p class="margin-top"><!--{lang k=MD_NO_CONSERVA}--></p>
								<div class="margin-top right">
								<input type="image" for="razonsocial_form" name="submit_razonsocial" value="submit" src="<!--{ipath name="bt-aceptar.gif" owner="1" lang="1"}-->" />
								<a href="company_info.ca">
								<img src="<!--{ipath name="bt-cancelar.gif" owner="1" lang="1"}-->"/>
								</a>
								</div>
							</form>
							<!--{/if}-->
							<!--{if false}-->
							<p class="form_ok"><!--{lang k=MD_FORMULARIO_EXITO}--></p>
							<!--{/if}-->
						</div>
					</div>
					
					<div style="display:inline;">
						<h3><a href="#" onclick="return false"><!--{lang k=MD_CAMBIO_DF}--></a></h3>
						<div class="bloque-acordion">
							<!--{if true}-->
							<p><!--{lang k=MD_DF_COMPLETE}--><br /></p>
							<form action="" id="datosfacturacion_form" method="post">
								<input type="hidden" name="form_submit" value="df" />
								<div class="margin-top"><label><!--{lang k=MD_CALLE}-->:</label>
								<input type="text" class="txt required" name="df_calle" id="df_calle" /></div>
								
								<div class="margin-top"><label><!--{lang k=MD_NUMERO}-->:</label>
								<input type="text" class="txt required" name="df_numero" id="df_numero" /></div>
								
								<div class="margin-top"><label><!--{lang k=MD_PISO}-->:</label>
								<input type="text" class="txt" name="df_piso" id="df_piso" /></div>
								
								<div class="margin-top"><label><!--{lang k=MD_DEPARTAMENTO}-->:</label>
								<input type="text" class="txt" name="df_dpto" id="df_dpto" /></div>
								
								<div class="margin-top"><label><!--{lang k=MD_CIUDAD}-->:</label>
								<input type="text" class="txt required" name="df_ciudad" id="df_ciudad" /></div>
								
								<div class="margin-top"><label><!--{lang k=MD_LOCALIDAD}-->:</label>
								<input type="text" class="txt required" name="df_localidad" id="rs_email" /></div>
								
								<div class="margin-top"><label><!--{lang k=MD_COD_POSTAL}-->:</label>
								<input type="text" class="txt required" name="df_postal" id="df_codigopostal" /></div>
								
								<div class="margin-top"><label><!--{lang k=MD_PROVINCIA}-->:</label>
								<input type="text" class="txt required" name="df_provincia" id="df_provincia" /></div>
					
								<div class="margin-top right">
								<input type="image" for="datosfacturacion_form" name="submit_datosfacturacion" value="submit" src="<!--{ipath name="bt-aceptar.gif" owner="1" lang="1"}-->" />
								<a href="company_info.ca">
								<img src="<!--{ipath name="bt-cancelar.gif" owner="1" lang="1"}-->"/>
								</a>
								</div>
							</form>
							<!--{/if}-->
							<!--{if false}-->
							<p class="form_ok"><!--{lang k=MD_FORMULARIO_EXITO}--></p>
							<!--{/if}-->
						</div>
					</div>
					
					<!--{if $smarty.session.empresa == 2}-->
					
						
						<div style="display:inline;">
						<h3><a href="#" onclick="return false"><!--{lang k=MD_CAMBIO_MP}--></a></h3>
						<div class="bloque-acordion">
							<!--{if true}-->
							<p><!--{lang k=MD_COMPLETE_MP}--></p>
							<form action="" id="mediopago_form" method="post" onsubmit="return false">
								<input type="hidden" name="form_submit" value="mp_paypage" />
								
								<input type="hidden" id="request$paypageId" name="request$paypageId" value="uwbdMcWPsZHaXE9T"/>
								<input type="hidden" id="request$merchantTxnId" name="request$merchantTxnId" value="987012"/>
								<input type="hidden" id="request$orderId" name="request$orderId" value="order_123"/>
								<input type="hidden" id="request$reportGroup" name="request$reportGroup" value="*merchant1500"/>


								<p><strong class="border-bottom"><!--{lang k=MD_DEBITO_CREDITO}--></strong></p>
								
								
							
								<div class="margin-top"><label>Nombre:</label>
								<input type="text" class="txt" name="fName" id="fName" /></div>
								
								<div class="margin-top"><label>Apellido:</label>
								<input type="text" class="txt" name="lName" id="lName" /></div>
								
								<div class="margin-top"><label>Credit Card:</label>
								<input type="text" class="txt" name="ccNum" id="ccNum" /></div>
								
								<div class="margin-top"><label>CVV:</label>
								<input type="text" class="txt" name="cvv2num" id="cvv2num" /></div>
								
								<div class="margin-top"><label>Vencimiento: (MM/AA)</label>
								<input type="text" class="txt" name="expDate" id="expDate" /></div>
								
								<input type="hidden" id="response$paypageRegistrationId" name="response$paypageRegistrationId" readOnly="true" value=""/>
								<input type="hidden" id="response$bin" name="response$bin" readOnly="true"/>
								<input type="hidden" id="response$code" name="response$code" readOnly="true"/>
								<input type="hidden" id="response$message" name="response$message" readOnly="true"/>
								<input type="hidden" id="response$responseTime" name="response$responseTime" readOnly="true"/>
								<input type="hidden" id="response$type" name="response$type" readOnly="true"/>
								<input type="hidden" id="response$litleTxnId" name="response$litleTxnId" readOnly="true"/>

								<input type="image" for="mediopago_form" name="submitId" id="submitId" value="submit" src="<!--{ipath name="bt-aceptar.gif" owner="1" lang="1"}-->"  />

							</form>	
							<!--{/if}-->		
						</div>	
					</div>
						
						
						
						
						
						
					<!--{else}-->
					<div style="display:inline;">
						<h3><a href="#" onclick="return false"><!--{lang k=MD_CAMBIO_MP}--></a></h3>
						<div class="bloque-acordion">
							<!--{if true}-->
							<p><!--{lang k=MD_COMPLETE_MP}--></p>
							
							<form action="" id="mediopago_form" method="post">
								<input type="hidden" name="form_submit" value="mp" />
								<p><strong class="border-bottom"><!--{lang k=MD_DEBITO_CREDITO}--></strong></p>
								
								<div class="margin-top">
								<label><!--{lang k=MD_TIPO_CREDITO}-->:</label>
								<span>Visa</span>
								<input type="radio" class="check required mp_tipo" name="mp_tipo" id="mp_tarjeta_visa" value="visa" />
								<span>Amex</span>
								<input type="radio" class="check mp_tipo" name="mp_tipo" id="mp_tarjeta_amex" value="amex" />
								<span>MasterCard</span>
								<input type="radio" class="check mp_tipo" name="mp_tipo" id="mp_tarjeta_master" value="master" />
								</div>
								
								<div class="margin-top"><label><!--{lang k=MD_NOMBRE_TITULAR}-->:</label>
								<input type="text" class="txt" name="mp_titular" id="mp_titular" /></div>
								
								<div class="margin-top"><label><!--{lang k=MD_NRO_TARJETA}-->:</label>
								<input type="text" class="txt" name="mp_numero" id="mp_numero" /></div>
								
								<div class="margin-top"><label><!--{lang k=MD_FECHA_VEN}-->:</label>
								<select name="tarjeta_vencimiento_mes" id="tarjeta_vencimiento_mes" onchange="armaVencimientoTarjeta()">
								<option value=""><label><!--{lang k=MD_MES}--></option>
								<!--{section name=m loop=12}-->
									<option value="<!--{if $smarty.section.m.iteration<10}-->0<!--{/if}--><!--{$smarty.section.m.iteration}-->"><!--{$smarty.section.m.iteration}--></option>
								<!--{/section}-->
								</select>
								<select name="tarjeta_vencimiento_ano" id="tarjeta_vencimiento_ano" onchange="armaVencimientoTarjeta()">
								<option value=""><label><!--{lang k=MD_ANIO}--></option>
									<!--{assign var=anio_actual value=$smarty.now|date_format:"%y"}-->
									<!--{section name=a loop=$anio_actual+11 start=$anio_actual }-->
										<option value="<!--{if $smarty.section.a.index<10}-->0<!--{/if}--><!--{$smarty.section.a.index}-->"><!--{$smarty.section.a.index}--></option>
									<!--{/section}-->
								</select>
								<input type="hidden" class="txt" name="mp_vencimiento" id="mp_vencimiento" /></div>
								
								<!--  direccion -->
								<div class="margin-top" style="padding-top: 10px"><label>&nbsp;</label>
								Complete aquí el domicilio registrado en su banco
								</div>
							
								
								<div class="margin-top"><label>Calle:</label>
								<input type="text" class="txt required" name="mp_calle" id="mp_calle"  /></div>
								
								<div class="margin-top"><label>N&uacute;mero:</label>
								<input type="text" class="txt" name="mp_numero" id="mp_numero" /></div>
								
								<div class="margin-top"><label>Piso:</label>
								<input type="text" class="txt" name="mp_piso" id="mp_piso" /></div>
								
								<div class="margin-top"><label>Departamento:</label>
								<input type="text" class="txt" name="mp_departamento" id="mp_departamento" /></div>
								
								<div class="margin-top"><label>Ciudad/Localidad:</label>
								<input type="text" class="txt required" name="mp_ciudad" id="mp_ciudad" /></div>
								
								
								<div class="margin-top"><label>Codigo postal:</label>
								<input type="text" class="txt required" name="mp_codigo_postal" id="mp_codigo_postal" /></div>
								
								<div class="margin-top"><label>Provincia:</label>
								<input type="text" class="txt" name="mp_provincia" id="mp_provincia" /></div>
								
								<div class="margin-top"><label>Pais:</label>
								<select name="mp_pais" id="mp_pais" class="required" style="width: 220px">
									<option value="">-- seleccione un pais --</option>
									<!--{foreach from=$select_paises item=pais}-->
									<option value="<!--{$pais.codigo}-->"><!--{$pais.nombrePais}--></option>								
									<!--{/foreach}-->
								</select>
								</div>
								
								
								<p class="margin-top"><strong class="border-bottom"><!--{lang k=MD_DEBITO_CORRIENTE}--></strong></p>
								
								<div class="margin-top"><label><!--{lang k=MD_TIPO_CUENTA}-->:</label>
								<span><!--{lang k=MD_CUENTA_CORRIENTE}--></span>
								<input type="radio" class="check required mp_tipo" name="mp_tipo" id="mp_cuenta_corriente" value="cc" />
								<span><!--{lang k=MD_CAJA_AHORRO}--></span>
								<input type="radio" class="check mp_tipo" name="mp_tipo" id="mp_cuenta_ahorro" value="caja" />
								</div>
								
								<div class="margin-top"><label><!--{lang k=MD_NOMBRE_TITULAR}-->:</label>
								<input type="text" class="txt" name="mp_titular_da" id="mp_titular_da" /></div>
								
								<div class="margin-top"><label><!--{lang k=MD_NRO_CUENTA}-->:</label>
								<input type="text" class="txt" name="mp_cuenta_da" id="mp_cuenta_da" /></div>
								
								<div class="margin-top"><label><!--{lang k=MD_CBU}-->:</label>
								<input type="text" class="txt" name="mp_cbu_false" id="mp_cbu" /></div>
														  
								<div style="float:left;margin-left:260px;display:inline;padding-top:5px;text-align:left;width:300px;">Ingrese el CBU en el siguiente formato: <br />xxxxxxxx-xxxxxxxxxxxxxx (8dig, gui&oacute;n,14dig)</div>
								
								<div class="margin-top"><label><!--{lang k=MD_BANCO}-->:</label>
								<input type="text" class="txt" name="mp_banco" id="mp_banco" /></div>
								
								<div class="margin-top"><label><!--{lang k=MD_SUCURSAL}-->:</label>
								<input type="text" class="txt" name="mp_sucursal" id="mp_sucursal" /></div>
								
								<div class="margin-top">
								<input type="checkbox" class="checkbox required" checked="checked" name="mp_condiciones" id="mp_condiciones" />
								<em><!--{lang k=MD_ACEPTO_DEBITO}--></em>
								</div>
								
								<div class="margin-top right">
								<input type="image" for="mediopago_form" name="submit_mediopago" value="submit" src="<!--{ipath name="bt-aceptar.gif" owner="1" lang="1"}-->" />
							   <a href="company_info.ca">
								<img src="<!--{ipath name="bt-cancelar.gif" owner="1" lang="1"}-->"/>
								</a>
								</div>
							</form>	
							<!--{/if}-->		
						</div>	
					</div>
            </div>
			<!--{/if}-->
			
			<!--{else}-->
			<!--{if !$msg}-->
			<div class="bloque">
				<!--{if true}-->
				<p><!--{lang k=MD_COMPLETE_MP}--></p>
				
				<form action="" id="mediopago_form" method="post" onsubmit="return false">
								<input type="hidden" name="form_submit" value="mp_paypage" />
								
								<input type="hidden" id="request$paypageId" name="request$paypageId" value="uwbdMcWPsZHaXE9T"/>
								<input type="hidden" id="request$merchantTxnId" name="request$merchantTxnId" value="merch_<!--{$smarty.now}-->"/>
								<input type="hidden" id="request$orderId" name="request$orderId" value="order_<!--{$smarty.now}-->"/>
								<input type="hidden" id="request$reportGroup" name="request$reportGroup" value="*merchant1500"/>


								<p><strong class="border-bottom"><!--{lang k=MD_DEBITO_CREDITO}--></strong></p>
								
								
							
								<div class="margin-top"><label>Nombre:</label>
								<input type="text" class="txt" name="fName" id="fName" /></div>
								
								<div class="margin-top"><label>Apellido:</label>
								<input type="text" class="txt" name="lName" id="lName" /></div>
								
								<div class="margin-top"><label>Credit Card:</label>
								<input type="text" class="txt" name="ccNum" id="ccNum" /></div>
								
								<div class="margin-top"><label>CVV:</label>
								<input type="text" class="txt" name="cvv2num" id="cvv2num" /></div>
								
								<div class="margin-top"><label>Vencimiento: (MM/AA)</label>
								<input type="text" class="txt" name="expDate" id="expDate" /></div>
								
								<input type="hidden" id="response$paypageRegistrationId" name="response$paypageRegistrationId" readOnly="true" value=""/>
								<input type="hidden" id="response$bin" name="response$bin" readOnly="true"/>
								<input type="hidden" id="response$code" name="response$code" readOnly="true"/>
								<input type="hidden" id="response$message" name="response$message" readOnly="true"/>
								<input type="hidden" id="response$responseTime" name="response$responseTime" readOnly="true"/>
								<input type="hidden" id="response$type" name="response$type" readOnly="true"/>
								<input type="hidden" id="response$litleTxnId" name="response$litleTxnId" readOnly="true"/>




								
								
								<div class="margin-top" style="padding-top: 10px"><label>&nbsp;</label>
								Complete aqu&iacute; el domicilio registrado en su banco
								</div>
							
								
								<div class="margin-top"><label>Calle:</label>
								<input type="text" class="txt required" name="mp_calle" id="mp_calle"  /></div>
								
								<div class="margin-top"><label>N&uacute;mero:</label>
								<input type="text" class="txt" name="mp_numero" id="mp_numero" /></div>
								
								<div class="margin-top"><label>Piso:</label>
								<input type="text" class="txt" name="mp_piso" id="mp_piso" /></div>
								
								<div class="margin-top"><label>Departamento:</label>
								<input type="text" class="txt" name="mp_departamento" id="mp_departamento" /></div>
								
								<div class="margin-top"><label>Ciudad/Localidad:</label>
								<input type="text" class="txt required" name="mp_ciudad" id="mp_ciudad"  /></div>
								
								
								<div class="margin-top"><label>Codigo postal:</label>
								<input type="text" class="txt required" name="mp_codigo_postal" id="mp_codigo_postal" /></div>
								
								<div class="margin-top"><label>Provincia:</label>
								<input type="text" class="txt" name="mp_provincia" id="mp_provincia" /></div>
								
								<div class="margin-top"><label>Pais:</label>
								<select name="mp_pais" id="mp_pais" class="required" style="width: 220px">
									<option value="">-- seleccione un pais --</option>
									<!--{foreach from=$select_paises item=pais}-->
									<option value="<!--{$pais.codigo}-->"><!--{$pais.nombrePais}--></option>								
									<!--{/foreach}-->
								</select>
								</div>
								
								<input type="image" for="mediopago_form" name="submitId" id="submitId" value="submit" src="<!--{ipath name="bt-aceptar.gif" owner="1" lang="1"}-->"  />

							</form>	
				
				<!--{* FORMULARIO ANTERIOR
				<form action="" id="mediopago_form" method="post">
					<input type="hidden" name="form_submit" value="mp" />
					<p><strong class="border-bottom"><!--{lang k=MD_DEBITO_CREDITO}--></strong></p>
					
					<div class="margin-top">
					<label><!--{lang k=MD_TIPO_CREDITO}-->:</label>
					<span>Visa</span>
					<input type="radio" class="check required mp_tipo" name="mp_tipo" id="mp_tarjeta_visa" value="visa" />
					<span>Amex</span>
					<input type="radio" class="check mp_tipo" name="mp_tipo" id="mp_tarjeta_amex" value="amex" />
					<span>MasterCard</span>
					<input type="radio" class="check mp_tipo" name="mp_tipo" id="mp_tarjeta_master" value="master" />
					</div>
					
					<div class="margin-top"><label><!--{lang k=MD_NOMBRE_TITULAR}-->:</label>
					<input type="text" class="txt" name="mp_titular" id="mp_titular" /></div>
					
					<div class="margin-top"><label><!--{lang k=MD_NRO_TARJETA}-->:</label>
					<input type="text" class="txt" name="mp_numero" id="mp_numero" /></div>
					
					<div class="margin-top"><label><!--{lang k=MD_FECHA_VEN}-->:</label>
					<select name="tarjeta_vencimiento_mes" id="tarjeta_vencimiento_mes" onchange="armaVencimientoTarjeta()">
					<option value=""><!--{lang k=MD_MES}--></option>
					<!--{section name=m loop=12}-->
						<option value="<!--{if $smarty.section.m.iteration<10}-->0<!--{/if}--><!--{$smarty.section.m.iteration}-->"><!--{$smarty.section.m.iteration}--></option>
					<!--{/section}-->
					</select>
					<select name="tarjeta_vencimiento_ano" id="tarjeta_vencimiento_ano" onchange="armaVencimientoTarjeta()">
					<option value=""><!--{lang k=MD_ANIO}--></option>
						<!--{assign var=anio_actual value=$smarty.now|date_format:"%y"}-->
						<!--{section name=a loop=$anio_actual+11 start=$anio_actual }-->
							<option value="<!--{if $smarty.section.a.index<10}-->0<!--{/if}--><!--{$smarty.section.a.index}-->"><!--{$smarty.section.a.index}--></option>
						<!--{/section}-->
					</select>
					
					
					
					
					<!--  direccion -->
								<div class="margin-top" style="padding-top: 10px"><label>&nbsp;</label>
								Complete aquí el domicilio registrado en su banco
								</div>
							
								
								<div class="margin-top"><label>Calle:</label>
								<input type="text" class="txt required" name="mp_calle" id="mp_calle"  /></div>
								
								<div class="margin-top"><label>N&uacute;mero:</label>
								<input type="text" class="txt" name="mp_numero" id="mp_numero" /></div>
								
								<div class="margin-top"><label>Piso:</label>
								<input type="text" class="txt" name="mp_piso" id="mp_piso" /></div>
								
								<div class="margin-top"><label>Departamento:</label>
								<input type="text" class="txt" name="mp_departamento" id="mp_departamento" /></div>
								
								<div class="margin-top"><label>Ciudad/Localidad:</label>
								<input type="text" class="txt required" name="mp_ciudad" id="mp_ciudad"  /></div>
								
								
								<div class="margin-top"><label>Codigo postal:</label>
								<input type="text" class="txt required" name="mp_codigo_postal" id="mp_codigo_postal" /></div>
								
								<div class="margin-top"><label>Provincia:</label>
								<input type="text" class="txt" name="mp_provincia" id="mp_provincia" /></div>
								
								<div class="margin-top"><label>Pais:</label>
								<select name="mp_pais" id="mp_pais" class="required" style="width: 220px">
									<option value="">-- seleccione un pais --</option>
									<!--{foreach from=$select_paises item=pais}-->
									<option value="<!--{$pais.codigo}-->"><!--{$pais.nombrePais}--></option>								
									<!--{/foreach}-->
								</select>
								</div>
					
					
					
					
					<div class="margin-top right">
					<input type="image" for="mediopago_form" name="submit_mediopago" value="submit" src="<!--{ipath name="bt-aceptar.gif" owner="1" lang="1"}-->" />
				   <a href="company_info.ca">
					<img src="<!--{ipath name="bt-cancelar.gif" owner="1" lang="1"}-->"/>
					</a>
					</div>
				</form>	
				*}-->
				<!--{/if}-->		
			</div>
			<!--{/if}-->		
			<!--{/if}-->
			
    		</td>
    	</tr>
    </table>
</table>

<div style="text-align: center; padding-top: 15px;">
<a href="home.ca">
<img src="<!--{ipath name="Volver.jpg" owner="1" lang="1"}-->"/>
</a>
</div>


<!--{if $smarty.session.empresa == 2 or true}-->
<!--{* <script src="https://request.cert01-securepaypage-litle.com/LitlePayPage/litle-api.js" type="text/javascript"></script> *}-->

<!--{* <script src="https://cert01.securepaypage.litle.com/LitlePayPage/litle-api.js" type="text/javascript"></script> *}-->
<!--{*<script src="https://request.cert01-securepaypage-litle.com/LitlePayPage/litle-api2.js" type="text/javascript"></script>*}-->

<script src="https://request.securepaypage-litle.com/LitlePayPage/litle-api2.js" type="text/javascript"></script>

<script>

$(document).ready(
function(){
function setLitleResponseFields(response) {
document.getElementById('response$code').value = response.response;
document.getElementById('response$message').value = response.message;
document.getElementById('response$responseTime').value = response.responseTime;
document.getElementById('response$litleTxnId').value = response.litleTxnId;
document.getElementById('response$type').value = response.type;
}
function submitAfterLitle (response) {
setLitleResponseFields(response);
document.forms['mediopago_form'].submit();
}
function timeoutOnLitle () { 
alert("We are experiencing technical difficulties. Please try again later or call 555-555-1212 (timeout)");
}
function onErrorAfterLitle (response) {

setLitleResponseFields(response);
if(response.response == '871') {
alert("N\u00famero de tarjeta inv\u00e1 lido. Por favor verifique, e intente nuevamente (error 871)");
}
else if(response.response == '872') {
alert("N\u00famero de tarjeta incompleto. Por favor verifique, e intente nuevamente (error 872)");
}
else if(response.response == '873') {
alert("N\u00famero de tarjeta inv\u00e1 lido. Por favor verifique, e intente nuevamente (error 873)");
}
else if(response.response == '874') {
alert("N\u00famero de tarjeta inv\u00e1 lido. Por favor verifique, e intente nuevamente (error 874)");
} 
else if(response.response == '875') {
alert("En este momento no es posible realizar esta transacci\u00f3n. Por favor, intente m\u00e1 s tarde (error 875)");
}
else if(response.response == '876') {
alert("En este momento no es posible realizar esta transacci\u00f3n. Por favor, intente m\u00e1 s tarde (error 876)");
}
else if(response.response == '881') {
alert("C\u00f3digo de verificaci\u00f3n incompleto. Por favor verifique, e intente nuevamente (error 881)");
}
else if(response.response == '882') {
alert("C\u00f3digo de verificaci\u00f3n incompleto. Por favor verifique, e intente nuevamente (error 882)");
}

else if(response.response == '883') {
alert("El c\u00f3digo de verificaci\u00f3n es incorrecto. Por favor verifique, e intente nuevamente (error 883)");
}
else if(response.response == '889') {
alert("En este momento no es posible realizar esta transacci\u00f3n. Por favor, intente m\u00e1 s tarde (error 889)");
}
return false;
}
var formFields = {
"accountNum" :document.getElementById('ccNum'), 
"cvv2" :document.getElementById('cvv2num'),
"paypageRegistrationId":document.getElementById('response$paypageRegistrationId'),
"bin" :document.getElementById('response$bin') 
};
$("#submitId").click(
function(){
// clear test fields
setLitleResponseFields({"response":"", "message":""});

var litleRequest = {
"paypageId" : document.getElementById("request$paypageId").value,
"reportGroup" : document.getElementById("request$reportGroup").value,
"orderId" : document.getElementById("request$orderId").value,
"id" : document.getElementById("request$merchantTxnId").value,
<!--{* "url" : "https://request.cert01-securepaypage-litle.com" *}-->
"url" : "https://request.securepaypage-litle.com"
};
new LitlePayPage().sendToLitle(litleRequest, formFields, submitAfterLitle,
onErrorAfterLitle, timeoutOnLitle, 5000);
return false;
}
);
}
);
</script>

<!--{/if}-->





<script type="text/javascript" charset="ISO-8859-1">
// validate signup form on keyup and submit
	$("#mediopago_form").validate({
		errorClass: "error",
		rules: {
			mp_numero_visa: {"creditcardtypes": {"visa":true} },
			mp_numero_master: {"creditcardtypes": {"mastercard":true} },
			mp_numero_amex: {"creditcardtypes": {"amex":true} },
			mp_cbu: {required: true, rangelength: [23,23]}
		},
		messages: {
			mp_numero_visa: "No es una tarjeta VISA.<br /> Recuerde no ingresar espacios.",
			mp_numero_master: "No es una tarjeta MasterCard.<br /> Recuerde no ingresar espacios.",
			mp_numero_amex: "No es una tarjeta American Express.<br /> Recuerde no ingresar espacios.",
			mp_cbu: {required: "Ingrese el CBU", rangelength: "CBU incorrecto"}
		},
		errorPlacement: function(error, element) {
			error.insertAfter(element);
		}
	});
	
	function armaVencimientoTarjeta(){
		if($('#mp_vencimiento_mes').val()!=''&&$('#mp_vencimiento_ano').val()!=''){
			$('#mp_vencimiento').val($('#mp_vencimiento_mes').val()+$('#mp_vencimiento_ano').val());
		}
	}
$().ready(function() {

	
	
	
	$('.mp_tipo').click(function(element){
		var mp_tipo = this.value;
		
		if(mp_tipo=='visa'||mp_tipo=='amex'||mp_tipo=='master'){
			$('#mp_titular').addClass('required');
			$('#mp_numero').attr('name','mp_numero_'+mp_tipo);
			$('#mp_vencimiento').attr('class','required');
			
			$('#mp_titular_da').removeClass('required');
			$('#mp_cbu').attr('name','mp_cbu_false');
			$('#mp_banco').removeClass('required');
			$('#mp_sucursal').removeClass('required');
			
			$('#mp_pais').addClass('required');
			
			
			$('#mp_calle').addClass('required');
			$('#mp_ciudad').addClass('required');
			$('#mp_codigo_postal').addClass('required');
			
			
		}else if(mp_tipo=='cc'||mp_tipo=='caja'){
			$('#mp_titular').removeClass('required');
			$('#mp_numero').attr('name','mp_numero');
			$('#mp_vencimiento').removeClass('required');
			
			$('#mp_calle').removeClass('required');
			$('#mp_ciudad').removeClass('required');
			$('#mp_codigo_postal').removeClass('required');
			
			
			
			$('#mp_titular_da').addClass('required');
			$('#mp_cbu').attr('name','mp_cbu');
			$('#mp_banco').addClass('required');
			$('#mp_sucursal').addClass('required');
			
			$('#mp_pais').removeClass('required');
		}
	});
	
	
	
	
});

</script>

<!--{if $smarty.session.ownerId == 1 ||  $smarty.session.ownerId == 7}-->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2669879-18']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<!--{/if}-->

<!--{if $smarty.session.ownerId == 4 ||  $smarty.session.ownerId == 5}-->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2669879-20']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<!--{/if}-->

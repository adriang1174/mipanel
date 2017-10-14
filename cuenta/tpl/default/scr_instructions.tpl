<script type="text/javascript">
paises = new Array();
<!--{foreach from=$paises_acceso item=pais }-->
paises["<!--{$pais}-->"] = new Array();
<!--{/foreach}-->
<!--{foreach from=$numeros_acceso item=numero }-->
paises["<!--{$numero.nombre}-->"].push(new Array("<!--{$numero.nroAccTLLInternacional}-->", "<!--{$numero.cargoAcceso}-->", "<!--{$numero.codigoAcceso}-->"));
<!--{/foreach}-->
function showAccTLL(val){
	document.getElementById('cont_numero').innerHTML = '';
	document.getElementById('cont_cargo').innerHTML = '';
	document.getElementById('cont_codigo').innerHTML = '';
	if(paises[val].length > 0){
		for(var i=0; i< paises[val].length; i++) {
            document.getElementById('cont_numero').innerHTML += paises[val][i][0] +"<br>";
			document.getElementById('cont_cargo').innerHTML += paises[val][i][1]+"<br>";
			document.getElementById('cont_codigo').innerHTML += paises[val][i][2]+"<br>";
        }
	}
}

</script>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
                
        <!--{if $show_select}-->
		<tr><td>
			<form name="frmLine" id="frmLine" method="get" action="">
			<table>
			<tr>
				<td>Seleccione un producto &nbsp;&nbsp;</td>
				<td>
				<select name="producto">
					<!--{foreach name="productos" from=$productos item="producto"}-->
					<option value="<!--{$producto.id}-->"><!--{$producto.nombre}--></option>
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
		
		
		<!--{if $producto == 'plateada'}-->
        	<tr><td>
            	<font class="scr_header"><!--{lang k=PLATEADA_TITLE}--></font>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td style="width:480px; padding-left:30px; padding-top:42px">
                    	<!--{lang k=PLATEADA_INSTRUCTIONS}-->
                        <p style="margin-top:30px; margin-bottom:10px"><b class="ticket_row_title">Números de acceso:</b></p>
                        <select name="pais" class="input_pais" style="width:170px; font-size:12px" onchange="showAccTLL(this.value)">
                        	<option value="">- seleccione un pa&iacute;s -</option>
                        	<!--{foreach from=$paises_acceso item=pais }-->
                        		<option value="<!--{$pais}-->"><!--{$pais}--></option>
                        	<!--{/foreach}-->
                        </select>
                         <div style="border:1px solid #000; padding:10px; margin-top:14px; width:92%">
                    	<table style="width:100%">
                        	<tr>
                            	<th style="text-align:center">Nro. de acceso internacional</th>
                                <th style="text-align:center">Cargo de acceso</th>
                                <th style="text-align:center">Código</th>
                            </tr>
                            <tr>
                            	<td style="text-align:center" id="cont_numero"></td>
                                <td style="text-align:center" id="cont_cargo"></td>
                                <td style="text-align:center" id="cont_codigo"></td>
                            </tr>
                        </table>
                    </div>
                     </td>
                    <td style="vertical-align:top; padding-top:42px; width:195px">
                    	<img src="<!--{ipath name="instructions/tarjeta-plateada.jpg" lang="0" owner="0"}-->" alt="Tarjeta Plateada" />
                        <table width="195" border="0" cellspacing="0" cellpadding="0" style="background-color:#17b5e5; width:195px">
                          <tr>
                            <td><img src="<!--{ipath name="instructions/blue_box_top.jpg" lang="0" owner="0"}-->" alt="Tarjeta Plateada" /></td>
                          </tr>
                          <tr>
                            <td style="color:#FFF; line-height:20px; padding:0 12px"><b>Importante:</b> La <b>Tarjeta Plateada</b> no ofrece descuentos para llamadas a números locales. Si la utilizas para destinos locales, deberás sumar al costo del pulso telefónico, el cargo del número de acceso.</td>
                          </tr>
                          <tr>
                            <td><img src="<!--{ipath name="instructions/blue_box_bottom.jpg" lang="0" owner="0"}-->" alt="Tarjeta Plateada" /></td>
                          </tr>
						</table>
                    </td>
                  </tr>
				</table>
            </td></tr>
		<!--{/if}-->
		
</table>

<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr style="height: 25px;"><td style="cursor: default;" class="scr_header_popup"><!--{$TITLE}--></td></tr>
<tr style="height: 5px; cursor: default;"><td>&nbsp;</td></tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="95%">
	<tr><td colspan="4" align="left" style="padding: 5px;"><!--{$MESSAGE}--></td></tr>
	<tr><td colspan="4" align="center">&nbsp;</td></tr>
    <script type="text/javascript">
	function IsNumeric(sText){
		   var ValidChars = "0123456789.";
		   var IsNumber=true;
		   var Char;
		   for (i = 0; i < sText.length && IsNumber == true; i++) 
			  { 
			  Char = sText.charAt(i); 
			  if (ValidChars.indexOf(Char) == -1) 
				 {
				 IsNumber = false;
				 }
			  }
		   return IsNumber;
	   }
	</script>
	<!--{if $FUNCTION == "ofg2_internos_nuevoint"}-->
	<script type="text/javascript">
		function nuevoINTProcesar(interno, destino, referencia){
			var nro=/\d{6,15}/;	
			var nonro=/[^0-9]/;	
			if (IsNumeric(destino) && destino.length>6 && destino.length<15){
				if(opener.nuevoINT_procesar(interno, destino, referencia)){
					window.close();
					return;
				}else{
					document.getElementById("errormsg").innerHTML = "<!--{lang k=INT_MSG_ERROR_SELECTEDINT}-->";
				}
			}else{
				alert(destino.length);
				alert(IsNumeric(destino));
				document.getElementById("errormsg").innerHTML = "<!--{lang k=INT_MSG_ERROR}-->";
			}
		}
	</script>
		<tr>
			<td width="10">&nbsp;</td>
			<td><!--{lang k=NUMERO_INTERNO}--></td>
			<td><input type="text" id="interno" style="width: 30px;"/>&nbsp;&nbsp;</td>
			<td width="10">&nbsp;</td>
		</tr>
		<tr>
			<td width="10">&nbsp;</td>
			<td><!--{lang k=NUMERO_DERIVA}--></td>			
			<td><input type="text" id="destino"/>&nbsp;&nbsp;</td>
			<td width="10">&nbsp;</td>
		</tr>
		<tr>
			<td width="10">&nbsp;</td>
			<td><!--{lang k=REFERENCIA}--></td>			
			<td><input type="text" id="referencia"/>&nbsp;&nbsp;</td>
			<td width="10">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
		<tr>
		<td colspan="4" align="center"><input type="image" src="<!--{ipath name="bt-agregar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ADD}-->" onclick="nuevoINTProcesar(document.getElementById('interno').value, document.getElementById('destino').value, document.getElementById('referencia').value); return false;" /></td></tr>

		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
		
		<tr><td width="10">&nbsp;</td><td colspan="3" align="left"><!--{lang k=NUMERO_DERIVA_HELP}--></td></tr>
	<!--{elseif ($FUNCTION == "ofg2_avanzado_nuevoani")}-->
	<script type="text/javascript">
		function nuevoAni(newani){
			if (IsNumeric(newani) && newani.length>6 && newani.length<15){
				opener.document.getElementById('new_ani').value = newani;	
				opener.document.getElementById('frmNew').submit();
				window.close();
			}else{
				alert("El numero ingresado no es correcto");
			}
		}

	</script>	
		<tr>
			<td width="10">&nbsp;</td>
			<td width="100"><input type="text" id="nuevoAni"/>&nbsp;&nbsp;</td>
			<td width="150" align="left">
		<input type="image" src="<!--{ipath name="bt-agregar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ADD}-->" onclick="nuevoAni(document.getElementById('nuevoAni').value); return false;" />
		</td></tr>	
	<!--{elseif ($FUNCTION == "hafull_avanzado_nuevoani")}-->
	<script type="text/javascript">
		function nuevoAni(newani){
			if (IsNumeric(newani) && newani.length>6 && newani.length<15){
				opener.document.getElementById('new_ani').value = newani;	
				opener.document.getElementById('frmNew').submit();
				window.close();
			}else{
				alert("El numero ingresado no es correcto");
			}
		}
	</script>	
		<tr>
			<td width="10">&nbsp;</td>
			<td width="100"><input type="text" id="nuevoAni"/>&nbsp;&nbsp;</td>
			<td width="150" align="left">
		<input type="image" src="<!--{ipath name="bt-agregar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ADD}-->" onclick="nuevoAni(document.getElementById('nuevoAni').value); return false;" />
		</td></tr>	
        	
	<!--{elseif ($FUNCTION == "ofg2_grid_help")}-->
		<tr>
			<td width="10">&nbsp;</td>
			<td colspan="2"><!--{lang k=OFG_GRID_HELP_MSG}--></td>
			<td width="10">&nbsp;</td>
		</tr>
    <!--{elseif ($FUNCTION == "netfono_nuevoint")}-->
  	  <tr>
			<td width="10">&nbsp;</td>
			<td>Interno</td>
			<td>
            	<select name="listado_interno" id="listado_interno">
                		<option value="0">-- seleccionar interno --</option>
                	<!--{section name=loop loop=99}-->
					    <option value="<!--{$smarty.section.loop.iteration|string_format:"%02d"}-->"><!--{$line}--><!--{$smarty.section.loop.iteration|string_format:"%02d"}--></option>
					<!--{/section}-->
                </select>
            </td>
			<td width="10">&nbsp;</td>
		</tr>
		<tr>
			<td width="10">&nbsp;</td>
			<td>Voicemail</td>			
			<td><input type="text" id="voicemail" name="voicemail" />&nbsp;&nbsp;</td>
			<td width="10">&nbsp;</td>
		</tr>
		<tr>
			<td width="10">&nbsp;</td>
			<td>Mail comunicaciones</td>			
			<td><input type="text" id="mail_comunic" name="mail_comunic" />&nbsp;&nbsp;</td>
			<td width="10">&nbsp;</td>
		</tr>
        <tr>
			<td colspan="4" align="center">&nbsp;</td>
        </tr>
    	<tr>
			<td colspan="4" align="center">
		<input type="image" src="<!--{ipath name="bt-agregar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ADD}-->" onclick="nuevoInt()" />
		</td></tr>	
    <script type="text/javascript">
		function nuevoInt(){
			if(document.getElementById('listado_interno').value == 0){
				alert("Seleccionar un numero de interno");
			}else{
				opener.nuevoINT_procesar(document.getElementById('listado_interno').value, document.getElementById('voicemail').value, document.getElementById('mail_comunic').value);
				window.close();
			}
		}
	
		window.onload = new function(){
			for(i=0; i<document.getElementById('listado_interno').options.length; i++){
				for(h=0; h<opener.internos_en_uso.length; h++){
					if(document.getElementById('listado_interno').options[i].value == opener.internos_en_uso[h] ){
						document.getElementById('listado_interno').options[i].disabled = "disabled";
						document.getElementById('listado_interno').options[i].text += " (en uso)";
					}
				}
			}
		};
	</script>
	<!--{elseif $FUNCTION == "ofg3_internos_nuevoint"}-->
	<script type="text/javascript">
		function nuevoINTProcesar(interno, destino, referencia, webmail){
			var nro=/\d{6,15}/;	
			var nonro=/[^0-9]/;	
			if (IsNumeric(destino) && destino.length>6 && destino.length<15){
				if(opener.nuevoINT_procesar(interno, destino, referencia, webmail)){
					window.close();
					return;

				}else{
					document.getElementById("errormsg").innerHTML = "<!--{lang k=INT_MSG_ERROR_SELECTEDINT}-->";
				}
			}else{
				alert(destino.length);
				alert(IsNumeric(destino));
				document.getElementById("errormsg").innerHTML = "<!--{lang k=INT_MSG_ERROR}-->";
			}
		}
	</script>
		<tr>
			<td width="10">&nbsp;</td>
			<td><!--{lang k=NUMERO_INTERNO}--></td>
			<td><input type="text" id="interno" style="width: 30px;"/>&nbsp;&nbsp;</td>
			<td width="10">&nbsp;</td>
		</tr>
		<tr>
			<td width="10">&nbsp;</td>
			<td><!--{lang k=NUMERO_DERIVA}--></td>			
			<td><input type="text" id="destino"/>&nbsp;&nbsp;</td>
			<td width="10">&nbsp;</td>
		</tr>
		<tr>
			<td width="10">&nbsp;</td>
			<td><!--{lang k=SERV_OFFGLO_FLD1}--></td>			
			<td><input type="text" id="voicemail"/>&nbsp;&nbsp;</td>
			<td width="10">&nbsp;</td>
		</tr>
		<tr>
			<td width="10">&nbsp;</td>
			<td><!--{lang k=REFERENCIA}--></td>			
			<td><input type="text" id="referencia"/>&nbsp;&nbsp;</td>
			<td width="10">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
		<tr>
		<td colspan="4" align="center"><input type="image" src="<!--{ipath name="bt-agregar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ADD}-->" onclick="nuevoINTProcesar(document.getElementById('interno').value, document.getElementById('destino').value, document.getElementById('referencia').value, document.getElementById('voicemail').value); return false;" /></td></tr>

		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
		
		<tr><td width="10">&nbsp;</td><td colspan="3" align="left"><!--{lang k=NUMERO_DERIVA_HELP}--></td></tr>
	<!--{/if}-->    
	<tr><td colspan="3" style="height: 5px;">&nbsp;</td></tr>
	<tr><td colspan="3" align="center"><span id="errormsg" class="login_error">&nbsp;</span></td></tr>
</table>

<tr style="height: 30px;"><td class="scr_resalt2"><span style="cursor: pointer;" onclick="show_hide('action<!--{$action[3]}-->'); return false;">&nbsp;&nbsp;&nbsp;<img src="<!--{ipath name="arrow.gif"}-->" border="0">&nbsp;&nbsp;</span><a href="#" class="popup_link" onclick="show_hide('action<!--{$action[3]}-->'); return false;"><!--{$action[0]}--></a></td></tr>
		<tr><td>
		<div id="action<!--{$action[3]}-->" style="display: none">
<script type="text/javascript">
function deleteAni(newani){
	if(confirm("<!--{lang k=CONFIRM_DELETE_ANI}-->")){
		document.getElementById('anidelete').value = newani;
		document.getElementById('frmdelete').submit();
	}
}
function updateAni(newani, newstatus){
	document.getElementById('aniupdate').value = newani;
	document.getElementById('actionupdate').value = newstatus;	
	document.getElementById('frmupdate').submit();
}
function addAni(){
	var w = window.screen.width;	
	var h = window.screen.height;
	var popW = 350, popH = 150;
	var leftPos = (w-popW)/2, topPos = (h-popH)/2;
	window.open('conf_services_popup.ca?popup=1&accion=hafull_avanzado_nuevoani','popup','width=' + popW + ',height=' + popH + ',top=' + topPos + ',left=' + leftPos);
}
</script>

			  <form name="frmNew" id="frmNew" action="" method="post">
					<input type="hidden" name="process" value="1" />
					<input type="hidden" name="actionid" value="<!--{$action[3]}-->" />
					<input type="hidden" name="actioncode" value="A" />
					<input type="hidden" name="line" value="<!--{$line}-->" />
                    <input type="hidden" name="new_ani" id="new_ani" size="10"/>
              </form>		
			<table cellspacing="0" cellpadding="0" border="0" width="90%">
				<tr style="height: 20px">
					<td width="20">&nbsp;</td>	
					<td align="left">
						<!--{lang k=DESCRIPCION_AVANZADO}--><br /><br />
					</td>
				</tr>
				<tr style="height: 20px">
					<td width="20">&nbsp;</td>	
					<td align="left">
						<input type="image" src="<!--{ipath name="bt-agregar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ADD}-->" onclick="addAni(); return false;"/>
					</td>
				</tr>
			</table>
			<br />
            <!--{if $telef_con|@count > 0}-->
			<table cellspacing="2" cellpadding="0" border="0" width="">
				<tr style="height: 20px">
					<td width="20">&nbsp;</td>	
					<td class="scr_resalt" align="center" width="140"><a href="#" class="popup_link" title="<!--{lang k=AVANZADO_NUMERO_TITLE}-->"><!--{lang k=NUMERO}--></a></td>			
                    <td align="center" class="scr_resalt" width="160"><a href="#" class="popup_link" title="<!--{lang k=AVANZADO_REFERENCIA_TITLE}-->"><!--{lang k=REFERENCIA}--></a></td>
					<td class="scr_resalt" align="center" width="200"><!--{lang k=REGLA}--></td>
                    <td class="scr_resalt" align="center" width="100"><!--{lang k=BORRAR}--></td>
                    <td class="scr_resalt" align="center">&nbsp;</td>
				</tr>
				
			<!--{foreach name="telef_con" from=$telef_con item="telef"}-->	
			<form name="frmdelete" id="frmdelete" action="" method="post">	
					<input type="hidden" name="process" value="1" />
					<input type="hidden" name="actionid" value="<!--{$action[3]}-->" />
					<input type="hidden" name="actioncode" value="B" />
					<input type="hidden" name="line" value="<!--{$line}-->" />
					<input type="hidden" name="anidelete" id="anidelete" value="" />
			</form>            
				<tr style="height: 20px">
             <form name="frmupdate" id="frmupdate" action="" method="post">
					<input type="hidden" name="process" value="1" />
					<input type="hidden" name="actionid" value="<!--{$action[3]}-->" />
					<input type="hidden" name="actioncode" value="M" />
					<input type="hidden" name="line" value="<!--{$line}-->" />
					<input type="hidden" name="aniupdate" id="aniupdate" value="<!--{$telef.ANI}-->" />
               
					<td>&nbsp;</td>	
					<td align="center"><!--{$telef.ANI}--></td>			
					<td align="center"><input type="text" name="descripcion" value="<!--{$telef.Desc_ANI}-->"/></td>
					<td align="center">
						<select name="actionupdate">
							<option value="0">- Seleccione una opci&oacute;n -</option>
							<option value="BLOQUEO" <!--{if $telef.ShortDescAccion == "BLOQUEO"}--> selected <!--{/if}-->><!--{lang k=BLOQUEADO}--></option>
							<option value="VOICEMAIL" <!--{if $telef.ShortDescAccion == "VOICEMAIL"}--> selected <!--{/if}-->><!--{lang k=CONTESTADOR}--></option>
							
						</select>
					</td>
                    <td align="center">
                        
                        <a href=""><b><a href="#" onclick="deleteAni('<!--{$telef.ANI}-->'); return false"><img src="<!--{ipath name="icono-goma.gif"}-->" border="0" /></a>
                    </td>
                    <td align="center"><input type="image" src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->"/></td>
                    </form>
				</tr>
				
			<!--{/foreach}-->
			</table>
          <!--{/if}-->
			</div>
		</td></tr>
		<tr><td>&nbsp;</td></tr>
<script type="text/javascript">
function deleteAni(newani){
	document.getElementById('anidelete').value = newani;
	document.getElementById('frmdelete').submit();
}
function updateAni(newani, newstatus){
	document.getElementById('aniupdate').value = newani;
	document.getElementById('actionupdate').value = newstatus;	
	document.getElementById('frmupdate').submit();
}
</script>
<tr style="height: 30px;"><td class="scr_resalt"><span style="cursor: pointer;" onclick="show_hide('action<!--{$action[3]}-->'); return false;">&nbsp;<img src="<!--{ipath name="bt-ampliar.gif" owner="1"}-->" border="0">&nbsp;</span><!--{$action[0]}--></td></tr>
		<tr><td>
		<div id="action<!--{$action[3]}-->" style="display:none;">
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr style="height: 20px">
				<td class="scr_resalt" width="20">&nbsp;</td>	
				<td class="scr_resalt" align="left" width="30">&nbsp;</td>			
				<td class="scr_resalt" width="100"><!--{lang k=NUMERO}--></td>
				<td class="scr_resalt" align="center" width="200"><!--{lang k=ACCION}--></td>
				<td class="scr_resalt"></td>
			</tr>
			<!--{foreach name="telef_con" from=$telef_con item="telef"}-->
			<tr style="height: 25px">
			<form name="frmdelete" id="frmdelete" action="" method="post">	
					<input type="hidden" name="process" value="1" />
					<input type="hidden" name="actionid" value="<!--{$action[3]}-->" />
					<input type="hidden" name="actioncode" value="B" />
					<input type="hidden" name="line" value="<!--{$line}-->" />
					<input type="hidden" name="anidelete" id="anidelete" value="" />
				</form>
				<form name="frmupdate" id="frmupdate" action="" method="post">
					<input type="hidden" name="process" value="1" />
					<input type="hidden" name="actionid" value="<!--{$action[3]}-->" />
					<input type="hidden" name="actioncode" value="M" />
					<input type="hidden" name="line" value="<!--{$line}-->" />
					<input type="hidden" name="aniupdate" id="aniupdate"value="" />
					<input type="hidden" name="actionupdate" id="actionupdate" value="" />
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;">&nbsp;</td>	
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;" align="left"><a href=""><b><a href="#" onclick="deleteAni('<!--{$telef.ani}-->'); return false"><img src="<!--{ipath name="wrong.gif"}-->" width="15" height="18" border="0"/></a></b></a></td>			
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;"><!--{$telef.ani}--></td>
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;" align="center" height="20">
					<select name="telef_con_option<!--{$telef.ani}-->" onchange="updateAni('<!--{$telef.ani}-->', this.value)">
						<option  <!--{if $telef.accion == 0}--> selected <!--{/if}--> value="0">Follow Me</option>
						<option <!--{if $telef.accion == 1}--> selected <!--{/if}--> value="1">Bloqueado</option>
						<option <!--{if $telef.accion == 2}--> selected <!--{/if}--> value="2">Pedido de Clave - Follow Me</option>
						<option <!--{if $telef.accion == 3}--> selected <!--{/if}--> value="3">Hola Mail</option>
						<option <!--{if $telef.accion == 4}--> selected <!--{/if}--> value="4">Nro.Especial</option>
				</select>
				
				</td>
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;">&nbsp;</td>
				</form>	
			</tr>
			<!--{/foreach}-->
			<form name="frm" action="" method="post">
					<input type="hidden" name="process" value="1" />
					<input type="hidden" name="actionid" value="<!--{$action[3]}-->" />
					<input type="hidden" name="actioncode" value="A" />
					<input type="hidden" name="line" value="<!--{$line}-->" />
			<tr>
			<td>&nbsp;</td>
			<td colspan="4">&nbsp;</td></tr>
			<tr>
			<td>&nbsp;</td>
			<td colspan="2" align="left"><b><!--{lang k=AGREGAR_NUMERO}--></b></td>
			<td>&nbsp;</td>
			</tr>
			
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>			
				<td>Numero</td>
				<td align="center"><!--{lang k=ACCION}--></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td style="padding-left: 5px;"><input type="text" name="new_ani" size="10"/></td>
				<td align="center" style="padding-left: 5px;">
				<select name="new_action">
					<option value="0">Follow Me</option>
					<option value="1">Bloqueado</option>
					<option value="2">Pedido de Clave - Follow Me</option>
					<option value="3">Hola Mail</option>
					<option value="4">Nro.Especial</option>
				</select>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr><td colspan="5">&nbsp;</td></tr>				
			<tr><td colspan="4" align="right"><input type="image" src="<!--{ipath name="bt-agregar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ADD}-->" /></td>
			<td>&nbsp;</td>
			</tr>	
			</form>		
			</table>
		</div>
		</td></tr>
		<tr><td>&nbsp;</td></tr>
<tr style="height: 30px;"><td class="scr_resalt2">
<span style="cursor: pointer;" onclick="show_hide('action<!--{$action[3]}-->'); return false;">&nbsp;&nbsp;&nbsp;<img src="<!--{ipath name="arrow.gif"}-->" border="0">&nbsp;&nbsp;</span><a href="#" class="popup_link" onclick="show_hide('action<!--{$action[3]}-->'; return false;)"><!--{$action[0]}--></a></td></tr>
		<tr><td>
		<div id="action<!--{$action[3]}-->" style="display: none;">
		<input type="hidden" name="line" value="<!--{$line}-->" />
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<form name="frm" action="" method="post">
		<input type="hidden" name="process" value="1" />
		<input type="hidden" name="actionid" value="<!--{$action[3]}-->" />
		<input type="hidden" name="actioncode" value="M" />
		<input type="hidden" name="line" value="<!--{$line}-->" />
        <input type="hidden" name="Tel_Esp" value="<!--{$datos[0].Tel_Esp|trim}-->">
        <input type="hidden" name="clave_pub" value="<!--{$datos[0].clave_pub|trim}-->">
        <input type="hidden" name="default_otros" value="<!--{$datos[0].default_otros|trim}-->">
        
			<tr style="height: 25px">
				<td width="20">&nbsp;</td>
				<td width="150"><!--{lang k=REFERENCIA}--></td>
				<td width="280"><input type="text" name="Usuario" size="45" value="<!--{$datos[0].Usuario|trim}-->"></td>
				<td>&nbsp;</td>
			</tr>
			<tr style="height: 25px">
				<td>&nbsp;</td>
				<td><!--{lang k=CLAVE}--></td>
				<td><input type="password" name="clave_acc" value="<!--{$datos[0].clave_acc|trim}-->"></td>
				<td>&nbsp;</td>
			</tr>
			
			<tr style="height: 25px">
				<td colspan="3" align="right"><input type="image" src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->" /></td>
				<td>&nbsp;</td>
			</tr>									
		</form>
		</table>
		
	</div>
</td></tr>
<tr><td>&nbsp;</td></tr>
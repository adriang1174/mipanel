<tr style="height: 30px;"><td class="scr_resalt2">
<span style="cursor: pointer;" onclick="show_hide('action<!--{$action[3]}-->'); return false;">&nbsp;&nbsp;&nbsp;<img src="<!--{ipath name="arrow.gif"}-->" border="0">&nbsp;&nbsp;</span><a href="#" class="popup_link" onclick="show_hide('action<!--{$action[3]}-->'); return false;"><!--{$action[0]}--></a></td></tr>

		<tr><td>
		<div id="action<!--{$action[3]}-->" style="display: none;">
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<form name="frm" action="" method="post">
		<input type="hidden" name="process" value="1" />
		<input type="hidden" name="actionid" value="<!--{$action[3]}-->" />
		<input type="hidden" name="actioncode" value="M" />
		<input type="hidden" name="line" value="<!--{$line}-->" />
			<tr style="height: 25px">
				<td style="padding-left: 5px;" width="20">&nbsp;</td>
				<td style="padding-left: 5px;" width="130">Destino Callback</td>
				<td style="padding-left: 5px;" width="150"><input type="text" name="destino" value="<!--{$telef_con.0.destino}-->"></td>
				<td>&nbsp;</td>
			</tr>
			<tr style="height: 25px">
				<td style="padding-left: 5px;" colspan="3" align="right"><input type="image" src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->" /></td>
				<td>&nbsp;</td>
			</tr>									
		</table>
		</form>
	</div>
</td></tr>
<tr><td>&nbsp;</td></tr>

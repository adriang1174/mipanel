<tr style="height: 30px;"><td class="scr_resalt">
<span style="cursor: pointer;" onclick="show_hide('action<!--{$action[3]}-->')">&nbsp;<img src="<!--{ipath name="bt-ampliar.gif" owner="1"}-->" border="0">&nbsp;</span><!--{$action[0]}--></td></tr>
		<tr><td>
		<div id="action<!--{$action[3]}-->" style="display: none;">
		<form name="frm" action="" method="post">
			<input type="hidden" name="process" value="1" />
			<input type="hidden" name="actionid" value="<!--{$action[3]}-->" />
			<input type="hidden" name="actioncode" value="M" />
			<input type="hidden" name="line" value="<!--{$line}-->" />
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr style="height: 25px">
				<td width="20" style="padding-left: 5px;">&nbsp;</td>
				<td width="400"><!--{lang k=NETFONO_RESET_PASSWORD}--></td>
				<td>&nbsp;</td>
			</tr>
			<tr  style="height: 25px">
				<td align="center" colspan="2"><input type="image" src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->" /></td>
				<td>&nbsp;</td>
			</tr>									
		</table>
		</form>
	</div>
</td></tr>
<tr><td>&nbsp;</td></tr>
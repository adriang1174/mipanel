<tr style="height: 30px;"><td class="scr_resalt2"><span style="cursor: pointer;" onclick="show_hide('action<!--{$action[3]}-->'); return false;">&nbsp;&nbsp;&nbsp;<img src="<!--{ipath name="arrow.gif"}-->" border="0">&nbsp;&nbsp;</span><a href="#" class="popup_link" onclick="show_hide('action<!--{$action[3]}-->'); return false;"><!--{$action[0]}--></a></td></tr>
		<tr><td>
		<div id="action<!--{$action[3]}-->" style="display: none;">
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<form name="frm" action="" method="post">
			<input type="hidden" name="process" value="1" />
			<input type="hidden" name="actionid" value="<!--{$action[3]}-->" />
			<input type="hidden" name="actioncode" value="M" />
			<input type="hidden" name="line" value="<!--{$line}-->" />
            <input type="hidden" name="Mail2" id="Mail2" size="45" value="<!--{$datos[0].Mail2|trim}-->"/>
            <input type="hidden" name="Mail3" id="Mail3" size="45" value="<!--{$datos[0].Mail3|trim}-->"/>
            <input type="hidden" name="MailFax" id="MailFax" size="45" value="<!--{$datos[0].MailFax|trim}-->"/>
			<tr style="height: 25px">
				<td width="20">&nbsp;</td>
				<td width="150"><!--{lang k=MAIL}--></td>
				<td width="280"><input type="text" name="Mail1" id="Mail1" size="45" value="<!--{$datos[0].Mail1|trim}-->"/></td>
				<td>&nbsp;</td>
			</tr>
			<tr style="height: 25px">
				<td>&nbsp;</td>
				<td><!--{lang k=AVISO_MAIL}--></td>
				<td><input type="text" name="AvisoMail" id="AvisoMail" size="45" value="<!--{$datos[0].AvisoMail|trim}-->"/></td>
				<td>&nbsp;</td>
			</tr>	
			<tr style="height: 35px">
				<td>&nbsp;</td>
				<td colspan="2" align="right"><input type="image" src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->"/></td>
				<td >&nbsp;</td>
				</tr>													
				</form>
			</table>
	
			</div>
		</td></tr>
		<tr><td>&nbsp;</td></tr>

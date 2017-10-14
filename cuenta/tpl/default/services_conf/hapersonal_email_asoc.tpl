<tr style="height: 30px;"><td class="scr_resalt"><span style="cursor: pointer;" onclick="show_hide('action<!--{$action[3]}-->'); return false;">&nbsp;<img src="<!--{ipath name="bt-ampliar.gif" owner="1"}-->" border="0">&nbsp;</span><!--{$action[0]}--></td></tr>
		<tr><td>
		<div id="action<!--{$action[3]}-->" style="display: none;">
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<form name="frm" action="" method="post">
			<input type="hidden" name="process" value="1" />
			<input type="hidden" name="actionid" value="<!--{$action[3]}-->" />
			<input type="hidden" name="actioncode" value="M" />
			<input type="hidden" name="line" value="<!--{$line}-->" />
			<input type="hidden" name="hm_casilla" value="<!--{$email_asoc[0].hm_casilla|trim}-->">
			<input type="hidden" name="hm_atsubcas" value="<!--{$email_asoc[0].hm_atsubcas|trim}-->">
			<input type="hidden" name="hm_subcasilla" value="<!--{$email_asoc[0].hm_subcasilla|trim}-->">
			<tr style="height: 25px">
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;" width="20">&nbsp;</td>
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;" width="150"><!--{lang k=MAIL}--></td>
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;" width="250"><input type="text" name="mail_orig" size="45" value="<!--{$email_asoc[0].hm_mailorig|trim}-->"/></td>
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;" width="20">&nbsp;</td>
			</tr>
			<tr><td colspan="4">&nbsp;</td></tr>
			<tr style="height: 25px">
			<td>&nbsp;</td>
			<td colspan="3" align="right"><input type="image" src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->" /></td>
			<td>&nbsp;</td>
			</tr>
			</form>
			</table>
			</div>
		</td></tr>
		<tr><td>&nbsp;</td></tr>
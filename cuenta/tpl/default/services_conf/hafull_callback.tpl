<script type="text/javascript">
function showCallback(){
	var w = window.screen.width;
	var h = window.screen.height;
	var popW = 900, popH = 550;
	var leftPos = (w-popW)/2, topPos = (h-popH)/2;
	window.open('fh_callback.ca?popup=1&ani=<!--{$line}-->&id_accion=<!--{$action[3]}-->','popup','width=' + popW + ',height=' + popH + ',top=' + topPos + ',left=' + leftPos+',scrollbars=yes,resizable=yes');
}
</script>
	<tr style="height: 30px;"><td class="scr_resalt"><span style="cursor: pointer;" onclick="show_hide('action<!--{$action[3]}-->'); return false;">&nbsp;&nbsp;&nbsp;<img src="<!--{ipath name="arrow.gif"}-->" border="0">&nbsp;&nbsp;</span><a href="#" class="popup_link" onclick="show_hide('action<!--{$action[3]}-->'); return false;"><!--{$action[0]}--></a></td></tr>
		<tr><td>
			<div id="action<!--{$action[3]}-->" style="display: none;">
				<table cellspacing="0" cellpadding="0" border="0" width="100%">
				<tr style="height: 10px;">
					<td colspan="3">&nbsp;</td>
				</tr>
				<tr>
				<td width="20">&nbsp;</td>
				<td>
					<a href="#" onclick="showCallback(); return false;"/><img src="<!--{ipath name="bt-vergrilla.gif" owner="1" lang="1"}-->" border="0"></td>
				</td>
				<td>&nbsp;</td>
				</tr>
				</table>
			</div>	
		</td></tr>
		<tr><td>&nbsp;</td></tr>
<script type="text/javascript">
function showFollowme(){
	var w = window.screen.width;
	var h = window.screen.height;
	var popW = 900, popH = 550;
	var leftPos = (w-popW)/2, topPos = (h-popH)/2;
	window.open('fh_callback.ca?popup=1&followme=1&ani=<!--{$line}-->&id_accion=<!--{$action[3]}-->','popup','width=' + popW + ',height=' + popH + ',top=' + topPos + ',left=' + leftPos);
}
</script>
		
		<tr style="height: 30px;"><td class="scr_resalt"><span style="cursor: pointer;" onclick="show_hide('action<!--{$action[3]}-->'); return false;">&nbsp;<img src="<!--{ipath name="bt-ampliar.gif" owner="1"}-->" border="0">&nbsp;</span><!--{$action[0]}--></td></tr>
		<tr><td>
			<div id="action<!--{$action[3]}-->" style="display: none;">
				<table cellspacing="0" cellpadding="0" border="0" width="100%">
				<tr style="height: 10px;">
					<td colspan="3">&nbsp;</td>
				</tr>
				<tr>
				<td width="20">&nbsp;</td>
				<td>
					<input type="image" src="<!--{ipath name="bt-ver-modificar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->" onclick="showFollowme(); return false;"/>
				</td>
				<td>&nbsp;</td>
				</tr>
				</table>
			</div>	
		</td></tr>
		<tr><td>&nbsp;</td></tr>
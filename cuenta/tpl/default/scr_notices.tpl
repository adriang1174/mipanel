<form method="POST" action="notices.ca?is_post=1" style="margin: 0px;">
	<table border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr style="height: 25px;"><td colspan="2" class="scr_header">
        <font class="scr_header"><!--{$strPath}--></font>
        </td></tr>
		<!--{if $error}-->
			<tr><td colspan="2" style="padding: 10px;" align="center" class="error"><!--{lang k=NOTICES_ERROR}--></td></tr>
		<!--{/if}-->
		<tr><td colspan="2" style="padding-top: 10px;"></td></tr>
		<tr style="height: 25px;" valign="middle">
			<td class="scr_resalt" style="border: 1px solid #7F7F7F; border-bottom: 0px; padding-left: 5px;"><!--{lang k=RECEIVE_REPORT_DESC}--></td>
			<td width="220" style="border: 1px solid #7F7F7F; border-bottom: 0px; border-left: 0px; padding-left: 5px;"><input type="radio" name="receive_report" value="1" <!--{if $receive_report}-->checked="checked"<!--{/if}--> /><!--{lang k=YES_ALT}-->&nbsp;<input type="radio" name="receive_report" value="" <!--{if !$receive_report}-->checked="checked"<!--{/if}--> /><!--{lang k=NO_ALT}--></td>
		</tr>
		<tr style="height: 25px;" valign="middle">
			<td class="scr_resalt" style="border: 1px solid #7F7F7F; border-bottom: 0px; padding-left: 5px;"><!--{lang k=RECEIVE_ALERT_DESC}--></td>
			<td style="border: 1px solid #7F7F7F; border-bottom: 0px; border-left: 0px; padding-left: 5px;"><input type="radio" name="receive_alert" value="1" <!--{if $receive_alert}-->checked="checked"<!--{/if}--> /><!--{lang k=YES_ALT}-->&nbsp;<input type="radio" name="receive_alert" value="" <!--{if !$receive_alert}-->checked="checked"<!--{/if}--> /><!--{lang k=NO_ALT}--></td>
		</tr>
		<tr style="height: 25px;" valign="middle">
			<td class="scr_resalt" style="border: 1px solid #7F7F7F; border-bottom: 0px; padding-left: 5px;"><!--{lang k=LIMIT_MINUTES_DESC}--></td>
			<td style="border: 1px solid #7F7F7F; border-bottom: 0px; border-left: 0px; padding-left: 5px;">
				<table border="0" cellspacing="0" cellpadding="0"><tr valign="middle">
					<td><input type="text" name="limit_minutes" value="<!--{$limit_minutes|escape:"htmlall"}-->" /></td>
					<td>&nbsp;<!--{lang k=MINUTES}--></td>
				</table>
			</td>
		</tr>
		<tr style="height: 25px;" valign="middle">
			<td class="scr_resalt" style="border: 1px solid #7F7F7F; border-bottom: 0px; padding-left: 5px;"><!--{lang k=LIMIT_PRICE_DESC}--></td>
			<td style="border: 1px solid #7F7F7F; border-bottom: 0px; border-left: 0px; padding-left: 5px;">
				<table border="0" cellspacing="0" cellpadding="0"><tr valign="middle">
					<td><!--{$currency->symbol}-->&nbsp;</td>
					<td><input type="text" name="limit_price" value="<!--{$limit_price|escape:"htmlall"}-->" /></td>
				</table>
			</td>
		</tr>
		<tr style="height: 25px;" valign="middle">
			<td class="scr_resalt" style="border: 1px solid #7F7F7F; border-bottom: 0px; padding-left: 5px;"><!--{lang k=RECEIVE_IMAGE_DESC}--></td>
			<td style="border: 1px solid #7F7F7F; border-bottom: 0px; border-left: 0px; padding-left: 5px;"><input type="radio" name="receive_image" value="1" <!--{if $receive_image}-->checked="checked"<!--{/if}--> /><!--{lang k=YES_ALT}-->&nbsp;<input type="radio" name="receive_image" value="" <!--{if !$receive_image}-->checked="checked"<!--{/if}--> /><!--{lang k=NO_ALT}--></td>
		</tr>
		<tr style="height: 25px;" valign="middle">
			<td class="scr_resalt" style="border: 1px solid #7F7F7F; padding-left: 5px;"><!--{lang k=RECEIVE_DETAIL_DESC}--></td>
			<td style="border: 1px solid #7F7F7F; border-left: 0px; padding-left: 5px;"><input type="radio" name="receive_detail" value="1" <!--{if $receive_detail}-->checked="checked"<!--{/if}--> /><!--{lang k=YES_ALT}-->&nbsp;<input type="radio" name="receive_detail" value="" <!--{if !$receive_detail}-->checked="checked"<!--{/if}--> /><!--{lang k=NO_ALT}--></td>
		</tr>
		<tr><td colspan="2" style="padding-top: 15px;"><input type="image" src="<!--{ipath name="bt-aceptar.gif" owner="1" lang="1"}-->" />&nbsp;<a href="index.ca"><img src="<!--{ipath name="bt-cancelar.gif" owner="1" lang="1"}-->" border="0" /></a></td></tr>
	</table>
</form>

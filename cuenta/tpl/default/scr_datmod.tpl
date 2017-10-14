<form method="POST" action="datmod.ca?is_post=1" style="margin: 0px;">
	<table border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr style="height: 25px;"><td colspan="2" class="scr_header">
        <font class="scr_header"><!--{$strPath}--></font>
        </td></tr>
		<!--{if $error}-->
			<tr><td colspan="2" style="padding: 10px;" align="center" class="error"><!--{$error}--></td></tr>
		<!--{/if}-->
		<tr><td colspan="2" style="padding-top: 10px;"></td></tr>
		<tr style="height: 25px;" valign="middle">
			<td style="border: 1px solid #7F7F7F; border-bottom: 0px; padding-left: 5px;" class="scr_resalt"><!--{lang k=EMAIL}--></td>
			<td style="border: 1px solid #7F7F7F; border-bottom: 0px; border-left: 0px; padding-left: 5px;">
				<input type="text" name="uemail" value="<!--{$uemail|escape:"htmlall"}-->" />
			</td>
		</tr>
		<tr style="height: 25px;" valign="middle">
			<td style="border: 1px solid #7F7F7F; border-bottom: 0px;  padding-left: 5px;" class="scr_resalt"><!--{lang k=PASSWORD2}--></td>
			<td style="border: 1px solid #7F7F7F; border-bottom: 0px; border-left: 0px; padding-left: 5px;">
				<input type="password" name="password" value="<!--{$password|escape:"htmlall"}-->" />
			</td>
		</tr>
		<tr style="height: 25px;" valign="middle">
			<td style="border: 1px solid #7F7F7F; padding-left: 5px;" class="scr_resalt"><!--{lang k=PASSWORD2_CONFIRMATION}--></td>
			<td style="border: 1px solid #7F7F7F; border-left: 0px; padding-left: 5px;">
				<input type="password" name="password_confirm" value="<!--{$password_confirm|escape:"htmlall"}-->" />
			</td>
		</tr>
		<tr><td colspan="2" style="padding-top: 15px;"><input type="image" src="<!--{ipath name="bt-aceptar.gif" owner="1" lang="1"}-->" />&nbsp;<a href="index.ca"><img src="<!--{ipath name="bt-cancelar.gif" owner="1" lang="1"}-->" border="0" /></a></td></tr>
	</table>
</form>

<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr style="height: 25px;"><td class="scr_header">
    <font class="scr_header"><!--{$strPath}--></font>
    </td></tr>
    
<!-- ###################################################################################### -->

    <tr><td><!--{lang k=MSG_EDIT_EMAIL}--></td></tr>
	
<!-- ###################################################################################### -->

<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr><td style="padding-top: 20px;">

<form action="<!--{phpself}-->?post=1" method="POST" style="margin: 0px;">
<table border="0" cellspacing="0" cellpadding="0" width="100%">

<!--{if $msg_errorEmail}-->
	<tr>
	<td colspan="2" style="padding: 20px;" align="center">
	<table border="0" cellspacing="0" cellpadding="0" class="info_table">
	<tr><td style="padding: 10px;" class="error"><b><!--{$msg_errorEmail}--></b></td></tr>
	</table>
	</td>
	</tr>
<!--{elseif $msg_infoEmail}-->
	<tr>
	<td colspan="2" style="padding: 10px;" align="center">
	<table border="0" cellspacing="0" cellpadding="0" class="info_table">
	<tr><td style="padding: 5px;" class="ticket_row_title"><b><!--{$msg_infoEmail}--></b></td></tr>
	</table>
	</td>
	</tr>
<!--{/if}-->

<tr valign="top">
<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #7F7F7F; "><b><!--{lang k=FIELD_NAME_EMAIL}--></b>:</td>

<td style="padding-left: 5px; padding: 5px; border: 1px solid #7F7F7F; border-left: 0px;">
<input type="text" name="user_email" value="<!--{$user_email}-->" maxlength="128" size="64" />
</td>
</tr>

<tr>
<td colspan="2" style="padding-top: 20px;" align="center">
&nbsp;<input type="image" name="submit" value="submit" src="<!--{ipath name="bt-aceptar.gif" owner="1" lang="1"}-->" />
&nbsp;
<a href="email_password.ca">
<input type="image" src="<!--{ipath name="bt-cancelar.gif" owner="1" lang="1"}-->" name="cancel" value="1" />
</a>
<input type="hidden" name="updateEmail" value="1" maxlength="128" size="64" />
</td>
</tr>

</table>
</form>

</td></tr>
</table>


<br />
<br />

<!-- ###################################################################################### -->
	
	<tr><td><!--{lang k=MSG_EDIT_PASSWORD}--></td></tr>

<!-- ###################################################################################### -->

<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr><td style="padding-top: 20px;">


<form action="<!--{phpself}-->?post=1" method="POST" style="margin: 0px;">
<table border="0" cellspacing="0" cellpadding="0" width="100%">

<!--{if $msg_errorPass}-->
<tr>
<td colspan="2" style="padding: 20px;" align="center">
<table border="0" cellspacing="0" cellpadding="0" class="info_table">
<tr><td style="padding: 10px;" class="error"><b><!--{$msg_errorPass}--></b></td></tr>
</table>
</td>
</tr>

<!--{elseif $msg_infoPass}-->
<tr>
<td colspan="2" style="padding: 10px;" align="center">
<table border="0" cellspacing="0" cellpadding="0" class="info_table">
<tr><td style="padding: 5px;" class="ticket_row_title"><b><!--{$msg_infoPass}--></b></td></tr>
</table>
</td>
</tr>
<!--{/if}-->

<tr valign="top">
<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #7F7F7F; border-bottom: 0px;"><!--{lang k=FIELD_NAME_PASSWORD}-->:</td>
<td style="padding-left: 5px; padding: 5px; border: 1px solid #7F7F7F; border-left: 0px; border-bottom: 0px;">
<input type="password" name="user_passwd" value="" maxlength="128" size="64" />

</td>
</tr>
<tr valign="top">
<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #7F7F7F;"><!--{lang k=FIELD_NAME_CONFIRM_PASSWORD}-->:</td>
<td style="padding-left: 5px; padding: 5px; border: 1px solid #7F7F7F; border-left: 0px;">
<input type="password" name="user_passwd_confirm" value="" maxlength="128" size="64" />
</td>
</tr>

<tr>
<td colspan="2" style="padding-top: 20px;" align="center">
&nbsp;<input type="image" name="submit" value="submit" src="<!--{ipath name="bt-aceptar.gif" owner="1" lang="1"}-->" />
&nbsp;
<a href="email_password.ca">
<input type="image" src="<!--{ipath name="bt-cancelar.gif" owner="1" lang="1"}-->" name="cancel" value="1" />
<input type="hidden" name="updatePass" value="1" maxlength="128" size="64" />
</a>

</td>
</tr>

</table>
</form>

</td></tr>
</table>

<!--(!)depreciado: <tr><td><!--{include file="ca_form/main.tpl"}--></td></tr>-->

</table>

<table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr style="height: 25px;"><td class="scr_header">
        <font class="scr_header"><!--{$strPath}--></font>
        </td></tr>
		
<!-- ###################################################################################### -->
<!--{if $display_invoicePrivData}-->
	<tr><td><b><!--{lang k=MSG_EDIT_INVOICEDATA_PRIVATE_TITLE}--></b></td></tr>
	<tr><td>&nbsp;</td></tr>
<!--{if $display_invoicePrivData}-->
    <tr><td><!--{lang k=MSG_EDIT_INVOICEDATA_PRIVATE}--></td></tr>
<!--{/if}-->
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
<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #eee; border-bottom: 0px;">
<b><!--{lang k=INVOICEDATA_FIELD_NAME_STREET}--></b>:</td>
<td style="padding-left: 5px; padding: 5px; border: 1px solid #eee; border-left: 0px;">
<input type="text" name="user_calle" value="<!--{$user_calle}-->" maxlength="128" size="64" />
</tr>

<tr valign="top">
<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #eee; border-bottom: 0px;">
<b><!--{lang k=INVOICEDATA_FIELD_NAME_NUMBER}--></b>:</td>
<td style="padding-left: 5px; padding: 5px; border: 1px solid #eee; border-left: 0px;">
<input type="text" name="user_nro" value="<!--{$user_nro}-->" maxlength="128" size="64" />
</tr>

<tr valign="top">
<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #eee; border-bottom: 0px;">
<b><!--{lang k=INVOICEDATA_FIELD_NAME_FLOOR}--></b>:</td>
<td style="padding-left: 5px; padding: 5px; border: 1px solid #eee; border-left: 0px;">
<input type="text" name="user_piso" value="<!--{$user_piso}-->" maxlength="128" size="64" />
</tr>

<tr valign="top">
<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #eee; border-bottom: 0px;">
<b><!--{lang k=INVOICEDATA_FIELD_NAME_APARTMENT}--></b>:</td>
<td style="padding-left: 5px; padding: 5px; border: 1px solid #eee; border-left: 0px;">
<input type="text" name="user_dpto" value="<!--{$user_dpto}-->" maxlength="128" size="64" />
</tr>

<tr valign="top">
<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #eee; border-bottom: 0px;">
<b><!--{lang k=INVOICEDATA_FIELD_NAME_CITY}--></b>:</td>
<td style="padding-left: 5px; padding: 5px; border: 1px solid #eee; border-left: 0px;">
<input type="text" name="user_ciudad" value="<!--{$user_ciudad}-->" maxlength="128" size="64" />
</tr>

<tr valign="top">
<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #eee; border-bottom: 0px;">
<b><!--{lang k=INVOICEDATA_FIELD_NAME_LOC}--></b>:</td>
<td style="padding-left: 5px; padding: 5px; border: 1px solid #eee; border-left: 0px;">
<input type="text" name="user_localidad" value="<!--{$user_localidad}-->" maxlength="128" size="64" />
</tr>

<tr valign="top">
<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #eee; border-bottom: 0px;">
<b><!--{lang k=INVOICEDATA_FIELD_NAME_CP}--></b>:</td>
<td style="padding-left: 5px; padding: 5px; border: 1px solid #eee; border-left: 0px;">
<input type="text" name="user_cp" value="<!--{$user_cp}-->" maxlength="128" size="64" />
</tr>

<tr valign="top">
<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #eee; border-bottom: 0px;">
<b><!--{lang k=INVOICEDATA_FIELD_NAME_STATE}--></b>:</td>
<td style="padding-left: 5px; padding: 5px; border: 1px solid #eee; border-left: 0px;">
<input type="text" name="user_pcia" value="<!--{$user_pcia}-->" maxlength="128" size="64" />
</tr>

<tr>
<td colspan="2" style="padding-top: 20px;" align="center">
&nbsp;<input type="image" name="submit" value="submit" src="<!--{ipath name="bt-aceptar.gif" owner="1" lang="1"}-->" />
&nbsp;
<a href="company_info.ca">
<input type="image" src="<!--{ipath name="bt-cancelar.gif" owner="1" lang="1"}-->" name="cancel" value="1" />
</a>
<input type="hidden" name="updateInvoiceData" value="1" maxlength="128" size="64" />
</td>
</tr>

</table>
</form>
</td></tr>
</table>

<br />
<br />
<!--{/if}-->

<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr><td style="padding-top: 10px;">

<table border="0" cellspacing="0" cellpadding="0" width="100%">
<!-- ###################################################################################### -->

	<tr><td><b><!--{lang k=MSG_EDIT_INVOICEDATA_COMPANY_TITLE}--></b></td></tr>
	<tr><td>&nbsp;</td></tr>
    <tr><td><!--{lang k=MSG_EDIT_INVOICEDATA_COMPANY}--></td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td><a href="<!--{lang k=FILE_EDIT_INVOICEDATA_COMPANY_FORMULARIO}-->" target="_blank"><!--{lang k=MSG_EDIT_INVOICEDATA_COMPANY_LINK1}--></a></td></tr>
    <tr><td><a href="<!--{lang k=FILE_EDIT_INVOICEDATA_COMPANY_INSTRUCTIVO}-->" target="_blank"><!--{lang k=MSG_EDIT_INVOICEDATA_COMPANY_LINK2}--></a></td></tr>

<!-- ###################################################################################### -->
</table>

<!--{if $msg}-->
El formulario ha sido enviado con &eacute;xito
<!--{/if}-->

</td></tr>
</table>
</table>

<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr style="height: 25px;"><td class="scr_header"><font class="scr_header"><!--{$strPath}--> &gt; <!--{lang k=DETALLE_CENTRO_COSTOS_POR_DESTINO}--></font></td></tr>
    <!--{include file="email.tpl" email_pbottom="10" email_ptop="20"}-->
	<tr><td style="padding-top: 10px;">
		<!--{include file="ca_list.tpl"}-->
	</td></tr>
	<tr><td style="padding-top: 15px;"><!--{lang k=TICKET_DISCLAIMER}--></td></tr>
	<tr><td style="padding-top: 10px; padding-bottom: 10px;"><!--{lang k=NO_IVA}--></td></tr>
	<!--{if !$print}-->
		<tr><td style="padding-top: 10px;">
			<!--{include file="buttons.tpl" button_print="1" button_exportcsv="1" button_email="1"}-->
		</td></tr>
	<!--{/if}-->
</table>

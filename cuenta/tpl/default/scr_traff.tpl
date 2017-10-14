<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <!--{if !$print}-->
	    <tr style="height: 25px;"><td style="padding-bottom: 10px;" class="scr_header"><font class="scr_header2"><!--{section_title title=TITLE_TICKET_ITEM_TRAFF}--></td></tr>
    <!--{/if}-->
    <!--{include file="email.tpl" email_pbottom="20" email_ptop="20"}-->
	<tr><td style="padding-top: 10px;">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr style="height: 20px;">
				<td class="scr_resalt2" style="padding: 3px; border-top: 1px solid #CCCCCC;"><!--{lang k=FACTURA}--></td>
				<td style="padding: 3px; border-top: 1px solid #CCCCCC;"><a href="ticket.ca?ticketid=<!--{$ticket_item_traff->ticketid}-->"><!--{$ticket_item_traff->ticketid}--></a></td>
				<td class="scr_resalt2" style="padding: 3px; border-top: 1px solid #CCCCCC;"><!--{lang k=RELEASE_DATE}--></td>
				<td style="padding: 3px; border-top: 1px solid #CCCCCC; border-right: 1px solid #CCCCCC;"><!--{$ticket_item_traff->date}--></td>
			</tr>
			<tr style="height: 20px;">
				<td class="scr_resalt2" style="padding: 3px; border-top: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC;"><!--{lang k=RSOCIAL}--></td>
				<td colspan="3" style="padding: 3px; border-top: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; border-right: 1px solid #CCCCCC;"><!--{$ticket_item_traff->titular}--></td>
			</tr>
		</table>
	</td></tr>
	<tr><td style="padding-top: 35px;">
		<!--{include file=ca_list.tpl}-->
	</td></tr>
	<tr><td style="padding-top: 15px;"><!--{lang k=TICKET_DISCLAIMER}--></td></tr>
	<tr><td style="padding-top: 10px; padding-bottom: 10px;"><!--{lang k=NO_IVA}--></td></tr>
	<!--{if !$print}-->
		<tr><td style="padding-top: 10px;">
            <!--{include file="buttons.tpl" button_print="1" button_exportcsv="1" button_email="1"}-->
        </td></tr>
	<!--{/if}-->
</table>

<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <!--{if !$print}-->
	    <tr style="height: 25px;"><td style="padding-bottom: 10px;" class="scr_header"><!--{section_title title=TITLE_TICKET_ITEM}--></td></tr>
    <!--{/if}-->
    <!--{include file="email.tpl" email_pbottom="20" email_ptop="20"}-->
	<tr><td style="padding-top: 10px;">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr style="height: 20px;">
				<td class="scr_resalt2" style="padding: 3px; border-top: 1px solid #CCCCCC;"><!--{lang k=FACTURA}--></td>
				<td style="padding: 3px; border-top: 1px solid #CCCCCC;"><a href="ticket.ca?ticketid=<!--{$ticket_item->ticketid}-->"><!--{$ticket_item->ticketid}--></a></td>
				<td class="scr_resalt2" style="padding: 3px; border-top: 1px solid #CCCCCC;"><!--{lang k=RELEASE_DATE}--></td>
				<td style="padding: 3px; border-top: 1px solid #CCCCCC; border-right: 1px solid #CCCCCC;"><!--{$ticket_item->date}--></td>
			</tr>
			<tr style="height: 20px;">
				<td class="scr_resalt2" style="padding: 3px; border-top: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC;"><!--{lang k=RSOCIAL}--></td>
				<td colspan="3" style="padding: 3px; border-top: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; border-right: 1px solid #CCCCCC;"><!--{$ticket_item->titular}--></td>
			</tr>
		</table>
	</td></tr>
	<tr><td style="padding-top: 20px;">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<thead>
				<tr style="height: 20px;"><td class="scr_resalt"><!--{lang k=LINE_PIN}--></td><td class="scr_resalt"><!--{lang k=CALLS}--></td><td class="scr_resalt"><!--{lang k=DURATION}--></td><td class="scr_resalt" align="right"><!--{lang k=PRICE2}--></td></tr>
			</thead>
			<tbody>
				<!--{foreach name=items_list from=$ticket_item->items_list key=key item=item}-->
					<tr style="height: 25px;"><td style="border-bottom: 1px solid #CCCCCC;"><a href="traff.ca?ticketid=<!--{$ticket_item->ticketid}-->&itemid=<!--{$ticket_item->itemid}-->&pinid=<!--{$item->pinid}-->&servicetype=<!--{$item->servicetype}-->"><!--{$item->pin}--></a></td><td style="border-bottom: 1px solid #CCCCCC;"><!--{$item->calls}--></td><td style="border-bottom: 1px solid #CCCCCC;"><!--{$item->duration}--></td><td style="border-bottom: 1px solid #CCCCCC;" align="right"><!--{$item->price}--></td></tr>
				<!--{/foreach}-->
				<tr style="height: 25px;"><td style="border-bottom: 1px solid #CCCCCC;"><!--{lang k=TOTAL}--></td><td style="border-bottom: 1px solid #CCCCCC;"><!--{$ticket_item->total_calls}--></td><td style="border-bottom: 1px solid #CCCCCC;"><!--{$ticket_item->total_duration}--></td><td style="border-bottom: 1px solid #CCCCCC;" align="right"><!--{$ticket_item->total_price}--></td></tr>
			</tbody>
		</table>
	</td></tr>
	<tr><td style="padding-top: 15px;"><!--{lang k=TICKET_DISCLAIMER}--></td></tr>
	<tr><td style="padding-top: 10px; padding-bottom: 10px;"><!--{lang k=NO_IVA}--></td></tr>
	<!--{if !$print}-->
		<tr><td style="padding-top: 10px;">
            <!--{include file="buttons.tpl" button_print="1" button_exportcsv="1" button_email="1"}-->
        </td></tr>
	<!--{/if}-->
</table>

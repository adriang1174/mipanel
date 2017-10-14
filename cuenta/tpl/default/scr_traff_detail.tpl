<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr style="height: 25px;"><td style="padding-bottom: 10px;" class="scr_header"><font class="scr_header2"><!--{section_title title=TITLE_TRAFF_NF_CENTRO_COSTOS}--></td></tr>
	<tr><td style="padding-top: 20px;">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<thead>
				<tr><td colspan="7" align="right" style="padding-right: 15px;">
					<!--{include file=paginate.tpl}-->
				</td></tr>
				<tr style="height: 20px;"><td class="scr_resalt"><!--{lang k=DATE}--></td><td class="scr_resalt"><!--{lang k=HOUR}--></td><td class="scr_resalt"><!--{lang k=SOURCE}--></td><td class="scr_resalt"><!--{lang k=CALLED}--></td><td class="scr_resalt"><!--{lang k=TARGET}--></td><td class="scr_resalt"><!--{lang k=DURATION}--></td><td class="scr_resalt" align="right"><!--{lang k=PRICE2}--></td></tr>
			</thead>
			<tbody>
				<!--{if $traff->agrupation}-->
					<!--{foreach name=traff from=$traff->agrupation key=key item=traff_agrupation}-->
							<tr style="height: 25px;">
								<td colspan=""></td>
							</tr>
							<!--{foreach name=traffa1 from=$traff_agrupation key=key2 item=traff_agrupation_item}-->
								<tr style="height: 25px;">
									<td style="border-bottom: 1px solid #CCCCCC;">-&gt;</td>
									<td style="border-bottom: 1px solid #CCCCCC;"><!--{$traff_agrupation_item->date}--></td>
									<td style="border-bottom: 1px solid #CCCCCC;"><!--{$traff_agrupation_item->hour}--></td>
									<td style="border-bottom: 1px solid #CCCCCC;"><!--{$traff_agrupation_item->source}--></td>
									<td style="border-bottom: 1px solid #CCCCCC;"><!--{$traff_agrupation_item->called}--></td>
									<td style="border-bottom: 1px solid #CCCCCC;"><!--{$traff_agrupation_item->target}--></td>
									<td style="border-bottom: 1px solid #CCCCCC;"><!--{$traff_agrupation_item->duration}--></td>
									<td style="border-bottom: 1px solid #CCCCCC;" align="right"><!--{$traff_agrupation_item->price}--></td>
								</tr>
							<!--{/foreach}-->
					<!--{/foreach}-->
				<!--{elseif $traff->items}-->
				<!--{/if}-->
				<!--{if $show_total}-->
					<tr style="height: 25px;"><td style="border-bottom: 1px solid #CCCCCC;" colspan="5">TOTAL</td><td style="border-bottom: 1px solid #CCCCCC;"><!--{$traff->total_duration}--></td><td style="border-bottom: 1px solid #CCCCCC;" align="right"><!--{$traff->total_price}--></td></tr>
				<!--{/if}-->
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

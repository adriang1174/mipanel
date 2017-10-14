<!--{if $ca_list_empty}-->
	<table border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr><td align="center"><!--{lang k=NO_ROWS_ALT}--></td></tr>
	</table>	
<!--{elseif $ca_list->valid}-->
	<table border="0" cellspacing="0" cellpadding="0" width="100%">
		<thead>
			<!--{if $ca_list->paginate_element}-->
				<tr><td colspan="<!--{$ca_list->cols}-->" style="padding-bottom: 10px;">
					<!--{include file=paginate.tpl
						paginate_element=$ca_list->paginate_element
					}-->
				</td></tr>
			<!--{/if}-->
			<tr style="height: 20px;">
				<!--{foreach name=header_col from=$ca_list->header_elements key=key item=element}-->
					<td class="scr_resalt" style="<!--{if $smarty.foreach.header_col.last}-->padding-right: 5px;<!--{elseif $smarty.foreach.header_col.first}-->padding-left: 5px;<!--{/if}-->"<!--{if $smarty.foreach.header_col.last}--> align="right"<!--{/if}-->><!--{lang k=$element}--></td>
				<!--{/foreach}-->
			</tr>
			<!--{if $ca_list->subheader}-->
				<tr><td style="padding-top: 1px;" colspan="<!--{$ca_list->cols}-->">
					<table border="0" cellspacing="0" cellpadding="0" width="100%">
						<tr style="height: 20px;"><td class="scr_resalt" align="right">
							<table border="0" cellspacing="0" cellpadding="0">
								<tr><td><!--{lang k=$ca_list->subheader.key}--></td><td width="125" class="scr_resalt" style="padding-right: 5px;" align="right"><!--{$ca_list->subheader.value}--></td></tr>
							</table>
						</tr>
					</table>
				</td></tr>
			<!--{/if}-->
		</thead>
		<!--{if $ca_list->subfooter || $ca_list->show_footer}-->
			<tfoot>
				<!--{if $ca_list->subfooter}-->
					<tr><td style="padding-top: 1px;" colspan="<!--{$ca_list->cols}-->">
						<table border="0" cellspacing="0" cellpadding="0" width="100%">
							<tr style="height: 20px;"><td class="scr_resalt" align="right">
								<table border="0" cellspacing="0" cellpadding="0">
									<tr><td><!--{lang k=$ca_list->subfooter.key}--></td><td width="125" class="scr_resalt" style="padding-right: 5px;" align="right"><!--{$ca_list->subfooter.value}--></td></tr>
								</table>
							</tr>
						</table>
					</td></tr>
				<!--{/if}-->
				<!--{if $ca_list->show_footer}-->
					<tr style="height: 20px;">
						<!--{foreach name=header_col from=$ca_list->header_elements key=key item=element}-->
							<td class="scr_resalt" style="<!--{if $smarty.foreach.header_col.last}-->padding-right: 5px;<!--{elseif $smarty.foreach.header_col.first}-->padding-left: 5px;<!--{/if}-->"<!--{if $smarty.foreach.header_col.last}--> align="right"<!--{/if}-->><!--{lang k=$element}--></td>
						<!--{/foreach}-->
					</tr>
				<!--{/if}-->
			</tfoot>
		<!--{/if}-->
		<tbody>
			<!--{if $ca_list->body_agrupation}-->
				<!--{foreach from=$ca_list->body_agrupation key=key item=agrupation}-->
					<!--{* WE ARE HANDLING AN AGRUPATED LIST *}-->
					<!--{ca_list_agrupation_init}-->
					<!--{ca_list_agrupation agrupation=$agrupation cols=$ca_list->cols}-->
				<!--{/foreach}-->
			<!--{else}-->
				<!--{* WE ARE HANDLING AN ITEM-ONLY LIST *}-->
				<!--{foreach from=$ca_list->body_elements key=key item=row}-->
					<tr style="height: 21px;">
						<!--{foreach name=body_col from=$row key=key2 item=col}-->
						<td style="border-bottom: 1px solid #CCCCCC;<!--{if $smarty.foreach.body_col.last}--> padding-right: 5px;<!--{elseif $smarty.foreach.body_col.first}--> padding-left: 5px;<!--{/if}-->"<!--{if $smarty.foreach.body_col.last}--> align="right"<!--{/if}-->><!--{if $col.href}--><a href="<!--{$col.href}-->"><!--{/if}--><!--{$col.value}--><!--{if $col.href}--></a><!--{/if}--></td>
						<!--{/foreach}-->
					</tr>
				<!--{foreachelse}-->
					<tr><td colspan="<!--{$ca_list->cols-$ca_list_total_count}-->"><!--{lang k=NOELEMENTS}--></td></tr>
				<!--{/foreach}-->
			<!--{/if}-->
			<!--{if $show_total}-->
				<tr style="height: 25px;"><td style="border-bottom: 1px solid #CCCCCC;" colspan="<!--{$ca_list->cols-$ca_list_total_count}-->"><!--{lang k=TOTAL2}--></td>
					<!--{foreach name=ca_list_total from=$ca_list_total key=key item=mytot}-->
						<td style="border-bottom: 1px solid #CCCCCC;"<!--{if $smarty.foreach.ca_list_total.last}--> align="right"<!--{/if}-->><!--{$mytot}--></td>
					<!--{/foreach}-->
			<!--{/if}-->
		</tbody>
	</table>
<!--{else}-->
	<h1>Invalid ca_list, please verify the smarty assigment section.</h1>
<!--{/if}-->

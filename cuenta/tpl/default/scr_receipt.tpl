<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<!--{if !$print}-->
        <tr style="height: 25px;"><td class="scr_header">
        <font class="scr_header"><!--{$strPath}-->:<!--{$receipt->receiptid}--></font>
        
        <!--codigo original smaty: section_title title=TITLE_RECEIPT replacement=$receipt->receiptid-->
        
        </td></tr>
		<tr><td style="padding-top: 10px; padding-bottom: 10px;"><!--{lang k=CHECKING_ACCOUNT_DESC}--></td></tr>
	<!--{/if}-->

    <!--{include file="email.tpl"}-->
	<tr><td style="padding-top: 35px; padding-right: 10px;">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr>
				<td width="265"><img src="<!--{ipath name="clogo.gif" owner="1" lang="1"}-->" width="265" height="68" /></td>
				<td style="padding-left: 10px;"><img src="<!--{ipath name="R.gif" owner="1" lang="1"}-->" /></td>
				<td align="right">
					<table border="0" cellspacing="0" cellpadding="0">
						<tr><td style="padding-right: 30px;" class="ticket_row_title" align="right"><!--{lang k=RECEIPT_N}--></td><td align="right"><b><!--{$receipt->receipt_number}--></b></td></tr>
						<tr><td style="padding-right: 30px; padding-top: 5px;" class="ticket_row_title" align="right"><!--{lang k=DATE}--></td><td align="right"><!--{$receipt->date}--></td></tr>
					</table>
				</td>
			</tr>
		</table>
	</td></tr>
	<tr><td style="padding-right: 10px;">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr valign="top">
				<td class="ticket_owner_info" width="275">
				<!--{if $receipt->receipt_suc < 100}-->
					<!--{foreach name=info_contact from=$info_contact key=key item=line}-->
						<!--{$line}--><br />
					<!--{/foreach}-->
				<!--{else}-->
					Latinatel S.A.<br />
					RUC 21-512054-0011<br />
					Av. Ing. Luis Pance 1302 Piso 11<br />
					(11300) Montevideo Uruguay<br />
					www.holaargentina.com
				<!--{/if}-->
				</td>
				<td class="ticket_owner_info" style="padding-left: 10px;">
				<!--{if $receipt->receipt_suc < 100}-->
					<!--{foreach name=info_contact from=$info_facturation key=key item=line}-->
						<!--{$line}--><br />
					<!--{/foreach}-->
				<!--{else}-->
					&nbsp;
				<!--{/if}-->
				</td>
				<td align="right" style="padding-top: 15px;">
				</td>
			</tr>
		</table>
	</td></tr>
	<tr><td style="padding-top: 40px;">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr valign="top">
				<td><b><!--{lang k=TITULAR}--></b></td>
				<td style="padding-left: 10px;"><!--{$receipt->titular}--></td>
				<td style="padding-left: 10px;"><b><!--{lang k=CUIT}--></b></td>
				<td style="padding-left: 10px;"><!--{$receipt->cuit}--></td>
			</tr>
			<tr style="height: 10px;"><td colspan="4">&nbsp;</td></tr>
			<tr style="height: 10px;"><td colspan="4">&nbsp;</td></tr>
			<tr valign="top">
				<td><b><!--{lang k=CLIENT_CODE}--></b></td>
				<td style="padding-left: 10px;"><!--{$receipt->userid}--></td>
				<td colspan="2"></td>
			</tr>
		</table>
	</td></tr>
	<tr><td style="padding-top: 30px;">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<thead>
				<tr style="height: 20px;">
					<td class="ticket_detail_header" style="padding-left: 5px;"><!--{lang k=DESCRIPTION}--></td>
					<td class="ticket_detail_header"><!--{lang k=BANK}--></td>
					<td class="ticket_detail_header"><!--{lang k=PAYCHECK}--></td>
					<td class="ticket_detail_header"><!--{lang k=DATE_UPPER}--></td>
					<td class="ticket_detail_header" align="right" style="padding-right: 5px;"><!--{lang k=PRICE}--></td>
				</tr>
			</thead>
			<tbody>
				<!--{foreach name=comsumo_list from=$receipt->item_list key=key item=receipt_item}-->
					<tr style="height: 20px;">
						<td class="ticket_detail_body" style="padding-left: 5px;"><!--{$receipt_item->desc}--></td>
						<td class="ticket_detail_body"><!--{$receipt_item->bank}--></td>
						<td class="ticket_detail_body"><!--{$receipt_item->paycheck}--></td>
						<td class="ticket_detail_body"><!--{$receipt_item->date}--></td>
						<td class="ticket_detail_body" align="right" style="padding-right: 5px;"><!--{$receipt_item->amount}--></td>
					</tr>
				<!--{foreachelse}-->
					<tr><td colspan="5" class="ticket_detail_body" style="padding-left: 5px; padding-right: 5px;"><!--{lang k=NO_RECEIPT_DETAILS}--></td></tr>
				<!--{/foreach}-->
					<tr><td colspan="5" style="padding-top: 20px; padding-left: 5px; padding-right: 5px; padding-bottom: 5px;" class="ticket_detail_body">
						<table border="0" cellspacing="0" cellpadding="0" width="100%">
								<tr style="height: 20px;">
									<td style="border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding-left: 5px;" colspan="5"><!--{$receipt->total_string}--></td>
									<td style="border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding-right: 5px;" align="right"><b><!--{lang k=TOTAL}-->:</b></td>
									<td style="border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; padding-right: 5px;" align="right"><b><!--{$receipt->total}--></b></td>
								</tr>
						</table>
					</td></tr>
					<tr><td colspan="5" class="ticket_detail_body" style="padding-left: 5px; padding-right: 5px; padding-top: 20px; padding-bottom: 5px;">
						<table border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><!--{lang k=PAY_DATE}--></td>
								<td style="padding-left: 100px;"><!--{$receipt->pay_date}--></td>
							</tr>
						</table>
					</td></tr>
			</tbody>
		</table>
	</td></tr>
	<tr><td style="padding-top: 15px;"><!--{lang k=TICKET_DISCLAIMER}--></td></tr>
	<!--{if !$print}-->
		<tr><td style="padding-top: 10px;">
            <!--{include file="buttons.tpl" button_print="1" button_email="1"}-->
        </td></tr>
	<!--{/if}-->
</table>

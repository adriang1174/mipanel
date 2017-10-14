<form action="traff_f.ca" method="GET" style="margin: 0px;">
	<table border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr style="height: 25px;"><td style="padding-bottom: 10px;" class="scr_header"><font class="scr_header"><!--{$strPath}--></font></td></tr>
		<tr><td style="padding-top: 10px;"><!--{lang k=TRAFF_F_DESC}--></td></tr>
		<tr><td style="padding-top: 20px;">
			<table border="0" cellspacing="0" cellpadding="0" width="100%" class="scr_resalt">
				<tr style="height: 25px;" valign="middle">
					<td><!--{lang k=SIMPLE_INFORMS}-->:</td>
					<td>
						<select name="type">
							<option value="1"><!--{lang k=TRAFF_F_REPORT_DETAIL_BY_COST_CENTER}--></option>
							<option value="2"><!--{lang k=TRAFF_F_REPORT_DETAIL_BY_ACCOUNT}--></option>
							<option value="3"><!--{lang k=TRAFF_F_REPORT_DETAIL_BY_CALL_REFERENCE}--></option>
							<option value="4"><!--{lang k=TRAFF_F_REPORT_SUMMARY_BY_COST_CENTER}--></option>
							<option value="5"><!--{lang k=TRAFF_F_REPORT_SUMMARY_BY_CALL_REFERENCE}--></option>
							<option value="6"><!--{lang k=TRAFF_F_REPORT_SUMMARY_BY_ORIGIN_OF_CALL}--></option>
							<option value="7"><!--{lang k=TRAFF_F_REPORT_SUMMARY_BY_DIALED_NUMBER}--></option>
							<option value="8"><!--{lang k=TRAFF_F_REPORT_SUMMARY_BY_LOCATION}--></option>
						</select>
					</td>
					<td><!--{lang k=TICKETS}-->:</td>
					<td>
						<select name="ticketid">
							<!--{foreach from=$traff_f->tickets key=key item=ticket}-->
								<option value="<!--{$ticket->ticketid}-->"><!--{$ticket->date}--> (<!--{$ticket->docnum}-->)</option>
							<!--{/foreach}-->
						</select>
					</td>
					<td><input type="image" src="<!--{ipath name="bt-aceptar.gif" owner="1" lang="1"}-->" /></td>
				</tr>
			</table>
		</td></tr>
	</table>
</form>

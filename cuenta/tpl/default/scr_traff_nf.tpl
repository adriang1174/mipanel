<form action="traff_nf.ca" method="GET" style="margin: 0px;">
	<table border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr style="height: 25px;"><td style="padding-bottom: 10px;" class="scr_header"><font class="scr_header"><!--{$strPath}--></font></td></tr>
		<tr><td style="padding-top: 10px;"><!--{lang k=TRAFF_NF_DESC}--></td></tr>
		 <tr><td style="padding-top: 20px;"><a href="traff_nf.ca?type=4&datefrom=&dateto=&pinid=&dialednumber="><img src="<!--{ipath name="bt-ultimasllamadas.gif" owner="1" lang="1"}-->" border="0" /></a></td></tr>
		<tr><td style="padding-top: 20px;">
			<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr style="height: 20px;" valign="middle"><td colspan="4" style="border: 1px solid #7F7F7F; border-bottom: 0px; padding-left: 5px;"><!--{lang k=REPORT_WITH_FILTER}--></td></tr>
				<tr style="height: 26px;" valign="middle">
					<td style="border: 1px solid #7F7F7F; border-bottom: 0px; border-right: 0px; padding-left: 5px;" class="scr_resalt"><!--{lang k=REPORTS}--></td>
					<td colspan="3" style="border: 1px solid #7F7F7F; border-bottom: 0px; padding-left: 5px;">
						<select name="type">
							<option value="1"><!--{lang k=TRAFF_NF_DETAIL_BY_CENTRO_DE_COSTO}--></option>
							<option value="2"><!--{lang k=TRAFF_NF_DETAIL_BY_LINE_PIN}--></option>
							<option value="3"><!--{lang k=TRAFF_NF_DETAIL_BY_CALL_REFERENCE}--></option>
							<option value="4"><!--{lang k=TRAFF_NF_DETAIL_BY_LAST_CALLS}--></option>
							<option value="5"><!--{lang k=TRAFF_NF_RESUME_BY_CENTRO_DE_COSTO}--></option>
							<option value="6"><!--{lang k=TRAFF_NF_RESUME_BY_LINE_PIN}--></option>
							<option value="7"><!--{lang k=TRAFF_NF_RESUME_BY_DIALED_NUMBER}--></option>
							<option value="8"><!--{lang k=TRAFF_NF_RESUME_BY_CALL_REFERENCE}--></option>
							<option value="9"><!--{lang k=TRAFF_NF_RESUME_BY_ORIGIN_OF_CALL}--></option>
							<option value="10"><!--{lang k=TRAFF_NF_RESUME_BY_LOCATION}--></option>
						</select>
					</td>
				</tr>
				<tr style="height: 26px;" valign="middle">
					<td align="left" style="border: 1px solid #7F7F7F; border-bottom: 0px; border-right: 0px; padding-left: 5px;" class="scr_resalt"><!--{lang k=DATE_FROM}--></td>
					<td align="left" style="border: 1px solid #7F7F7F; border-bottom: 0px; border-right: 0px; padding-left: 5px;"><script type="text/javascript">DateInput( 'datefrom', false, 'YYYY/MM/DD'<!--{if $traff_nf->start_date}-->, '<!--{$traff_nf->start_date}-->'<!--{/if}-->);</script></td>
					<td align="left" style="border: 1px solid #7F7F7F; border-bottom: 0px; border-right: 0px; padding-left: 5px;" class="scr_resalt"><!--{lang k=DATE_TO}--></td>
					<td align="left" style="border: 1px solid #7F7F7F; border-bottom: 0px; padding-left: 5px;"><script type="text/javascript">DateInput( 'dateto', true, 'YYYY/MM/DD', '<!--{$traff_nf->end_date}-->');</script></td>
				</tr>
				<tr style="height: 26px;" valign="middle">
					<td style="border: 1px solid #7F7F7F; border-bottom: 0px; border-right: 0px; padding-left: 5px; " class="scr_resalt"><!--{lang k=LINE_PIN}--></td>
					<td colspan="3" style="border: 1px solid #7F7F7F; border-bottom: 0px; padding-left: 5px;">
						<select name="pinid">
							<option value=""></option>
							<!--{foreach from=$traff_nf->lines key=key item=item}-->
								<option value="<!--{$item}-->"><!--{$item}--></option>
							<!--{/foreach}-->
						</select>
					</td>
				</tr>
				<tr style="height: 26px;" valign="middle">
					<td style="border: 1px solid #7F7F7F; border-bottom: 0px; border-right: 0px; padding-left: 5px; " class="scr_resalt"><!--{lang k=DIALED_NUMBER}--></td>
					<td colspan="3" style="border: 1px solid #7F7F7F; border-bottom: 0px; padding-left: 5px;"><input type="text" name="dialednumber" value="" maxlength="128" />&nbsp;<!--{lang k=DIALED_NUMBER_ACLARATION}--></td>
				</tr>
				<tr style="height: 26px;" valign="middle">
					<td style="border: 1px solid #7F7F7F; border-right: 0px; padding-left: 5px;" class="scr_resalt"></td>
					<td colspan="3" style="border: 1px solid #7F7F7F; padding-left: 5px;"><input type="image" src="<!--{ipath name="bt-aceptar.gif" owner="1" lang="1"}-->" /></td>
				</tr>
			</table>
		</td></tr>
       
	</table>
</form>

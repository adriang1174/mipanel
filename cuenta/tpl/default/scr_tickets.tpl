<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <!--{if !$print}-->
        <tr style="height: 25px;"><td class="scr_header">
        <font class="scr_header"><!--{$strPath}--></font>
        </td></tr>
        <!--{if $eml_confirm}-->
            <tr>
                <td colspan="2" style="padding: 10px; padding-top: 20px;" align="center">
                    <table border="0" cellspacing="0" cellpadding="0" class="info_table">
                        <tr><td style="padding: 5px;" class="ticket_row_title"><b><!--{lang k=PROFILE_DATA_SAVED_EML_CONFIRM}--></b></td></tr>
                    </table>
                </td>
            </tr>
        <!--{/if}-->
        <tr><td style="padding-top: 10px; padding-bottom: 10px;"><!--{lang k=SELECT_BY_MONTH}--></td></tr>
        <!--{if $ticket_months}-->
            <tr><td style="padding: 5px;" class="scr_resalt">
                <form name="months" action="ticket.ca" method="GET" style="margin: 0px;">
                    <table border="0" cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                            <td align="left"><!--{lang k=SELECT_THE_MONTH}--></td>
                            <td align="right">
                                <select name="month">
                                    <!--{foreach name=ticket_months from=$ticket_months key=key item=ticket_month}-->
                                        <option value="<!--{$key}-->"><!--{$ticket_month}--></option>
                                    <!--{/foreach}-->
                                </select>
								<select name="year">
									 <!--{foreach name=ticket_years from=$ticket_years key=key item=year}-->
										<option value="<!--{$year}-->" <!--{if $year == $ticket_sel_year}--> selected="selected"<!--{/if}-->><!--{$year}-->
									<!--{/foreach}-->
								</select>
                            </td>
                            <td align="right" width="66" style="padding-left: 5px;"><input type="image" src="<!--{ipath name="bt-aceptar.gif" owner="1" lang="1"}-->"></td>
                        </tr>
                    </table>
                </form>
            </td></tr>
        <!--{/if}-->
    <!--{/if}-->
    <!--{include file="email.tpl" email_ptop="20"}-->
	<tr><td style="padding-top: 35px;">
		<!--{include file=ca_list.tpl}-->
	</td></tr>
	<!--{if !$print}-->
        <tr><td style="padding-top: 10px;">
            <!--{include file="buttons.tpl"}-->
        </td></tr>
	<!--{/if}-->
</table>
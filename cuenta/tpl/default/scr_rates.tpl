<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <!--{if !$print}-->
        <tr style="height: 25px;"><td class="scr_header">
        <font class="scr_header"><!--{$strPath}--></font>
        </td></tr>
        <tr><td style="padding-top: 15px;"><!--{lang k=RATES_TIP}--></td></tr>
    <!--{/if}-->
    <!--{include file="email.tpl" email_pbottom="10"}-->
	<tr><td style="padding-top: 15px;">
		<!--{include file=ca_list.tpl}-->
		<br /><!--{lang k="TARIFAS_VIGENTES"}-->
	</td></tr>
	
	<!--{if !$print}-->
        <tr><td style="padding-top: 10px;">
            <!--{include file="buttons.tpl"}-->
        </td></tr>
	<!--{/if}-->
</table>

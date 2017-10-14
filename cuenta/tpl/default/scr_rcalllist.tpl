<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <!--{if !$print}-->
	    <tr style="height: 25px;"><td class="scr_header">
        <font class="scr_header"><!--{$strPath}--></font>
        </td></tr>
    <!--{/if}-->
    <!--{include file="email.tpl" email_pbottom="10"}-->
	<tr><td style="padding-top: 20px;">
		<!--{include file=ca_list.tpl}-->
	</td></tr>
    <!--{if !$print}-->
	    <tr><td style="padding-top: 20px;"><a href="rcalladd.ca"><img src="<!--{ipath name="bt-agregar.gif" owner="1" lang="1"}-->" border="0" /></a>&nbsp;<!--{include file="buttons.tpl"}--></td></tr>
    <!--{/if}-->
</table>

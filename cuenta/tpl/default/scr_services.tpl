<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr style="height: 25px;"><td class="scr_header"><font class="scr_header2"><!--{if $service_name}--><font class="scr_header"><!--{$strPath}--> &gt; <!--{$service_name}--></font><!--{else}--><font><!--{$strPath}--></font><!--{/if}--></td></tr>
    <tr><td style="padding-top: 10px;">
        <!--{if $completed}-->
            <table border="0" cellspacing="0" cellpadding="0" class="info_table">
                <!--{capture assign="comp"}--><!--{if $phone_support && $addr_support}--><!--{lang k=SERVICE_ACTION_COMPLETED}--><!--{else}--><!--{lang k=SERVICE_ACTION_COMPLETED_ONLY_EMAIL}--><!--{/if}--><!--{/capture}-->
                <tr><td style="padding: 5px;" class="ticket_row_title"><b><!--{$comp|replace:"[OWNER_EMAIL]":$addr_support|replace:"[OWNER_PHONE]":$phone_support}--></b></td></tr>
            </table>
            <br />
        <!--{/if}-->
        <!--{if $email_not_verif}-->
            <table border="0" cellspacing="0" cellpadding="0" class="info_table">
                <tr><td style="padding: 5px;" class="ticket_row_title"><b><!--{lang k=ERR_EMAIL_NOT_VERIFIED}--></b></td></tr>
                <tr><td align="center" style="padding: 5px;"><a href="email.ca" target="_self"><img src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->" border="0" /></a>&nbsp;<a href="index.ca" target="_self"><img src="<!--{ipath name="bt-cancelar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=CANCEL}-->" border="0" /></a></td></tr>
            </table>
        <!--{else}-->
            <!--{if $show_form}-->
	            <div style="text-align: center; font-weight: normal; margin-bottom: -20px; padding-top: 5px;"><!--{$extra_txt}--></div>
                <!--{include file="ca_form/main.tpl"}-->
            <!--{else}-->
                <form action="services.ca" method="get" style="margin: 0px;">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr><td style="padding-bottom: 10px;"><!--{lang k=SERVICES_TIP}--></td></tr>
                        <tr><td>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <select name="service" onchange="this.form.submit( );">
                                            <!--{foreach name="services" from=$services key="key" item="service"}-->
                                                <option value="<!--{$service.id_servicio}-->"><!--{$service.servicio}--></option>
                                            <!--{/foreach}-->
                                        </select>
                                    </td>
                                    <td style="padding-left: 10px;"><input type="image" src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->" /></td>
                                </tr>
                            </table>
                        </td></tr>
                    </table>
                </form>
            <!--{/if}-->
        <!--{/if}-->
    </td></tr>
</table>

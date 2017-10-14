<!--{if $email}-->
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr><td<!--{if $email_pbottom || $email_ptop}--> style="padding-bottom: <!--{$email_pbottom|default:0}-->px; padding-top: <!--{$email_ptop|default:0}-->px;"<!--{/if}-->>
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <!--{if $email_done}-->
                    <tr><td style="padding-top: 20px; padding-bottom: 5px;" class="action_done"><!--{lang k=EMAIL_SENT_SUCESSFULLY}--></td></tr>
                <!--{elseif $email_failed}-->
                    <tr><td style="padding-top: 20px; padding-bottom: 5px;" class="action_failed"><!--{lang k=EMAIL_SEND_FAILED}--></td></tr>
                <!--{else}-->
                    <tr><td style="border: 1px solid #7F7F7F;">
                        <form action="<!--{currenturi empty="1"}-->" method="get" style="margin: 0px;">
                            <input type="hidden" name="email_sid" value="<!--{$email_sid}-->" />
                            <!--{currenthidden flag="email" clean="print,printall,exportcsv,eaddr,email_failed,email_done,pay,email_sid"}-->
                            <table border="0" cellspacing="0" cellpadding="0" width="100%" style="height: 27px;">
                                <tr valign="middle">
                                    <td style="padding-left: 10px; border-right: 1px solid #7F7F7F; " class="scr_resalt"><!--{lang k=EMAIL_ADDRESS}-->:</td>
                                    <td style="padding-left: 10px; border-right: 1px solid #7F7F7F;"><input type="text" name="eaddr" value="<!--{$eaddr}-->" size="40" /></td>
                                    <td style="padding-left: 10px;"><input type="image" src="<!--{ipath name="bt-enviarpormail.gif" owner="1" lang="1"}-->" />&nbsp;<a href="<!--{currenturi clean="print,printall,exportcsv,email,eaddr,email_failed,email_done,pay"}-->"><img src="<!--{ipath name="bt-cancelar.gif" owner="1" lang="1"}-->" border="0" /></a></td>
                                </tr>
                            </table>
                        </form>
                    </td></tr>
                <!--{/if}-->
            </table>
        </td></tr>
<!--{/if}-->

<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title><!--{$panel_name}--></title>
		<meta http-equiv="pragma" content="no-cache"/>
		<meta name="mssmarttagspreventparsing" content="true"/>

		<style rel="stylesheet" type="text/css">
			<!--{include file="css.tpl"}-->
		</style>

        <!--{include file="css_owner.tpl"}-->
	</head>

	<body style="margin: 20px; width: 360px;">
        <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
            <!--{if $error == "error_invalid_user"}-->
                <tr><td class="ticket_row_title" style="color: red;font-weight:normal"><!--{lang k=PASSWD_INVALID_USER}--></td></tr>
            <!--{elseif $error == "error_email_not_verified"}-->
                <!--{if $owner_phone}-->
                    <!--{capture assign="tmp"}--><!--{lang k=PASSWD_EMAIL_NOT_VERIFIED}--><!--{/capture}-->
                <!--{else}-->
                    <!--{capture assign="tmp"}--><!--{lang k=PASSWD_EMAIL_NOT_VERIFIED_ONLY_EMAIL}--><!--{/capture}-->
                <!--{/if}-->
                <tr><td class="ticket_row_title" style="color: red;font-weight:normal"><!--{$tmp|replace:"[OWNER_EMAIL]":$owner_email|replace:"[OWNER_PHONE]":$owner_phone}--></td></tr>
            <!--{elseif $error == "error_send_email"}-->
                <tr><td style="color: red;font-weight:normal"><!--{lang k=PASSWD_UNABLE_TO_SEND_EMAIL}--> <!--{$owner_email}--></td></tr>
			<!--{elseif $error == "error_use_client_id"}-->
                <tr><td style="color: red;font-weight:normal"><!--{lang k=PASSWD_USE_CLIENT_ID}--></td></tr>
            <!--{else}-->
                <tr><td class="ticket_row_title" style="font-weight:normal; color: black;"><!--{lang k=PASSWD_SENT}--> <!--{$owner_email}--></td></tr>
            <!--{/if}-->
            <tr><td style="padding-top: 25px;" align="center"><a href="javascript:void(window.close( ));"><img src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->" border="0" /></a></td></tr>
        </table>
    </body>
</html>

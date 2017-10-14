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

	<body>
        <table border="0" cellspacing="0" cellpadding="0" align="center">
            <tr valign="middle">
                <td><!--{if $owner}--><img src="<!--{ipath name="logo.gif" owner="1" lang="1"}-->" /><!--{/if}--></td>
                <td style="padding-left: 10px;">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <!--{if $error == "db_set_failed"}-->
                            <tr><td class="ticket_row_title" style="color: red;"><!--{lang k=EML_CONFIRM_ERROR_DB_SET_FAILED}--></td></tr>
                        <!--{elseif $error == "invalid_hash"}-->
                            <tr><td style="font-weight: bold; color: red;"><!--{lang k=EML_CONFIRM_ERROR_INVALID_HASH}--></td></tr>
                        <!--{else}-->
                            <tr><td class="ticket_row_title"><!--{lang k=EML_CONFIRM_OK}--></td></tr>
                            <tr><td class="ticket_row_title"><!--{lang k=EML_CONFIRM_OK_TXT2}--></td></tr>
                        <!--{/if}-->
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>

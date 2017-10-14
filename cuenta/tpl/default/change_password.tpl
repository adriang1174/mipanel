<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title><!--{lang k=TITLE}--></title>
		<meta http-equiv="pragma" content="no-cache"/>
		<meta name="mssmarttagspreventparsing" content="true"/>
		<style type="text/css">
			<!--{include file="css.tpl"}-->
		</style>
        <!--{include file="css_owner.tpl"}-->
	</head>

	<body>
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tbody>
				<tr><td align="center" style="padding-top: 55px;">
					<form action="change_password.ca" method="POST" style="margin: 0px;">
						<input type="hidden" name="k" value="<!--{$k}-->" />
						<table border="0" cellspacing="0" cellpadding="0" width="299" height="211" class="login_table" style="background-image: url( <!--{ipath name="login-background.gif" owner="1" lang="1"}-->); background-repeat: no-repeat;">
							<!--{if $show_form}-->
							<tr>
								<td style="padding-left: 10px; padding-top: 90px; width:100px;" class="login_font">Contrase&ntilde;a</td>
								<td style="padding-top: 90px;" ><input name="password" id="password" type="password" size="30" style="width: 170px;" /></td>
							</tr>
							<tr>
								<td style="padding-left: 10px; width:100px;" class="login_font">Confirmar Contrase&ntilde;a</td>
								<td style="" valign="top"><input name="password2" type="password" size="30" style="width: 170px;" /></td>
							</tr>
                           <!--{/if}-->
							<!--{if $error_msg}-->
								<tr>
									<td colspan="2" style="padding-top: 25px; padding-left: 20px; padding-right: 20px;" class="login_error" align="center"><!--{$error_msg}--></td>
								</tr>
							<!--{/if}-->
							<!--{if $show_form}-->
							<tr>
								<td colspan="2" style="padding-left: 10px; padding-top: 25px; padding-bottom: 20px;" align="center">
									<input type="image" src="<!--{ipath name="bt-aceptar.gif" owner="1" lang="1"}-->" border="0">
								</td>
							</tr>
							<!--{/if}-->
						</table>
					</form>
				</td></tr>
			</tbody>
		</table>
	</body>
</html>
